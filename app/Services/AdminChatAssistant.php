<?php

namespace App\Services;

use App\Jobs\DeleteVillageMediaFile;
use App\Models\User;
use App\Notifications\RequestStatusChanged;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AdminChatAssistant
{
    public function __construct(private AdminChatIntentClassifier $intentClassifier) {}

    /** @return array{id: int, url: string, originalName: string, altText: string, text: string} */
    public function uploadMedia(User $admin, UploadedFile $file, string $altText): array
    {
        $data = Validator::make([
            'file' => $file,
            'altText' => $altText,
        ], [
            'file' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'extensions:jpg,jpeg,png,webp', 'max:5120'],
            'altText' => ['required', 'string', 'max:180'],
        ])->validate();

        $path = $data['file']->store('village-media/'.$admin->village_slug, 'public');
        abort_unless(is_string($path) && $path !== '', 500, 'Berkas tidak dapat disimpan.');

        try {
            $id = DB::table('village_media')->insertGetId([
                'village_slug' => $admin->village_slug,
                'path' => $path,
                'original_name' => $data['file']->getClientOriginalName(),
                'mime_type' => (string) $data['file']->getMimeType(),
                'size' => (int) $data['file']->getSize(),
                'alt_text' => trim($data['altText']),
                'created_at' => now()->utc()->toIso8601String(),
                'updated_at' => now()->utc()->toIso8601String(),
            ]);
        } catch (\Throwable $exception) {
            Storage::disk('public')->delete($path);

            throw $exception;
        }

        return [
            'id' => $id,
            'url' => url('/storage/'.$path),
            'originalName' => $data['file']->getClientOriginalName(),
            'altText' => trim($data['altText']),
            'text' => 'Foto berhasil diunggah ke Media desa.',
        ];
    }

    /**
     * @return array{conversationId: string, text: string, options: array<int, array{number: int, label: string}>}
     */
    public function reply(User $admin, string $conversationId, string $message): array
    {
        $conversation = DB::table('admin_chat_conversations')
            ->where('user_id', $admin->id)
            ->where('conversation_id', $conversationId)
            ->first();

        if (! $conversation) {
            $id = DB::table('admin_chat_conversations')->insertGetId([
                'user_id' => $admin->id,
                'conversation_id' => $conversationId,
                'state' => null,
                'expires_at' => now()->addMinutes(30),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $conversation = DB::table('admin_chat_conversations')->where('id', $id)->first();
        }

        $state = now()->greaterThan($conversation->expires_at) ? null : $this->decodeState((string) $conversation->state);
        $result = is_array($state)
            ? $this->continue($admin, $state, trim($message))
            : $this->start($admin, trim($message));

        DB::table('admin_chat_conversations')->where('id', $conversation->id)->update([
            'state' => isset($result['state'])
                ? json_encode(Crypt::encryptString(json_encode($result['state'], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR)), JSON_THROW_ON_ERROR)
                : null,
            'expires_at' => now()->addMinutes(30),
            'updated_at' => now(),
        ]);

        return [
            'conversationId' => $conversationId,
            'text' => $result['text'],
            'options' => $result['options'] ?? [],
        ];
    }

    /** @return array{resource: string, action: string, confidence: float}|null */
    private function classify(User $admin, string $message): ?array
    {
        return $this->intentClassifier->classify($message, $this->resourceOptions($admin));
    }

    /** @return array<string, mixed> */
    private function start(User $admin, string $message): array
    {
        if ($this->isCancel($message) || $this->isMainMenuRequest($message)) {
            return $this->rootMenu($admin, 'Chat siap. Pilih menu yang ingin dikelola.');
        }
        if (preg_match('/^[1-9][0-9]*$/', $message) === 1) {
            return $this->rootMenu($admin, 'Pilih data yang ingin dikelola:');
        }

        $intent = $this->classify($admin, $message);
        if ($intent !== null && $this->canUseAction($admin, $intent['resource'], $intent['action'])) {
            return $this->beginAction($admin, $intent['resource'], $intent['action']);
        }

        return $this->rootMenu($admin, 'Saya belum mengenali maksudnya. Pilih data yang ingin dikelola:');
    }

    /** @param array<string, mixed> $state
     * @return array<string, mixed>
     */
    private function continue(User $admin, array $state, string $message): array
    {
        if ($this->isMainMenuRequest($message)) {
            return $this->rootMenu($admin, 'Kembali ke menu utama. Isian yang belum disimpan dibuang.');
        }
        if ($this->isCancel($message)) {
            return $this->rootMenu($admin, 'Perubahan dibatalkan. Pilih menu lain:');
        }

        $step = $state['step'] ?? '';
        if ($step === 'switch_confirmation') {
            $selection = $this->selectedOption($message, $state['options'] ?? []);
            if ($selection === null) {
                return $this->optionsResponse($state, 'Pilih 1 untuk pindah menu atau 2 untuk melanjutkan proses sebelumnya.');
            }
            if ($selection['value'] === 'switch') {
                return $this->beginAction($admin, $state['pendingIntent']['resource'], $state['pendingIntent']['action']);
            }

            return $this->resumeState($state['previousState'], 'Baik, kita lanjutkan proses sebelumnya. ');
        }

        if (! in_array($step, ['resource', 'action'], true) && $this->isIntentRequest($message)) {
            $intent = $this->classify($admin, $message);
            if ($intent !== null && $this->canUseAction($admin, $intent['resource'], $intent['action'])) {
                if (($state['resource'] ?? null) === $intent['resource'] && ($state['action'] ?? null) === $intent['action']) {
                    return $this->resumeState($state, 'Proses yang sama masih aktif. ');
                }

                return $this->switchConfirmation($state, $intent);
            }
        }

        if ($step === 'resource') {
            $selection = $this->selectedOption($message, $state['options'] ?? []);
            if ($selection === null) {
                $intent = $this->classify($admin, $message);
                if ($intent !== null && $this->canUseAction($admin, $intent['resource'], $intent['action'])) {
                    return $this->beginAction($admin, $intent['resource'], $intent['action']);
                }

                return $this->rootMenu($admin, 'Pilih nomor menu atau jelaskan permintaannya dengan singkat:');
            }

            return $this->actionMenu($admin, $selection['value']);
        }

        if ($step === 'action') {
            $selection = $this->selectedOption($message, $state['options'] ?? []);
            if ($selection === null) {
                $intent = $this->classify($admin, $message);
                if ($intent !== null && $this->canUseAction($admin, $intent['resource'], $intent['action'])) {
                    return $this->beginAction($admin, $intent['resource'], $intent['action']);
                }

                return $this->actionMenu($admin, $state['resource'], 'Pilih salah satu nomor aksi:');
            }

            return $this->beginAction($admin, $state['resource'], $selection['value']);
        }

        if ($step === 'item') {
            $selection = $this->selectedOption($message, $state['options'] ?? []);
            if ($selection === null) {
                return $this->itemMenu($admin, $state['resource'], $state['action'], 'Pilih nomor data yang tercantum:');
            }

            $state['recordId'] = (int) $selection['value'];
            if ($state['action'] === 'delete') {
                $item = $this->findItem($admin, $state['resource'], $state['recordId']);
                if ($item === null) {
                    return $this->rootMenu($admin, 'Data tidak ditemukan. Pilih menu untuk mencoba lagi:');
                }
                $state['step'] = 'confirm_delete';
                $state['itemLabel'] = $this->displayValue($state['resource'], $item);

                return $this->confirmation($state, 'Hapus '.$state['itemLabel'].'?', '1. Ya, hapus · 2. Batal');
            }

            return $this->fieldMenu($admin, $state);
        }

        if ($step === 'field') {
            $selection = $this->selectedOption($message, $state['options'] ?? []);
            if ($selection === null) {
                return $this->fieldMenu($admin, $state, 'Pilih nomor bagian yang ingin diubah:');
            }

            $state['field'] = $selection['value'];
            $field = $this->field($state['resource'], $state['field'], $admin);
            if ($field['type'] === 'enum') {
                $state['step'] = 'update_value';
                $state['options'] = array_map(fn (string $value): array => ['value' => $value, 'label' => $value], $field['options']);

                return $this->optionsResponse($state, 'Pilih nilai untuk '.$field['label'].':');
            }
            if ($field['type'] === 'boolean') {
                $state['step'] = 'update_value';
                $state['options'] = [
                    ['value' => 'true', 'label' => 'Ya'],
                    ['value' => 'false', 'label' => 'Tidak'],
                ];

                return $this->optionsResponse($state, 'Atur '.$field['label'].':');
            }

            $state['step'] = 'update_value';

            return $this->response($state, 'Ketik nilai baru untuk '.$field['label'].'.'.($field['type'] === 'date' ? ' Format tanggal: YYYY-MM-DD.' : ''));
        }

        if ($step === 'create_value') {
            $field = $this->field($state['resource'], $state['field'], $admin);
            $selection = $this->selectedOption($message, $state['options'] ?? []);
            if ($field['type'] === 'boolean' && $selection !== null) {
                $message = (string) $selection['value'];
            } elseif (! $field['required'] && in_array(mb_strtolower($message), ['lewati', 'skip', '-'], true)) {
                $message = '';
            }

            $value = $this->parseValue($message, $field);
            if (! $field['required'] && $value === '') {
                $value = null;
            }
            $validation = Validator::make([$field['key'] => $value], [$field['key'] => $field['rule']]);
            if ($validation->fails()) {
                return $this->askForField($state, $field, 'Nilai belum sesuai. '.$field['label'].':');
            }

            if ($value !== '' && $value !== null) {
                $state['payload'][$field['key']] = $value;
            }
            $state['fieldIndex']++;

            return $this->nextCreateField($state);
        }

        if ($step === 'update_value') {
            $field = $this->field($state['resource'], $state['field'], $admin);
            $selection = $this->selectedOption($message, $state['options'] ?? []);
            if (in_array($field['type'], ['boolean', 'enum'], true) && $selection !== null) {
                $message = (string) $selection['value'];
            }
            $value = $this->parseValue($message, $field);
            if ($state['resource'] === 'requests' && $state['field'] === 'assignedTo' && $value === 'none') {
                $value = null;
            }
            $validation = Validator::make([$field['key'] => $value], [$field['key'] => $field['rule']]);
            if ($validation->fails()) {
                return $this->response($state, 'Nilai belum sesuai untuk '.$field['label'].'. Coba lagi.');
            }

            $state['payload'] = [$field['key'] => $value];
            if ($state['resource'] === 'users' && $field['key'] === 'password') {
                $state['step'] = 'password_confirm_value';

                return $this->response($state, 'Ketik ulang kata sandi baru untuk memastikan kedua isian sama. Kata sandi tidak akan dikirim ke AI.');
            }
            $state['step'] = 'confirm_update';
            $item = $this->findItem($admin, $state['resource'], (int) $state['recordId']);
            $state['itemLabel'] = $item ? $this->displayValue($state['resource'], $item) : 'data terpilih';
            $state['changeLabel'] = $field['key'] === 'password' ? 'Kata sandi baru: disembunyikan' : $field['label'].': '.$this->formatValue($value);

            return $this->confirmation($state, 'Ubah '.$state['itemLabel'].' — '.$state['changeLabel'].'?', '1. Simpan · 2. Batal');
        }

        if ($step === 'password_confirm_value') {
            if (! hash_equals((string) ($state['payload']['password'] ?? ''), trim($message))) {
                unset($state['payload']['password']);
                $state['step'] = 'update_value';

                return $this->response($state, 'Kata sandi tidak sama. Masukkan ulang kata sandi baru.');
            }
            $state['payload']['password_confirmation'] = trim($message);
            $state['step'] = 'confirm_update';
            $item = $this->findItem($admin, $state['resource'], (int) $state['recordId']);
            $state['itemLabel'] = $item ? $this->displayValue($state['resource'], $item) : 'data terpilih';
            $state['changeLabel'] = 'Kata sandi baru: disembunyikan';

            return $this->confirmation($state, 'Ubah kata sandi akun '.$state['itemLabel'].'?', '1. Simpan · 2. Batal');
        }

        if (in_array($step, ['confirm_create', 'confirm_update', 'confirm_delete'], true)) {
            $selection = $this->selectedOption($message, $state['options'] ?? []);
            if ($selection === null) {
                return $this->confirmation($state, 'Balas dengan nomor konfirmasi:', '1. Ya · 2. Batal');
            }
            if ($selection['value'] !== 'confirm') {
                return $this->rootMenu($admin, 'Perubahan dibatalkan. Pilih menu lain:');
            }

            try {
                $result = $this->commit($admin, $state);
            } catch (ValidationException $exception) {
                return $this->rootMenu($admin, 'Data belum dapat disimpan: '.implode(' ', $exception->validator->errors()->all()).' Pilih menu untuk memperbaiki data:');
            }

            return $this->rootMenu($admin, $result.' Pilih menu lain atau lanjutkan permintaan berikutnya:');
        }

        return $this->rootMenu($admin, 'Sesi percakapan dimulai ulang. Pilih menu yang ingin dikelola:');
    }

    /** @return array<string, mixed> */
    private function rootMenu(User $admin, string $text): array
    {
        $options = $this->resourceOptions($admin);
        $stateOptions = array_map(fn (array $option): array => ['value' => $option['value'], 'label' => $option['label']], $options);
        $state = ['step' => 'resource', 'options' => $stateOptions];

        return $this->optionsResponse($state, $text);
    }

    /** @return array<string, mixed> */
    private function actionMenu(User $admin, string $resource, string $text = 'Pilih aksi:'): array
    {
        $actions = $this->actionsFor($admin, $resource);
        $options = array_map(fn (string $action): array => [
            'value' => $action,
            'label' => $this->actionLabel($action),
        ], $actions);
        $state = ['step' => 'action', 'resource' => $resource, 'options' => $options];

        return $this->optionsResponse($state, $text);
    }

    /** @return array<string, mixed> */
    private function beginAction(User $admin, string $resource, string $action): array
    {
        if (! $this->canUseAction($admin, $resource, $action)) {
            return $this->rootMenu($admin, 'Aksi itu tidak tersedia untuk akun ini. Pilih menu lain:');
        }

        if ($resource === 'analytics') {
            return $this->analytics($admin);
        }

        if ($action === 'list') {
            $items = $this->items($admin, $resource);
            $lines = $items === [] ? 'Belum ada data.' : implode("\n", array_map(
                fn (array $item, int $index): string => ($index + 1).'. '.$this->displayValue($resource, $item),
                $items,
                array_keys($items),
            ));
            $state = ['step' => 'action', 'resource' => $resource, 'options' => $this->optionsForActions($admin, $resource)];

            return $this->optionsResponse($state, $lines."\n\nPilih aksi berikutnya:");
        }

        if ($action === 'create') {
            $state = ['step' => 'create_value', 'resource' => $resource, 'action' => $action, 'fieldIndex' => 0, 'payload' => []];

            return $this->nextCreateField($state);
        }

        return $this->itemMenu($admin, $resource, $action);
    }

    /** @return array<string, mixed> */
    private function itemMenu(User $admin, string $resource, string $action, string $prefix = ''): array
    {
        $items = $this->items($admin, $resource);
        if ($items === []) {
            return $this->actionMenu($admin, $resource, $prefix.'Belum ada data yang bisa dipilih.');
        }

        $options = [];
        foreach ($items as $index => $item) {
            $options[] = ['value' => (string) $item['id'], 'label' => $this->displayValue($resource, $item)];
        }
        $state = ['step' => 'item', 'resource' => $resource, 'action' => $action, 'options' => $options];

        return $this->optionsResponse($state, $prefix.'Pilih data yang ingin '.$this->actionVerb($action).':');
    }

    /** @param array<string, mixed> $state
     * @return array<string, mixed>
     */
    private function fieldMenu(User $admin, array $state, string $prefix = ''): array
    {
        $item = $this->findItem($admin, $state['resource'], (int) $state['recordId']);
        if ($item === null) {
            return $this->rootMenu($admin, 'Data tidak ditemukan. Pilih menu untuk mencoba lagi:');
        }
        $fields = $this->fields($state['resource']);
        if ($state['resource'] === 'users') {
            $fields = array_values(array_filter($fields, fn (array $field): bool => in_array($field['key'], ['role', 'active', 'password'], true)));
        }
        $state['step'] = 'field';
        $state['options'] = array_map(fn (array $field): array => ['value' => $field['key'], 'label' => $field['label']], $fields);

        return $this->optionsResponse($state, $prefix.'Data '.$this->displayValue($state['resource'], $item).'. Bagian mana yang ingin diubah?');
    }

    /** @param array<string, mixed> $state
     * @return array<string, mixed>
     */
    private function nextCreateField(array $state): array
    {
        $fields = $this->fields($state['resource']);
        while (($fields[$state['fieldIndex']] ?? null) !== null && ! $fields[$state['fieldIndex']]['create']) {
            $state['fieldIndex']++;
        }
        $field = $fields[$state['fieldIndex']] ?? null;
        if ($field === null) {
            $summary = [];
            foreach ($fields as $item) {
                if (array_key_exists($item['key'], $state['payload'])) {
                    $summary[] = $item['label'].': '.$this->formatValue($state['payload'][$item['key']]);
                }
            }
            $state['step'] = 'confirm_create';
            $state['options'] = [['value' => 'confirm', 'label' => 'Simpan'], ['value' => 'cancel', 'label' => 'Batal']];

            return $this->optionsResponse($state, "Periksa data ini:\n".implode("\n", $summary)."\nSimpan?");
        }

        $state['field'] = $field['key'];

        return $this->askForField($state, $field, 'Isi '.$field['label'].($field['required'] ? ':' : ' (opsional; balas “lewati” jika kosong):'));
    }

    /** @param array<string, mixed> $state
     * @param  array<string, mixed>  $field
     * @return array<string, mixed>
     */
    private function askForField(array $state, array $field, string $text): array
    {
        if ($field['type'] === 'boolean') {
            $state['options'] = [['value' => 'true', 'label' => 'Ya'], ['value' => 'false', 'label' => 'Tidak']];

            return $this->optionsResponse($state, $text);
        }

        return $this->response($state, $text);
    }

    /** @return array<string, mixed> */
    private function confirmation(array $state, string $text, string $labels): array
    {
        $state['options'] = [['value' => 'confirm', 'label' => 'Ya'], ['value' => 'cancel', 'label' => 'Batal']];

        return $this->optionsResponse($state, $text.' '.$labels);
    }

    /** @return array<string, mixed> */
    private function response(array $state, string $text): array
    {
        $state['prompt'] = $text;

        return ['state' => $state, 'text' => $text, 'options' => []];
    }

    /** @return array<string, mixed> */
    private function optionsResponse(array $state, string $text): array
    {
        $state['prompt'] = $text;
        $options = [];
        foreach ($state['options'] ?? [] as $index => $option) {
            $options[] = ['number' => $index + 1, 'label' => $option['label']];
        }

        return ['state' => $state, 'text' => $text, 'options' => $options];
    }

    /** @param array<int, array{value: string, label: string}> $options
     * @return array{value: string, label: string}|null
     */
    private function selectedOption(string $message, array $options): ?array
    {
        $message = mb_strtolower(trim($message));
        if (preg_match('/^[1-9][0-9]*$/', $message) === 1) {
            return $options[(int) $message - 1] ?? null;
        }

        foreach ($options as $option) {
            if (mb_strtolower($option['label']) === $message) {
                return $option;
            }
        }

        return null;
    }

    private function isCancel(string $message): bool
    {
        return in_array(mb_strtolower(trim($message)), ['batal', 'cancel', 'stop', 'keluar'], true);
    }

    private function isMainMenuRequest(string $message): bool
    {
        return in_array(mb_strtolower(trim($message)), ['menu', 'menu utama', 'kembali ke menu', 'main menu'], true);
    }

    private function isIntentRequest(string $message): bool
    {
        return preg_match('/\b(tambah|buat|ubah|ganti|edit|hapus|lihat|daftar|tampilkan|kelola|cek)\b/iu', $message) === 1;
    }

    /**
     * @param  array<string, mixed>  $state
     * @param  array{resource: string, action: string, confidence: float}  $intent
     * @return array<string, mixed>
     */
    private function switchConfirmation(array $state, array $intent): array
    {
        $nextState = [
            'step' => 'switch_confirmation',
            'previousState' => $state,
            'pendingIntent' => $intent,
            'options' => [
                ['value' => 'switch', 'label' => 'Pindah menu'],
                ['value' => 'resume', 'label' => 'Lanjutkan proses sekarang'],
            ],
        ];

        return $this->optionsResponse(
            $nextState,
            'Proses '.($state['resource'] ?? 'saat ini').' belum selesai. Anda meminta '.$intent['resource'].' — '.$this->actionLabel($intent['action']).'. Pilih 1 untuk membuang isian lama dan pindah, atau 2 untuk melanjutkan proses lama.',
        );
    }

    /**
     * @param  array<string, mixed>  $state
     * @return array<string, mixed>
     */
    private function resumeState(array $state, string $prefix = ''): array
    {
        $prompt = (string) ($state['prompt'] ?? 'Lanjutkan dari langkah terakhir.');
        if (($state['options'] ?? []) !== []) {
            return $this->optionsResponse($state, $prefix.$prompt);
        }

        return $this->response($state, $prefix.$prompt);
    }

    private function actionLabel(string $action): string
    {
        return ['list' => 'Lihat daftar', 'create' => 'Tambah', 'update' => 'Ubah', 'delete' => 'Hapus', 'analytics' => 'Lihat ringkasan'][$action] ?? $action;
    }

    private function actionVerb(string $action): string
    {
        return ['update' => 'diubah', 'delete' => 'dihapus'][$action] ?? 'dipilih';
    }

    /** @return array<int, array{value: string, label: string}> */
    private function optionsForActions(User $admin, string $resource): array
    {
        return array_map(fn (string $action): array => ['value' => $action, 'label' => $this->actionLabel($action)], $this->actionsFor($admin, $resource));
    }

    /** @return array<int, array{value: string, label: string}> */
    private function resourceOptions(User $admin): array
    {
        $resources = [
            ['value' => 'officials', 'label' => 'Perangkat desa'],
            ['value' => 'news', 'label' => 'Berita'],
            ['value' => 'activities', 'label' => 'Kegiatan desa'],
            ['value' => 'services', 'label' => 'Layanan'],
            ['value' => 'projects', 'label' => 'Papan proyek'],
            ['value' => 'budgets', 'label' => 'APBDes'],
            ['value' => 'proposals', 'label' => 'Usulan warga'],
            ['value' => 'requests', 'label' => 'Permohonan layanan'],
            ['value' => 'media', 'label' => 'Media desa'],
            ['value' => 'analytics', 'label' => 'Analitik'],
        ];
        if ($admin->village_slug === 'curahsawo') {
            array_splice($resources, 1, 0, [['value' => 'village_head', 'label' => 'Kepala desa']]);
        }
        if ($admin->admin_role === 'owner') {
            $resources[] = ['value' => 'users', 'label' => 'Akun admin'];
        }

        return $resources;
    }

    /** @return array<int, string> */
    private function actionsFor(User $admin, string $resource): array
    {
        $actions = match ($resource) {
            'officials', 'news', 'activities', 'services', 'projects', 'budgets' => ['list', 'create', 'update', 'delete'],
            'village_head' => ['update'],
            'proposals' => ['list', 'update', 'delete'],
            'requests' => ['list', 'update'],
            'media' => ['list', 'delete'],
            'analytics' => ['analytics'],
            'users' => $admin->admin_role === 'owner' ? ['list', 'create', 'update'] : [],
            default => [],
        };

        return $actions;
    }

    private function canUseAction(User $admin, string $resource, string $action): bool
    {
        return in_array($action, $this->actionsFor($admin, $resource), true);
    }

    /** @return array<int, array<string, mixed>> */
    private function fields(string $resource): array
    {
        $text = fn (string $key, string $label, string $rule, bool $required = true, bool $create = true): array => compact('key', 'label', 'rule', 'required', 'create') + ['type' => 'text'];
        $bool = fn (string $key, string $label, bool $create = true): array => ['key' => $key, 'label' => $label, 'rule' => 'boolean', 'required' => false, 'create' => $create, 'type' => 'boolean'];
        $number = fn (string $key, string $label, string $rule, bool $required = false): array => ['key' => $key, 'label' => $label, 'rule' => $rule, 'required' => $required, 'create' => true, 'type' => 'number'];

        return match ($resource) {
            'officials' => [
                $text('name', 'Nama', 'required|string|max:180'),
                $text('position', 'Jabatan', 'required|string|max:180'),
                ['key' => 'imageUrl', 'label' => 'URL foto', 'rule' => 'nullable|url:http,https|max:500', 'required' => false, 'create' => true, 'type' => 'url'],
                $bool('published', 'Tampilkan di website'),
                $number('sortOrder', 'Urutan tampil', 'nullable|integer|min:0|max:9999'),
            ],
            'village_head' => [$text('name', 'Nama kepala desa', 'required|string|max:180')],
            'news', 'activities', 'services' => [
                $text('title', 'Judul', 'required|string|max:180'),
                $text('summary', 'Ringkasan', 'nullable|string|max:300', false),
                $text('body', 'Isi', 'required|string|max:5000'),
                $text('category', 'Kategori', 'nullable|string|max:80', false),
                ['key' => 'link', 'label' => 'Tautan informasi', 'rule' => 'nullable|url:http,https|max:500', 'required' => false, 'create' => true, 'type' => 'url'],
                ['key' => 'imageUrl', 'label' => 'URL gambar', 'rule' => 'nullable|url:http,https|max:500', 'required' => false, 'create' => true, 'type' => 'url'],
                $bool('published', 'Terbitkan di website'),
                $number('sortOrder', 'Urutan tampil', 'nullable|integer|min:0|max:9999'),
                ['key' => 'publishedAt', 'label' => 'Tanggal publikasi (YYYY-MM-DD)', 'rule' => 'nullable|date_format:Y-m-d', 'required' => false, 'create' => true, 'type' => 'date'],
            ],
            'projects' => [
                $text('title', 'Nama proyek', 'required|string|max:200'),
                $text('location', 'Lokasi', 'required|string|max:200'),
                $number('year', 'Tahun', 'required|integer|min:2000|max:2100', true),
                ['key' => 'latitude', 'label' => 'Latitude', 'rule' => 'nullable|numeric|between:-90,90', 'required' => false, 'create' => true, 'type' => 'decimal'],
                ['key' => 'longitude', 'label' => 'Longitude', 'rule' => 'nullable|numeric|between:-180,180', 'required' => false, 'create' => true, 'type' => 'decimal'],
                $number('progress', 'Progres persen', 'nullable|integer|min:0|max:100'),
                $text('status', 'Status', 'nullable|string|max:120', false),
                $text('summary', 'Ringkasan', 'nullable|string|max:500', false),
                $text('details', 'Rincian', 'nullable|string|max:5000', false),
                $text('volume', 'Volume', 'nullable|string|max:200', false),
                $text('funding', 'Sumber dana', 'nullable|string|max:200', false),
                $text('executor', 'Pelaksana', 'nullable|string|max:200', false),
                $text('schedule', 'Jadwal', 'nullable|string|max:200', false),
                $number('spent', 'Realisasi biaya', 'nullable|integer|min:0'),
                $text('source', 'Sumber informasi', 'nullable|string|max:300', false),
                ['key' => 'sourceUrl', 'label' => 'URL sumber', 'rule' => 'nullable|url:http,https|max:500', 'required' => false, 'create' => true, 'type' => 'url'],
                $bool('published', 'Tampilkan di website'),
            ],
            'budgets' => [
                $number('year', 'Tahun', 'required|integer|min:2000|max:2100', true),
                $number('revenue', 'Pendapatan', 'nullable|integer|min:0'),
                $number('expenditure', 'Belanja', 'nullable|integer|min:0'),
                $number('financing', 'Pembiayaan', 'nullable|integer|min:0'),
                $number('villageFund', 'Dana desa', 'nullable|integer|min:0'),
                $number('villageAllocation', 'Alokasi dana desa', 'nullable|integer|min:0'),
                $number('taxRevenueShare', 'Bagi hasil pajak', 'nullable|integer|min:0'),
                $number('retributionShare', 'Bagi hasil retribusi', 'nullable|integer|min:0'),
                $number('realized', 'Realisasi', 'nullable|integer|min:0'),
                $text('notes', 'Catatan', 'nullable|string|max:2000', false),
                ['key' => 'sourceUrl', 'label' => 'URL sumber', 'rule' => 'nullable|url:http,https|max:500', 'required' => false, 'create' => true, 'type' => 'url'],
                $bool('published', 'Tampilkan di website'),
            ],
            'proposals' => [
                ['key' => 'status', 'label' => 'Status', 'rule' => 'required|in:Masuk,Ditinjau,Direncanakan,Selesai,Ditolak', 'required' => true, 'create' => false, 'type' => 'enum', 'options' => ['Masuk', 'Ditinjau', 'Direncanakan', 'Selesai', 'Ditolak']],
                $text('adminNote', 'Catatan admin', 'nullable|string|max:3000', false, false),
            ],
            'requests' => [
                ['key' => 'status', 'label' => 'Status', 'rule' => 'required|in:Masuk,Ditinjau,Diproses,Selesai,Ditolak', 'required' => true, 'create' => false, 'type' => 'enum', 'options' => ['Masuk', 'Ditinjau', 'Diproses', 'Selesai', 'Ditolak']],
                $text('adminNote', 'Catatan admin', 'nullable|string|max:3000', false, false),
                ['key' => 'targetAt', 'label' => 'Target tanggal (YYYY-MM-DD)', 'rule' => 'nullable|date_format:Y-m-d', 'required' => false, 'create' => false, 'type' => 'date'],
                ['key' => 'assignedTo', 'label' => 'Petugas', 'rule' => 'nullable|integer', 'required' => false, 'create' => false, 'type' => 'enum', 'options' => []],
            ],
            'users' => [
                $text('name', 'Nama', 'required|string|max:120'),
                $text('username', 'Username', 'required|string|min:3|max:60|regex:/^[a-zA-Z0-9._-]+$/|unique:users,username'),
                ['key' => 'email', 'label' => 'Email', 'rule' => 'required|email|max:180|unique:users,email', 'required' => true, 'create' => true, 'type' => 'email'],
                ['key' => 'role', 'label' => 'Peran admin', 'rule' => 'required|in:owner,editor', 'required' => true, 'create' => false, 'type' => 'enum', 'options' => ['owner', 'editor']],
                $bool('active', 'Akun aktif', false),
                ['key' => 'password', 'label' => 'Kata sandi baru', 'rule' => 'nullable|string|min:12', 'required' => false, 'create' => false, 'type' => 'password'],
            ],
            default => [],
        };
    }

    /** @return array<string, mixed> */
    private function field(string $resource, string $key, ?User $admin = null): array
    {
        foreach ($this->fields($resource) as $field) {
            if ($field['key'] === $key) {
                if ($resource === 'requests' && $key === 'assignedTo' && $admin !== null) {
                    $field['options'] = [['value' => 'none', 'label' => 'Tanpa petugas']];
                    foreach (DB::table('users')->where('is_admin', true)->where('is_active', true)
                        ->where('village_slug', $admin->village_slug)->orderBy('name')->get(['id', 'name']) as $user) {
                        $field['options'][] = ['value' => (string) $user->id, 'label' => $user->name];
                    }
                }

                return $field;
            }
        }

        abort(422, 'Bagian data tidak tersedia.');
    }

    private function parseValue(string $message, array $field): mixed
    {
        $value = trim($message);
        if ($field['type'] === 'boolean') {
            $normalized = mb_strtolower($value);
            if (in_array($normalized, ['1', 'ya', 'iya', 'aktif', 'terbit', 'tampilkan', 'true'], true)) {
                return true;
            }
            if (in_array($normalized, ['0', 'tidak', 'nonaktif', 'draft', 'sembunyikan', 'false'], true)) {
                return false;
            }

            return $value;
        }
        if ($field['type'] === 'number') {
            return preg_replace('/[^0-9-]/', '', str_replace('.', '', $value)) ?? $value;
        }
        if ($field['type'] === 'decimal') {
            return str_replace(',', '.', $value);
        }
        if ($field['type'] === 'email') {
            return mb_strtolower($value);
        }

        return $value;
    }

    private function formatValue(mixed $value): string
    {
        if (is_bool($value)) {
            return $value ? 'Ya' : 'Tidak';
        }

        return (string) $value;
    }

    /** @return array<string, mixed> */
    private function catalog(string $resource): array
    {
        $catalog = [
            'officials' => ['table' => 'village_officials', 'label' => 'Perangkat desa', 'display' => ['name', 'position'], 'scope' => 'village_slug'],
            'news' => ['table' => 'village_content', 'label' => 'Berita', 'display' => ['title'], 'scope' => 'village_slug', 'type' => 'news'],
            'activities' => ['table' => 'village_content', 'label' => 'Kegiatan desa', 'display' => ['title'], 'scope' => 'village_slug', 'type' => 'activity'],
            'services' => ['table' => 'village_content', 'label' => 'Layanan', 'display' => ['title'], 'scope' => 'village_slug', 'type' => 'service'],
            'projects' => ['table' => 'projects', 'label' => 'Proyek', 'display' => ['title', 'year', 'status'], 'scope' => 'village_slug'],
            'budgets' => ['table' => 'budgets', 'label' => 'APBDes', 'display' => ['year'], 'scope' => 'village_slug'],
            'proposals' => ['table' => 'proposals', 'label' => 'Usulan warga', 'display' => ['title', 'status'], 'scope' => 'village_slug'],
            'requests' => ['table' => 'village_requests', 'label' => 'Permohonan layanan', 'display' => ['title', 'status'], 'scope' => 'village_slug'],
            'media' => ['table' => 'village_media', 'label' => 'Media desa', 'display' => ['original_name', 'alt_text'], 'scope' => 'village_slug'],
            'users' => ['table' => 'users', 'label' => 'Akun admin', 'display' => ['name', 'username'], 'scope' => 'village_slug'],
        ];

        return $catalog[$resource] ?? [];
    }

    /** @return array<int, array<string, mixed>> */
    private function items(User $admin, string $resource): array
    {
        if ($resource === 'village_head') {
            $row = DB::table('village_heads')->where('village_slug', $admin->village_slug)->first();

            return $row ? [(array) $row + ['id' => 1]] : [];
        }
        if ($resource === 'analytics') {
            return [];
        }

        $catalog = $this->catalog($resource);
        $query = DB::table($catalog['table'])->where($catalog['scope'], $admin->village_slug);
        if (isset($catalog['type'])) {
            $query->where('type', $catalog['type']);
        }
        if ($resource === 'users') {
            $query->where('is_admin', true);
        }

        return $query->orderByDesc('id')->limit(30)->get()->map(fn (object $row): array => (array) $row)->all();
    }

    /** @return array<string, mixed>|null */
    private function findItem(User $admin, string $resource, int $id): ?array
    {
        foreach ($this->items($admin, $resource) as $item) {
            if ((int) ($item['id'] ?? 1) === $id) {
                return $item;
            }
        }

        return null;
    }

    /** @param array<string, mixed> $item */
    private function displayValue(string $resource, array $item): string
    {
        $columns = $this->catalog($resource)['display'] ?? ['name'];

        return implode(' · ', array_filter(array_map(fn (string $column): string => (string) ($item[$column] ?? ''), $columns)));
    }

    /** @return array<string, mixed> */
    private function analytics(User $admin): array
    {
        $start = now()->subDays(29)->toDateString();
        $today = now()->toDateString();
        $query = DB::table('village_page_views')->where('village_slug', $admin->village_slug)->whereBetween('view_date', [$start, $today]);
        $totalViews = (int) (clone $query)->sum('views');
        $todayViews = (int) DB::table('village_page_views')->where('village_slug', $admin->village_slug)->where('view_date', $today)->sum('views');
        $dailyViews = (clone $query)->select('view_date')->selectRaw('SUM(views) as views')
            ->groupBy('view_date')->orderBy('view_date')->get();
        $popularPages = (clone $query)->select('path')->selectRaw('SUM(views) as views')
            ->groupBy('path')->orderByDesc('views')->limit(5)->get();
        $dailySummary = $dailyViews->map(fn (object $row): string => $row->view_date.': '.$row->views)->implode(' · ');
        $pageSummary = $popularPages->map(fn (object $row): string => $row->path.' ('.$row->views.')')->implode(' · ');
        $text = 'Tampilan 30 hari: '.$totalViews.'. Hari ini: '.$todayViews.'.';
        if ($dailySummary !== '') {
            $text .= ' Harian: '.$dailySummary.'.';
        }
        if ($pageSummary !== '') {
            $text .= ' Halaman terbanyak: '.$pageSummary.'.';
        }

        return $this->rootMenu($admin, $text.' Pilih menu lain:');
    }

    private function commit(User $admin, array $state): string
    {
        $resource = $state['resource'];
        $action = $state['action'];
        if ($action === 'delete') {
            if ($resource === 'village_head' || $resource === 'users') {
                abort(403, 'Data ini tidak dapat dihapus lewat chat.');
            }
            $catalog = $this->catalog($resource);
            $query = DB::table($catalog['table'])->where('id', $state['recordId'])->where('village_slug', $admin->village_slug);
            if (isset($catalog['type'])) {
                $query->where('type', $catalog['type']);
            }
            $media = $resource === 'media' ? $query->first() : null;
            abort_unless($query->delete(), 404, 'Data tidak ditemukan.');
            if ($media) {
                DeleteVillageMediaFile::dispatch($media->path);
            }

            return 'Data berhasil dihapus.';
        }

        $values = $this->validatedPayload($admin, $resource, $state['payload'] ?? [], $action);
        if ($resource === 'village_head') {
            abort_unless($admin->village_slug === 'curahsawo', 403);
            $headExists = DB::table('village_heads')->where('village_slug', $admin->village_slug)->exists();
            $headValues = ['name' => $values['name'], 'updated_at' => now()];
            if (! $headExists) {
                $headValues['created_at'] = now();
            }
            DB::table('village_heads')->updateOrInsert(['village_slug' => $admin->village_slug], $headValues);

            return 'Nama kepala desa berhasil diperbarui.';
        }
        if ($resource === 'users') {
            return $this->saveAdminUser($admin, $action, $state, $values);
        }

        $catalog = $this->catalog($resource);
        $columns = $this->toColumns($resource, $values);
        if ($action === 'create') {
            $columns = array_replace($this->createDefaults($resource), $columns);
            $columns[$catalog['scope']] = $admin->village_slug;
            if (isset($catalog['type'])) {
                $columns['type'] = $catalog['type'];
            }
            if (in_array($resource, ['officials', 'news', 'activities', 'services'], true)) {
                $columns['created_at'] = now();
                $columns['updated_at'] = now();
            } elseif ($resource === 'projects') {
                $columns['created_at'] = now()->utc()->toIso8601String();
            }
            DB::table($catalog['table'])->insert($columns);
        } else {
            $query = DB::table($catalog['table'])->where('id', $state['recordId'])->where($catalog['scope'], $admin->village_slug);
            if (isset($catalog['type'])) {
                $query->where('type', $catalog['type']);
            }
            abort_unless($query->exists(), 404, 'Data tidak ditemukan.');
            if (in_array($resource, ['officials', 'news', 'activities', 'services', 'requests'], true)) {
                $columns['updated_at'] = now();
            }
            if ($resource === 'requests') {
                $this->updateRequest($admin, (int) $state['recordId'], $columns);
            } else {
                $query->update($columns);
            }
        }

        return $action === 'create' ? 'Data berhasil ditambahkan.' : 'Perubahan berhasil disimpan.';
    }

    /** @param array<string, mixed> $payload
     * @return array<string, mixed>
     */
    private function validatedPayload(User $admin, string $resource, array $payload, string $action): array
    {
        $fields = array_filter($this->fields($resource), fn (array $field): bool => $action === 'create' ? $field['create'] : true);
        $rules = [];
        foreach ($fields as $field) {
            $rule = $field['rule'];
            if ($action === 'create' && $field['required']) {
                $rules[$field['key']] = $rule;
            } else {
                $rules[$field['key']] = preg_replace('/(^|\|)required(\||$)/', '$1nullable$2', $rule) ?? $rule;
            }
        }
        if ($resource === 'budgets' && $action === 'create') {
            $rules['year'] = ['required', 'integer', 'min:2000', 'max:2100', Rule::unique('budgets', 'year')->where('village_slug', $admin->village_slug)];
        }
        if ($resource === 'users' && $action === 'update' && isset($payload['password'])) {
            $rules['password_confirmation'] = ['required', 'same:password'];
        }
        if ($resource === 'requests' && array_key_exists('assignedTo', $payload)) {
            $rules['assignedTo'] = ['nullable', 'integer', Rule::exists('users', 'id')
                ->where('is_admin', true)->where('is_active', true)->where('village_slug', $admin->village_slug)];
        }
        $validator = Validator::make($payload, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    /** @return array<string, mixed> */
    private function createDefaults(string $resource): array
    {
        return match ($resource) {
            'officials' => ['image_url' => null, 'published' => true, 'sort_order' => 0],
            'news', 'activities', 'services' => [
                'summary' => '', 'category' => '', 'link' => '', 'image_url' => '',
                'published' => false, 'sort_order' => 0, 'published_at' => null, 'metadata' => null,
            ],
            'projects' => [
                'status' => '', 'summary' => '', 'details' => '', 'volume' => '', 'funding' => '',
                'executor' => '', 'schedule' => '', 'progress' => 0, 'spent' => 0, 'source' => '',
                'source_url' => '', 'published' => false,
            ],
            'budgets' => [
                'revenue' => 0, 'expenditure' => 0, 'financing' => 0, 'village_fund' => 0,
                'village_allocation' => 0, 'tax_revenue_share' => 0, 'retribution_share' => 0,
                'realized' => 0, 'notes' => '', 'source_url' => '', 'published' => false,
            ],
            default => [],
        };
    }

    /** @param array<string, mixed> $values
     * @return array<string, mixed>
     */
    private function toColumns(string $resource, array $values): array
    {
        $mapping = [
            'imageUrl' => 'image_url', 'sortOrder' => 'sort_order', 'publishedAt' => 'published_at',
            'adminNote' => 'admin_note', 'targetAt' => 'target_at', 'villageFund' => 'village_fund',
            'villageAllocation' => 'village_allocation', 'taxRevenueShare' => 'tax_revenue_share',
            'retributionShare' => 'retribution_share', 'sourceUrl' => 'source_url', 'assignedTo' => 'assigned_to_user_id',
        ];
        $columns = [];
        foreach ($values as $key => $value) {
            $column = $mapping[$key] ?? Str::snake($key);
            if ($key === 'active') {
                $column = 'is_active';
            }
            if ($resource === 'users' && $key === 'role') {
                $column = 'admin_role';
            }
            if (in_array($key, ['publishedAt', 'targetAt'], true) && ($value === '' || $value === null)) {
                $columns[$column] = null;
            } elseif ($key === 'imageUrl' && ($value === '' || $value === null)) {
                $columns[$column] = '';
            } else {
                $columns[$column] = $value === '' ? '' : $value;
            }
        }

        return $columns;
    }

    /** @param array<string, mixed> $state
     * @param  array<string, mixed>  $values
     */
    private function saveAdminUser(User $admin, string $action, array $state, array $values): string
    {
        abort_unless($admin->admin_role === 'owner', 403);
        if ($action === 'create') {
            $values['password'] = Str::random(24);
            $values['village_slug'] = $admin->village_slug;
            $values['is_admin'] = true;
            $values['admin_role'] = 'editor';
            $values['is_active'] = true;
            $user = User::query()->create($values);

            return 'Akun '.$user->username.' dibuat. Kata sandi sementara (tampilkan sekali): '.$values['password'];
        }

        $password = $values['password'] ?? null;
        unset($values['password'], $values['password_confirmation']);
        $columns = $this->toColumns('users', $values);
        if ($password !== null) {
            $columns['password'] = $password;
        }
        DB::transaction(function () use ($admin, $columns, $state): void {
            DB::table('village_pages')->where('slug', $admin->village_slug)->lockForUpdate()->first();
            $target = User::query()->whereKey($state['recordId'])->where('is_admin', true)
                ->where('village_slug', $admin->village_slug)->firstOrFail();
            abort_unless($target->id !== $admin->id, 400, 'Akun yang sedang digunakan tidak dapat diubah dari chat.');

            if ($target->admin_role === 'owner' && (($columns['admin_role'] ?? 'owner') !== 'owner' || ! ($columns['is_active'] ?? true))) {
                $otherOwners = User::query()->where('is_admin', true)->where('is_active', true)->where('admin_role', 'owner')
                    ->where('village_slug', $admin->village_slug)->whereKeyNot($target->id)->count();
                abort_if($otherOwners < 1, 409, 'Desa harus memiliki setidaknya satu admin pemilik yang aktif.');
            }

            $target->fill($columns)->save();
        });

        return 'Perubahan akun admin berhasil disimpan.';
    }

    /** @return array<string, mixed>|null */
    private function decodeState(string $storedState): ?array
    {
        if ($storedState === '') {
            return null;
        }

        try {
            $encryptedState = json_decode($storedState, true, 512, JSON_THROW_ON_ERROR);
            if (! is_string($encryptedState)) {
                return null;
            }
            $state = json_decode(Crypt::decryptString($encryptedState), true, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable) {
            return null;
        }

        return is_array($state) ? $state : null;
    }

    /** @param array<string, mixed> $columns */
    private function updateRequest(User $admin, int $requestId, array $columns): void
    {
        $requestItem = DB::table('village_requests')->where('id', $requestId)
            ->where('village_slug', $admin->village_slug)->first();
        abort_unless($requestItem, 404, 'Permohonan tidak ditemukan.');

        DB::transaction(function () use ($admin, $columns, $requestId, $requestItem): void {
            DB::table('village_requests')->where('id', $requestId)->where('village_slug', $admin->village_slug)->update($columns);
            if (($columns['status'] ?? $requestItem->status) !== $requestItem->status) {
                DB::table('village_request_status_history')->insert([
                    'village_slug' => $admin->village_slug,
                    'request_id' => $requestId,
                    'status' => $columns['status'],
                    'changed_by_user_id' => $admin->id,
                    'created_at' => now(),
                ]);
            }
        });
        if (($columns['status'] ?? $requestItem->status) !== $requestItem->status
            && $requestItem->notify_by_email && $requestItem->email) {
            Notification::route('mail', $requestItem->email)->notify(new RequestStatusChanged(
                $admin->village_slug,
                $requestItem->tracking_code,
                $requestItem->title,
                $columns['status'],
                trim((string) ($columns['admin_note'] ?? '')),
            ));
        }
    }
}
