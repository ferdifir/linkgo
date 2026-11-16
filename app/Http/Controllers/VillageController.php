<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginAdminRequest;
use App\Http\Requests\SaveBudgetRequest;
use App\Http\Requests\SaveProjectRequest;
use App\Http\Requests\SaveVillageContentRequest;
use App\Http\Requests\StoreVillageAdminUserRequest;
use App\Http\Requests\StoreVillageRequestRequest;
use App\Http\Requests\UpdateVillageAdminUserRequest;
use App\Http\Requests\UpdateVillageRequestRequest;
use App\Http\Requests\UploadVillageMediaRequest;
use App\Jobs\DeleteVillageMediaFile;
use App\Models\User;
use App\Models\VillageIndex;
use App\Notifications\RequestStatusChanged;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class VillageController
{
    public function show(string $slug): Response
    {
        abort_unless(preg_match('/^[a-z0-9-]+$/', $slug) && view()->exists('desa.'.$slug), 404);
        $this->recordPageView($slug);

        $villageIndexData = VillageIndex::query()
            ->where('village_slug', $slug)
            ->orderByDesc('year')
            ->first();

        return response()->view('desa.'.$slug, compact('villageIndexData'))
            ->header('Content-Type', 'text/html; charset=utf-8');
    }

    public function villageContent(string $slug): JsonResponse
    {
        $page = DB::table('village_pages')->where('slug', $slug)->first();
        abort_if(! $page, 404);
        $content = json_decode($page->body, true);
        abort_if(! is_array($content), 503, 'Konten desa tidak dapat dibaca.');

        $siteContentBody = DB::table('site_content')->where('village_slug', $slug)->value('body');
        if ($siteContentBody !== null) {
            $siteContent = json_decode($siteContentBody, true);
            abort_if(! is_array($siteContent), 503, 'Konten desa tidak dapat dibaca.');
            $content = array_replace($content, $siteContent);
        }

        $content['slug'] = $slug;
        $content['name'] = $page->name;
        $content['projects'] = $this->projects(true, $slug);

        return response()->json($content);
    }

    public function publicManagedContent(string $slug): JsonResponse
    {
        abort_unless(preg_match('/^[a-z0-9-]+$/', $slug) && view()->exists('desa.'.$slug), 404);

        $rows = DB::table('village_content')
            ->where('village_slug', $slug)
            ->where('published', true)
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->get()
            ->map(fn ($row) => $this->formatContent($row));

        return response()->json([
            'news' => $rows->where('type', 'news')->values(),
            'activities' => $rows->where('type', 'activity')->values(),
            'services' => $rows->where('type', 'service')->values(),
            'profile' => $rows->firstWhere('type', 'profile'),
        ]);
    }

    public function storePublicRequest(StoreVillageRequestRequest $request, string $slug): JsonResponse
    {
        abort_unless(preg_match('/^[a-z0-9-]+$/', $slug) && view()->exists('desa.'.$slug), 404);

        if (! $this->sameOrigin($request)) {
            return response()->json(['message' => 'Sumber permintaan tidak valid.'], 403);
        }

        $data = $request->validated();
        if (($data['website'] ?? '') !== '') {
            return response()->json([], 204);
        }

        $key = 'village-request:'.$slug.':'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json(['message' => 'Batas pengiriman tercapai. Silakan coba lagi satu jam mendatang.'], 429);
        }

        RateLimiter::hit($key, 3600);
        $trackingCode = Str::upper(Str::random(10));
        while (DB::table('village_requests')->where('tracking_code', $trackingCode)->exists()) {
            $trackingCode = Str::upper(Str::random(10));
        }

        DB::transaction(function () use ($data, $slug, $trackingCode): void {
            $createdAt = now()->utc()->toIso8601String();
            $requestId = DB::table('village_requests')->insertGetId([
                'village_slug' => $slug,
                'kind' => $data['kind'],
                'tracking_code' => $trackingCode,
                'title' => trim($data['title']),
                'category' => trim((string) ($data['category'] ?? '')),
                'name' => trim((string) ($data['name'] ?? '')),
                'contact' => trim($data['contact']),
                'email' => trim((string) ($data['email'] ?? '')) ?: null,
                'notify_by_email' => (bool) ($data['notifyByEmail'] ?? false),
                'description' => trim($data['description']),
                'status' => 'Masuk',
                'admin_note' => '',
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            DB::table('village_request_status_history')->insert([
                'village_slug' => $slug,
                'request_id' => $requestId,
                'status' => 'Masuk',
                'changed_by_user_id' => null,
                'created_at' => $createdAt,
            ]);
        });

        return response()->json([
            'message' => 'Permintaan diterima. Simpan kode ini untuk ditanyakan kembali kepada pemerintah desa.',
            'trackingCode' => $trackingCode,
        ], 201);
    }

    public function publicRequestStatus(Request $request, string $slug, string $trackingCode): JsonResponse
    {
        abort_unless(preg_match('/^[a-z0-9-]+$/', $slug) && view()->exists('desa.'.$slug), 404);
        abort_unless(preg_match('/^[A-Z0-9]{10}$/i', $trackingCode), 404);

        $key = 'village-request-status:'.$slug.':'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 20)) {
            return response()->json(['message' => 'Terlalu banyak pemeriksaan kode. Coba lagi nanti.'], 429);
        }
        RateLimiter::hit($key, 60);

        $item = DB::table('village_requests')->where('village_slug', $slug)
            ->where('tracking_code', Str::upper($trackingCode))->first(['id', 'title', 'status', 'updated_at']);
        abort_unless($item, 404, 'Kode tiket tidak ditemukan.');

        $history = DB::table('village_request_status_history')->where('village_slug', $slug)
            ->where('request_id', $item->id)->orderBy('created_at')->orderBy('id')->get(['status', 'created_at'])
            ->map(fn ($entry): array => ['status' => $entry->status, 'updatedAt' => $entry->created_at]);

        return response()->json([
            'title' => $item->title,
            'status' => $item->status,
            'updatedAt' => $item->updated_at,
            'history' => $history,
        ]);
    }

    public function villageBudgets(string $slug): JsonResponse
    {
        abort_unless(DB::table('village_pages')->where('slug', $slug)->exists(), 404);

        return response()->json($this->budgets(true, $slug));
    }

    public function login(LoginAdminRequest $request): Response
    {
        if (! $this->sameOrigin($request)) {
            return response('Sumber permintaan tidak valid.', 403);
        }

        $key = 'admin-login:'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response('Terlalu banyak percobaan masuk. Coba lagi nanti.', 429)
                ->header('Retry-After', (string) RateLimiter::availableIn($key));
        }

        $credentials = $request->validated();
        $authenticated = Auth::attempt([
            'username' => $credentials['username'],
            'password' => $credentials['password'],
            'is_admin' => true,
            'is_active' => true,
        ]);
        $account = $authenticated ? $request->user() : null;
        $villageSlug = (string) ($account?->village_slug ?? '');
        $villageExists = $villageSlug !== '' && DB::table('village_pages')->where('slug', $villageSlug)->exists();
        if (! $account || ! $villageExists) {
            Auth::logout();
            RateLimiter::hit($key, 900);

            return response('Nama pengguna atau kata sandi salah.', 401);
        }

        RateLimiter::clear($key);
        $request->session()->regenerate();

        return response()->noContent();
    }

    public function logout(Request $request): Response
    {
        if (! $this->sameOrigin($request)) {
            return response('Sumber permintaan tidak valid.', 403);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->noContent();
    }

    public function adminSession(Request $request): JsonResponse
    {
        $slug = $this->adminVillageSlug($request);
        $village = DB::table('village_pages')->where('slug', $slug)->first();
        $admin = $request->user();
        abort_unless($village, 403);
        abort_unless($admin, 403);

        return response()->json(['slug' => $slug, 'name' => $village->name, 'role' => $admin->admin_role, 'userId' => $admin->id]);
    }

    public function adminAnalytics(Request $request): JsonResponse
    {
        $slug = $this->adminVillageSlug($request);
        $startDate = now()->subDays(29)->toDateString();
        $today = now()->toDateString();
        $query = DB::table('village_page_views')->where('village_slug', $slug)->whereBetween('view_date', [$startDate, $today]);

        return response()->json([
            'periodStart' => $startDate,
            'periodEnd' => $today,
            'totalViews' => (int) (clone $query)->sum('views'),
            'todayViews' => (int) DB::table('village_page_views')->where('village_slug', $slug)->where('view_date', $today)->sum('views'),
            'daily' => (clone $query)->select('view_date')->selectRaw('SUM(views) as views')->groupBy('view_date')->orderBy('view_date')->get(),
            'pages' => (clone $query)->select('path')->selectRaw('SUM(views) as views')->groupBy('path')->orderByDesc('views')->get(),
        ]);
    }

    public function adminContent(Request $request, string $type): JsonResponse
    {
        $this->validateContentType($type);

        $items = DB::table('village_content')
            ->where('village_slug', $this->adminVillageSlug($request))
            ->where('type', $type)
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->get()
            ->map(fn ($row) => $this->formatContent($row));

        return response()->json($items);
    }

    public function createContent(SaveVillageContentRequest $request, string $type): JsonResponse
    {
        $this->validateContentType($type);
        $slug = $this->adminVillageSlug($request);

        if ($type === 'profile') {
            abort_if(DB::table('village_content')->where('village_slug', $slug)->where('type', 'profile')->exists(), 409,
                'Profil desa sudah ada. Ubah data profil yang tersedia.');
        }

        $input = $this->contentInput($request->validated(), $type, $slug);
        $input['created_at'] = now()->utc()->toIso8601String();
        $input['updated_at'] = $input['created_at'];
        $id = DB::table('village_content')->insertGetId($input);

        return response()->json($this->contentRecord($id, $slug, $type), 201);
    }

    public function updateContent(SaveVillageContentRequest $request, string $type, int $id): Response
    {
        $this->validateContentType($type);
        $slug = $this->adminVillageSlug($request);
        abort_unless(DB::table('village_content')->where('id', $id)->where('village_slug', $slug)->where('type', $type)->exists(), 404);

        DB::table('village_content')->where('id', $id)->where('village_slug', $slug)->where('type', $type)
            ->update($this->contentInput($request->validated(), $type, $slug) + ['updated_at' => now()->utc()->toIso8601String()]);

        return response()->noContent();
    }

    public function deleteContent(Request $request, string $type, int $id): Response
    {
        $this->validateContentType($type);
        abort_unless(DB::table('village_content')->where('id', $id)->where('village_slug', $this->adminVillageSlug($request))
            ->where('type', $type)->delete(), 404);

        return response()->noContent();
    }

    public function adminRequests(Request $request): JsonResponse
    {
        $slug = $this->adminVillageSlug($request);
        $rows = DB::table('village_requests')->where('village_slug', $slug)
            ->orderByDesc('created_at')->orderByDesc('id')->get();
        $historyByRequest = DB::table('village_request_status_history')->where('village_slug', $slug)
            ->whereIn('request_id', $rows->pluck('id'))->orderBy('created_at')->orderBy('id')->get()
            ->groupBy('request_id');
        $historyUserIds = $historyByRequest->flatten(1)->pluck('changed_by_user_id')->filter()->unique();
        $historyUsers = User::query()->whereIn('id', $historyUserIds)->get(['id', 'name'])->keyBy('id');
        $items = $rows->map(fn ($row): array => [
            'id' => (int) $row->id,
            'kind' => $row->kind,
            'trackingCode' => $row->tracking_code,
            'title' => $row->title,
            'category' => $row->category,
            'name' => $row->name,
            'contact' => $row->contact,
            'email' => $row->email,
            'notifyByEmail' => (bool) $row->notify_by_email,
            'description' => $row->description,
            'status' => $row->status,
            'adminNote' => $row->admin_note,
            'targetAt' => $row->target_at,
            'assignedTo' => $row->assigned_to_user_id !== null ? (int) $row->assigned_to_user_id : null,
            'history' => ($historyByRequest->get($row->id) ?? collect())->map(fn ($entry): array => [
                'status' => $entry->status,
                'changedBy' => $entry->changed_by_user_id !== null ? $historyUsers->get($entry->changed_by_user_id)?->name : null,
                'updatedAt' => $entry->created_at,
            ])->values(),
            'createdAt' => $row->created_at,
        ]);

        $assignees = User::query()->where('is_admin', true)->where('village_slug', $slug)
            ->orderBy('name')->get(['id', 'name', 'is_active'])->map(fn (User $user): array => [
                'id' => $user->id,
                'name' => $user->name,
                'active' => $user->is_active,
            ]);

        return response()->json(['items' => $items, 'assignees' => $assignees]);
    }

    public function updateRequest(UpdateVillageRequestRequest $request, int $id): Response
    {
        $slug = $this->adminVillageSlug($request);
        $data = $request->validated();
        $requestItem = DB::table('village_requests')->where('id', $id)->where('village_slug', $slug)->first();
        abort_unless($requestItem, 404);
        DB::transaction(function () use ($data, $id, $request, $requestItem, $slug): void {
            $updatedAt = now()->utc()->toIso8601String();
            DB::table('village_requests')->where('id', $id)->where('village_slug', $slug)->update([
                'status' => $data['status'],
                'admin_note' => trim((string) ($data['adminNote'] ?? '')),
                'target_at' => $data['targetAt'] ?? null,
                'assigned_to_user_id' => $data['assignedTo'] ?? null,
                'updated_at' => $updatedAt,
            ]);

            if ($requestItem->status !== $data['status']) {
                DB::table('village_request_status_history')->insert([
                    'village_slug' => $slug,
                    'request_id' => $id,
                    'status' => $data['status'],
                    'changed_by_user_id' => $request->user()->id,
                    'created_at' => $updatedAt,
                ]);
            }
        });

        if ($requestItem->status !== $data['status'] && $requestItem->notify_by_email && $requestItem->email) {
            Notification::route('mail', $requestItem->email)->notify(new RequestStatusChanged(
                $slug,
                $requestItem->tracking_code,
                $requestItem->title,
                $data['status'],
                trim((string) ($data['adminNote'] ?? '')),
            ));
        }

        return response()->noContent();
    }

    public function adminMedia(Request $request): JsonResponse
    {
        $slug = $this->adminVillageSlug($request);
        $items = DB::table('village_media')->where('village_slug', $slug)->orderByDesc('created_at')->orderByDesc('id')
            ->get()->map(fn ($row) => [
                'id' => (int) $row->id,
                'url' => Storage::disk('public')->url($row->path),
                'originalName' => $row->original_name,
                'mimeType' => $row->mime_type,
                'size' => (int) $row->size,
                'altText' => $row->alt_text,
            ]);

        return response()->json($items);
    }

    public function uploadMedia(UploadVillageMediaRequest $request): JsonResponse
    {
        if (! $this->sameOrigin($request)) {
            return response()->json(['message' => 'Sumber permintaan tidak valid.'], 403);
        }

        $data = $request->validated();
        $slug = $this->adminVillageSlug($request);
        $file = $data['file'];
        $path = $file->store('village-media/'.$slug, 'public');
        abort_unless($path, 500, 'Berkas tidak dapat disimpan.');

        try {
            $id = DB::table('village_media')->insertGetId([
                'village_slug' => $slug,
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => (string) $file->getMimeType(),
                'size' => (int) $file->getSize(),
                'alt_text' => trim($data['altText']),
                'created_at' => now()->utc()->toIso8601String(),
                'updated_at' => now()->utc()->toIso8601String(),
            ]);
        } catch (\Throwable $exception) {
            Storage::disk('public')->delete($path);

            throw $exception;
        }
        $media = DB::table('village_media')->where('id', $id)->first();

        return response()->json([
            'id' => (int) $media->id,
            'url' => Storage::disk('public')->url($media->path),
            'originalName' => $media->original_name,
            'mimeType' => $media->mime_type,
            'size' => (int) $media->size,
            'altText' => $media->alt_text,
        ], 201);
    }

    public function deleteMedia(Request $request, int $id): Response
    {
        $media = DB::table('village_media')->where('id', $id)->where('village_slug', $this->adminVillageSlug($request))->first();
        abort_unless($media, 404);
        DB::table('village_media')->where('id', $id)->delete();
        DeleteVillageMediaFile::dispatch($media->path);

        return response()->noContent();
    }

    public function adminUsers(Request $request): JsonResponse
    {
        $admin = $this->authorizeVillageOwner($request);
        $users = User::query()->where('is_admin', true)->where('village_slug', $admin->village_slug)
            ->orderBy('name')->get(['id', 'name', 'username', 'email', 'admin_role', 'is_active']);

        return response()->json($users->map(fn (User $user) => [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->admin_role,
            'active' => $user->is_active,
        ]));
    }

    public function createAdminUser(StoreVillageAdminUserRequest $request): JsonResponse
    {
        $admin = $request->user();
        $data = $request->validated();

        $user = User::query()->create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'is_admin' => true,
            'admin_role' => 'editor',
            'is_active' => true,
            'village_slug' => $admin->village_slug,
        ]);

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->admin_role,
            'active' => $user->is_active,
        ], 201);
    }

    public function updateAdminUser(UpdateVillageAdminUserRequest $request, int $id): Response
    {
        $admin = $request->user();
        $data = $request->validated();

        DB::transaction(function () use ($admin, $data, $id): void {
            DB::table('village_pages')->where('slug', $admin->village_slug)->lockForUpdate()->first();
            $target = User::query()->whereKey($id)->where('is_admin', true)
                ->where('village_slug', $admin->village_slug)->firstOrFail();
            abort_unless($target->id !== $admin->id, 400, 'Akun yang sedang digunakan tidak dapat diubah dari halaman ini.');

            if ($target->admin_role === 'owner' && ($data['role'] !== 'owner' || ! $data['active'])) {
                $otherOwners = User::query()->where('is_admin', true)->where('is_active', true)->where('admin_role', 'owner')
                    ->where('village_slug', $admin->village_slug)->whereKeyNot($target->id)->count();
                abort_if($otherOwners < 1, 409, 'Desa harus memiliki setidaknya satu admin pemilik yang aktif.');
            }

            $target->admin_role = $data['role'];
            $target->is_active = (bool) $data['active'];
            if (! empty($data['password'])) {
                $target->password = $data['password'];
            }
            $target->save();
        });

        return response()->noContent();
    }

    public function adminProjects(Request $request): JsonResponse
    {
        return response()->json($this->projects(false, $this->adminVillageSlug($request)));
    }

    public function createProject(SaveProjectRequest $request): JsonResponse
    {
        $input = $this->projectInput($request->validated(), $this->adminVillageSlug($request));
        $input['created_at'] = now()->utc()->toIso8601String();
        $id = DB::table('projects')->insertGetId($input);

        return response()->json($this->project($id, $input['village_slug']), 201);
    }

    public function updateProject(SaveProjectRequest $request, int $id): Response
    {
        $slug = $this->adminVillageSlug($request);
        $input = $this->projectInput($request->validated(), $slug);
        $updated = DB::table('projects')->where('id', $id)->where('village_slug', $slug)->update($input);
        abort_unless($updated || DB::table('projects')->where('id', $id)->where('village_slug', $slug)->exists(), 404);

        return response()->noContent();
    }

    public function deleteProject(Request $request, int $id): Response
    {
        abort_unless(DB::table('projects')->where('id', $id)->where('village_slug', $this->adminVillageSlug($request))->delete(), 404);

        return response()->noContent();
    }

    public function adminBudgets(Request $request): JsonResponse
    {
        return response()->json($this->budgets(false, $this->adminVillageSlug($request)));
    }

    public function createBudget(SaveBudgetRequest $request): JsonResponse
    {
        $slug = $this->adminVillageSlug($request);
        $input = $this->budgetInput($request->validated(), $slug);
        $id = DB::table('budgets')->insertGetId($input);

        return response()->json($this->budget($id, $slug), 201);
    }

    public function updateBudget(SaveBudgetRequest $request, int $id): Response
    {
        $slug = $this->adminVillageSlug($request);
        $input = $this->budgetInput($request->validated(), $slug);
        abort_unless(DB::table('budgets')->where('id', $id)->where('village_slug', $slug)->exists(), 404);
        DB::table('budgets')->where('id', $id)->where('village_slug', $slug)->update($input);

        return response()->noContent();
    }

    public function deleteBudget(Request $request, int $id): Response
    {
        abort_unless(DB::table('budgets')->where('id', $id)->where('village_slug', $this->adminVillageSlug($request))->delete(), 404);

        return response()->noContent();
    }

    private function projects(bool $publishedOnly, string $villageSlug = 'curahsawo'): array
    {
        $query = DB::table('projects')->where('village_slug', $villageSlug)->orderByDesc('year')->orderByDesc('id');
        if ($publishedOnly) {
            $query->where('published', true);
        }

        return $query->get()->map(fn ($row) => $this->formatProject($row))->all();
    }

    private function contentRecord(int $id, string $villageSlug, string $type): array
    {
        return $this->formatContent(DB::table('village_content')->where('id', $id)->where('village_slug', $villageSlug)
            ->where('type', $type)->first());
    }

    private function formatContent(object $row): array
    {
        return [
            'id' => (int) $row->id,
            'type' => $row->type,
            'title' => $row->title,
            'summary' => $row->summary,
            'body' => $row->body,
            'category' => $row->category,
            'link' => $row->link,
            'imageUrl' => $row->image_url,
            'published' => (bool) $row->published,
            'sortOrder' => (int) $row->sort_order,
            'publishedAt' => $row->published_at,
            'metadata' => json_decode((string) ($row->metadata ?? ''), true) ?: [],
        ];
    }

    private function contentInput(array $data, string $type, string $villageSlug): array
    {
        $profile = $type === 'profile' ? ($data['profile'] ?? []) : [];
        $profile = array_filter($profile, fn ($value) => $value !== null && $value !== '');

        return [
            'village_slug' => $villageSlug,
            'type' => $type,
            'title' => trim($data['title']),
            'summary' => trim((string) ($data['summary'] ?? '')),
            'body' => trim($data['body']),
            'category' => trim((string) ($data['category'] ?? '')),
            'link' => trim((string) ($data['link'] ?? '')),
            'image_url' => trim((string) ($data['imageUrl'] ?? '')),
            'published' => (bool) $data['published'],
            'sort_order' => (int) ($data['sortOrder'] ?? 0),
            'published_at' => $data['publishedAt'] ?? null,
            'metadata' => $type === 'profile'
                ? json_encode($profile, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR)
                : null,
        ];
    }

    private function validateContentType(string $type): void
    {
        abort_unless(in_array($type, ['news', 'activity', 'service', 'profile'], true), 404);
    }

    private function recordPageView(string $slug): void
    {
        $now = now()->utc()->toIso8601String();
        $viewDate = now()->toDateString();
        $path = '/desa/'.$slug;
        DB::table('village_page_views')->insertOrIgnore([
            'village_slug' => $slug,
            'path' => $path,
            'view_date' => $viewDate,
            'views' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('village_page_views')->where('village_slug', $slug)->where('path', $path)->where('view_date', $viewDate)
            ->increment('views', 1, ['updated_at' => $now]);
    }

    private function authorizeVillageOwner(Request $request): User
    {
        $owner = $request->user();
        abort_unless($owner instanceof User && $owner->admin_role === 'owner'
            && $owner->village_slug === $this->adminVillageSlug($request), 403,
            'Hanya admin pemilik desa yang dapat mengelola akun.');

        return $owner;
    }

    private function project(int $id, string $villageSlug): array
    {
        return $this->formatProject(DB::table('projects')->where('id', $id)->where('village_slug', $villageSlug)->first());
    }

    private function formatProject(object $row): array
    {
        return [
            'id' => (int) $row->id, 'title' => $row->title, 'location' => $row->location,
            'latitude' => $row->latitude !== null ? (float) $row->latitude : null,
            'longitude' => $row->longitude !== null ? (float) $row->longitude : null,
            'villageSlug' => $row->village_slug ?? 'curahsawo',
            'year' => (string) $row->year, 'status' => $row->status, 'summary' => $row->summary,
            'details' => $row->details, 'volume' => $row->volume, 'funding' => $row->funding,
            'executor' => $row->executor, 'schedule' => $row->schedule, 'progress' => (int) $row->progress,
            'spent' => (int) $row->spent, 'source' => $row->source, 'sourceUrl' => $row->source_url,
            'published' => (bool) $row->published,
        ];
    }

    private function projectInput(array $data, string $villageSlug): array
    {
        return [
            'village_slug' => $villageSlug, 'title' => trim($data['title']), 'location' => trim($data['location']), 'year' => (int) $data['year'],
            'latitude' => isset($data['latitude']) ? (float) $data['latitude'] : null,
            'longitude' => isset($data['longitude']) ? (float) $data['longitude'] : null,
            'status' => trim((string) ($data['status'] ?? '')), 'summary' => (string) ($data['summary'] ?? ''),
            'details' => (string) ($data['details'] ?? ''), 'volume' => (string) ($data['volume'] ?? ''),
            'funding' => (string) ($data['funding'] ?? ''), 'executor' => (string) ($data['executor'] ?? ''),
            'schedule' => (string) ($data['schedule'] ?? ''), 'progress' => (int) ($data['progress'] ?? 0), 'spent' => (int) ($data['spent'] ?? 0),
            'source' => (string) ($data['source'] ?? ''), 'source_url' => trim((string) ($data['sourceUrl'] ?? '')),
            'published' => filter_var($data['published'] ?? false, FILTER_VALIDATE_BOOLEAN),
        ];
    }

    private function budgets(bool $publishedOnly, string $villageSlug = 'curahsawo'): array
    {
        $query = DB::table('budgets')->where('village_slug', $villageSlug)->orderByDesc('year');
        if ($publishedOnly) {
            $query->where('published', true);
        }

        return $query->get()->map(fn ($row) => $this->formatBudget($row))->all();
    }

    private function budget(int $id, string $villageSlug): array
    {
        return $this->formatBudget(DB::table('budgets')->where('id', $id)->where('village_slug', $villageSlug)->first());
    }

    private function formatBudget(object $row): array
    {
        return [
            'id' => (int) $row->id, 'villageSlug' => $row->village_slug ?? 'curahsawo', 'year' => (int) $row->year, 'revenue' => (int) $row->revenue,
            'expenditure' => (int) $row->expenditure, 'financing' => (int) $row->financing,
            'villageFund' => (int) $row->village_fund, 'realized' => (int) $row->realized,
            'villageAllocation' => (int) $row->village_allocation,
            'taxRevenueShare' => (int) $row->tax_revenue_share,
            'retributionShare' => (int) $row->retribution_share,
            'notes' => $row->notes, 'sourceUrl' => $row->source_url, 'published' => (bool) $row->published,
        ];
    }

    private function budgetInput(array $data, string $villageSlug): array
    {
        $values = [];
        foreach (['revenue', 'expenditure', 'financing', 'villageFund', 'villageAllocation', 'taxRevenueShare', 'retributionShare', 'realized'] as $field) {
            $values[Str::snake($field)] = (int) ($data[$field] ?? 0);
        }

        return $values + [
            'village_slug' => $villageSlug,
            'year' => (int) $data['year'],
            'notes' => trim((string) ($data['notes'] ?? '')),
            'source_url' => trim((string) ($data['sourceUrl'] ?? '')),
            'published' => (bool) ($data['published'] ?? false),
        ];
    }

    private function adminVillageSlug(Request $request): string
    {
        $slug = (string) ($request->user()?->village_slug ?? '');
        abort_unless($slug !== '', 403);

        return $slug;
    }

    private function sameOrigin(Request $request): bool
    {
        $origin = $request->header('Origin') ?: $request->header('Referer');
        if (! $origin) {
            return false;
        }

        $scheme = strtolower((string) parse_url($origin, PHP_URL_SCHEME));
        $originPort = parse_url($origin, PHP_URL_PORT) ?? ($scheme === 'https' ? 443 : 80);

        return strtolower((string) parse_url($origin, PHP_URL_HOST)) === strtolower($request->getHost())
            && $originPort === $request->getPort()
            && $scheme === $request->getScheme();
    }
}
