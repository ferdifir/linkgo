<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class WhatsAppAdminChatHandler
{
    public function __construct(private AdminChatAssistant $assistant) {}

    /**
     * @param  array<string, mixed>  $message
     */
    public function handle(array $message): void
    {
        $accessToken = (string) config('services.whatsapp.access_token');
        $phoneNumberId = (string) config('services.whatsapp.phone_number_id');
        $apiVersion = (string) config('services.whatsapp.api_version');
        abort_if($accessToken === '' || $phoneNumberId === '' || preg_match('/^v\d+\.\d+$/', $apiVersion) !== 1, 503, 'WhatsApp Cloud API belum dikonfigurasi.');

        $messageId = (string) $message['id'];
        $sender = (string) $message['from'];
        $text = $this->messageText($message);
        $response = DB::transaction(function () use ($messageId, $sender, $text): string {
            DB::table('whatsapp_admin_chat_updates')->where('created_at', '<', now()->subDays(7))->delete();
            DB::table('whatsapp_admin_chat_updates')->insertOrIgnore([
                'message_id' => $messageId,
                'response_text' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $processedMessage = DB::table('whatsapp_admin_chat_updates')
                ->where('message_id', $messageId)
                ->lockForUpdate()
                ->first();

            if ($processedMessage->response_text !== '') {
                return $processedMessage->response_text;
            }

            $admin = User::query()
                ->where('whatsapp_user_id', $sender)
                ->where('is_admin', true)
                ->where('is_active', true)
                ->first();

            if (! $admin || ! DB::table('village_pages')->where('slug', $admin->village_slug)->exists()) {
                $responseText = 'Nomor WhatsApp ini belum ditautkan ke admin desa yang aktif. Nomor Anda: '.$sender.'.';
            } elseif ($text === '') {
                $responseText = 'Kirim pesan teks untuk mengelola data. Unggah gambar melalui menu Media desa di laman admin.';
            } elseif (mb_strlen($text) > 2000) {
                $responseText = 'Pesan terlalu panjang. Batas pesan adalah 2.000 karakter.';
            } else {
                $conversationId = $this->conversationId($admin, $sender);
                $command = preg_match('/^\/(start|help)(?:@\w+)?$/i', $text) === 1
                    ? 'menu utama'
                    : (preg_match('/^\/(cancel|batal)(?:@\w+)?$/i', $text) === 1 ? 'batal' : $text);
                $reply = $this->assistant->reply($admin, $conversationId, $command);
                $responseText = $this->formatReply($reply['text'], $reply['options'] ?? []);
            }

            DB::table('whatsapp_admin_chat_updates')->where('message_id', $messageId)->update([
                'response_text' => $responseText,
                'updated_at' => now(),
            ]);

            return $responseText;
        });

        Http::withToken($accessToken)
            ->acceptJson()
            ->connectTimeout(3)
            ->timeout(8)
            ->post('https://graph.facebook.com/'.$apiVersion.'/'.$phoneNumberId.'/messages', [
                'messaging_product' => 'whatsapp',
                'to' => $sender,
                'type' => 'text',
                'text' => [
                    'preview_url' => false,
                    'body' => $response,
                ],
            ])
            ->throw();
    }

    /** @param array<string, mixed> $message */
    private function messageText(array $message): string
    {
        if (($message['type'] ?? null) === 'text' && is_string($message['text']['body'] ?? null)) {
            return trim($message['text']['body']);
        }

        if (($message['type'] ?? null) === 'interactive') {
            $interactive = $message['interactive'] ?? [];
            $reply = $interactive['button_reply']['title'] ?? $interactive['list_reply']['title'] ?? null;

            return is_string($reply) ? trim($reply) : '';
        }

        if (($message['type'] ?? null) === 'button' && is_string($message['button']['text'] ?? null)) {
            return trim($message['button']['text']);
        }

        return '';
    }

    private function conversationId(User $admin, string $sender): string
    {
        $conversation = DB::table('admin_chat_conversations')
            ->where('user_id', $admin->id)
            ->where('channel', 'whatsapp')
            ->where('channel_key', $sender)
            ->first();

        if ($conversation) {
            return $conversation->conversation_id;
        }

        $conversationId = (string) Str::uuid();
        DB::table('admin_chat_conversations')->insertOrIgnore([
            'user_id' => $admin->id,
            'conversation_id' => $conversationId,
            'state' => null,
            'channel' => 'whatsapp',
            'channel_key' => $sender,
            'expires_at' => now()->addMinutes(30),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return DB::table('admin_chat_conversations')
            ->where('user_id', $admin->id)
            ->where('channel', 'whatsapp')
            ->where('channel_key', $sender)
            ->value('conversation_id');
    }

    /**
     * @param  array<int, array{number: int, label: string}>  $options
     */
    private function formatReply(string $text, array $options): string
    {
        if ($options !== []) {
            $text .= "\n".implode("\n", array_map(
                fn (array $option): string => $option['number'].'. '.$option['label'],
                $options,
            ));
        }

        return mb_substr($text, 0, 4096);
    }
}
