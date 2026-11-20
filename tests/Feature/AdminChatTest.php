<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class AdminChatTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_add_an_official_through_numbered_chat_until_data_is_saved(): void
    {
        config(['services.tokenharbor.api_key' => 'test-token']);
        config(['services.tokenharbor.base_url' => 'https://tokenharbor.test/v1']);
        Http::fake(['tokenharbor.test/*' => Http::response([
            'choices' => [['message' => ['content' => '{"resource":"officials","action":"create","confidence":0.99}']]],
        ])]);

        $admin = $this->createVillageAdmin('curahsawo');
        $conversationId = 'f95d9c4c-3b1b-47df-9020-1928f8a89b54';
        $this->actingAs($admin)->withSameOriginHeaders();

        $first = $this->postChat($conversationId, 'Tambah perangkat desa')->assertOk();
        $this->assertStringContainsString('Nama', $first->json('text'));
        Http::assertSent(fn ($request): bool => str_contains($request->url(), '/chat/completions'));

        $this->postChat($conversationId, 'Budi Santoso')->assertOk()->assertJsonPath('text', 'Isi Jabatan:');
        $this->postChat($conversationId, 'Kaur Umum')->assertOk();
        $this->postChat($conversationId, 'lewati')->assertOk()->assertJsonPath('options.0.label', 'Ya');
        $this->postChat($conversationId, '1')->assertOk();
        $summary = $this->postChat($conversationId, '1')->assertOk();
        $this->assertStringContainsString('Budi Santoso', $summary->json('text'));
        $saved = $this->postChat($conversationId, '1')->assertOk();
        $this->assertStringContainsString('Data berhasil ditambahkan', $saved->json('text'));

        $this->assertDatabaseHas('village_officials', [
            'village_slug' => 'curahsawo',
            'name' => 'Budi Santoso',
            'position' => 'Kaur Umum',
            'published' => true,
            'sort_order' => 1,
        ]);
        $this->assertDatabaseHas('admin_chat_conversations', [
            'user_id' => $admin->id,
            'conversation_id' => $conversationId,
        ]);
        $this->assertDatabaseCount('village_officials', 1);
    }

    public function test_numbered_choices_list_only_data_from_the_admins_village_without_calling_ai(): void
    {
        $admin = $this->createVillageAdmin('curahsawo', 'editor');
        DB::table('village_officials')->insert([
            ['village_slug' => 'curahsawo', 'name' => 'Budi', 'position' => 'Sekretaris', 'published' => true, 'sort_order' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['village_slug' => 'pajurangan', 'name' => 'Siti', 'position' => 'Bendahara', 'published' => true, 'sort_order' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
        Http::preventStrayRequests();
        $this->actingAs($admin)->withSameOriginHeaders();

        $conversationId = '3daf6b63-3b48-48ba-92bf-51599933bed5';
        $this->postChat($conversationId, '1')->assertOk();
        $this->postChat($conversationId, '1')->assertOk();
        $list = $this->postChat($conversationId, '1')->assertOk();

        $this->assertStringContainsString('Budi · Sekretaris', $list->json('text'));
        $this->assertStringNotContainsString('Siti · Bendahara', $list->json('text'));
        Http::assertNothingSent();
    }

    public function test_admin_can_change_an_official_and_the_change_is_saved_after_confirmation(): void
    {
        config(['services.tokenharbor.api_key' => 'test-token']);
        config(['services.tokenharbor.base_url' => 'https://tokenharbor.test/v1']);
        Http::fake(['tokenharbor.test/*' => Http::response([
            'choices' => [['message' => ['content' => '{"resource":"officials","action":"update","confidence":0.98}']]],
        ])]);

        $admin = $this->createVillageAdmin('curahsawo');
        $officialId = DB::table('village_officials')->insertGetId([
            'village_slug' => 'curahsawo', 'name' => 'Budi', 'position' => 'Sekretaris',
            'published' => true, 'sort_order' => 0, 'created_at' => now(), 'updated_at' => now(),
        ]);
        $this->actingAs($admin)->withSameOriginHeaders();
        $conversationId = 'fb19fba0-809d-48d6-9a20-8c882d113280';

        $this->postChat($conversationId, 'Ubah perangkat desa')->assertOk();
        $this->postChat($conversationId, '1')->assertOk();
        $this->postChat($conversationId, '2')->assertOk();
        $this->postChat($conversationId, 'Sekretaris Desa')->assertOk();
        $this->postChat($conversationId, '1')->assertOk();

        $this->assertDatabaseHas('village_officials', [
            'id' => $officialId,
            'village_slug' => 'curahsawo',
            'position' => 'Sekretaris Desa',
        ]);
        $this->assertDatabaseCount('village_officials', 1);
    }

    public function test_delete_requires_confirmation_and_can_be_cancelled(): void
    {
        $this->fakeIntent('officials', 'delete');
        $admin = $this->createVillageAdmin('curahsawo');
        $officialId = DB::table('village_officials')->insertGetId([
            'village_slug' => 'curahsawo', 'name' => 'Budi', 'position' => 'Sekretaris',
            'published' => true, 'sort_order' => 0, 'created_at' => now(), 'updated_at' => now(),
        ]);
        $this->actingAs($admin)->withSameOriginHeaders();

        $cancelConversation = '4f315004-1f23-484a-a168-5718c6e1bca4';
        $this->postChat($cancelConversation, 'Hapus perangkat')->assertOk();
        $this->postChat($cancelConversation, '1')->assertOk()->assertJsonPath('options.0.label', 'Ya');
        $this->postChat($cancelConversation, 'Batal')->assertOk();
        $this->assertDatabaseHas('village_officials', ['id' => $officialId]);

        $confirmConversation = '04ef4667-eb5f-4b4f-8a4f-a01853b7e95a';
        $this->postChat($confirmConversation, 'Hapus perangkat')->assertOk();
        $this->postChat($confirmConversation, '1')->assertOk();
        $this->postChat($confirmConversation, '1')->assertOk();
        $this->assertDatabaseMissing('village_officials', ['id' => $officialId]);
    }

    public function test_created_news_is_visible_from_the_village_website_endpoint(): void
    {
        config(['services.tokenharbor.api_key' => 'test-token']);
        config(['services.tokenharbor.base_url' => 'https://tokenharbor.test/v1']);
        Http::fake(['tokenharbor.test/*' => Http::response([
            'choices' => [['message' => ['content' => '{"resource":"news","action":"create","confidence":0.99}']]],
        ])]);

        $admin = $this->createVillageAdmin('curahsawo');
        $this->actingAs($admin)->withSameOriginHeaders();
        $conversationId = '22ce6236-ae34-4c29-9f39-cd626996b099';
        $messages = ['Kabar kerja bakti', 'lewati', 'Warga membersihkan lingkungan bersama.', 'lewati', 'lewati', 'lewati', '1', '0', 'lewati'];

        $this->postChat($conversationId, 'Tambah berita')->assertOk();
        foreach ($messages as $message) {
            $this->postChat($conversationId, $message)->assertOk();
        }
        $this->postChat($conversationId, '1')->assertOk()->assertJsonPath('text', fn (string $text): bool => str_contains($text, 'berhasil ditambahkan'));

        $this->assertDatabaseHas('village_content', [
            'village_slug' => 'curahsawo',
            'type' => 'news',
            'title' => 'Kabar kerja bakti',
            'body' => 'Warga membersihkan lingkungan bersama.',
            'published' => true,
        ]);
        $this->getJson('/api/desa/curahsawo/managed-content')
            ->assertOk()
            ->assertJsonPath('news.0.title', 'Kabar kerja bakti');
    }

    public function test_project_created_through_chat_is_saved_and_visible_to_the_village_site(): void
    {
        $this->fakeIntent('projects', 'create');
        $admin = $this->createVillageAdmin('curahsawo');
        $this->actingAs($admin)->withSameOriginHeaders();
        $conversationId = 'b1b5c211-5b9a-47ec-8596-8c184fe8ce7a';
        $messages = [
            'Jalan Dusun Krajan', 'Dusun Krajan', '2026', 'lewati', 'lewati', 'lewati', 'lewati', 'lewati',
            'lewati', 'lewati', 'lewati', 'lewati', 'lewati', 'lewati', 'lewati', 'lewati', '1',
        ];

        $this->postChat($conversationId, 'Tambah proyek')->assertOk();
        foreach ($messages as $message) {
            $this->postChat($conversationId, $message)->assertOk();
        }
        $this->postChat($conversationId, '1')->assertOk();

        $this->assertDatabaseHas('projects', [
            'village_slug' => 'curahsawo',
            'title' => 'Jalan Dusun Krajan',
            'location' => 'Dusun Krajan',
            'year' => 2026,
            'published' => true,
        ]);
        $this->getJson('/api/desa/curahsawo/content')->assertOk()->assertJsonPath('projects.0.title', 'Jalan Dusun Krajan');
    }

    public function test_budget_created_through_chat_is_saved_and_visible_to_the_village_site(): void
    {
        $this->fakeIntent('budgets', 'create');
        $admin = $this->createVillageAdmin('curahsawo');
        $this->actingAs($admin)->withSameOriginHeaders();
        $conversationId = 'e583cdbe-513b-4d7e-95c2-1fd9a800b70f';
        $messages = ['2026', '500000000', '400000000', 'lewati', 'lewati', 'lewati', 'lewati', 'lewati', 'lewati', 'lewati', 'lewati', '1'];

        $this->postChat($conversationId, 'Tambah APBDes')->assertOk();
        foreach ($messages as $message) {
            $this->postChat($conversationId, $message)->assertOk();
        }
        $this->postChat($conversationId, '1')->assertOk();

        $this->assertDatabaseHas('budgets', [
            'village_slug' => 'curahsawo',
            'year' => 2026,
            'revenue' => 500000000,
            'expenditure' => 400000000,
            'published' => true,
        ]);
        $this->getJson('/api/desa/curahsawo/budgets')->assertOk()->assertJsonPath('0.year', 2026);
    }

    public function test_request_status_change_through_chat_records_status_history(): void
    {
        $this->fakeIntent('requests', 'update');
        $admin = $this->createVillageAdmin('curahsawo');
        $requestId = DB::table('village_requests')->insertGetId([
            'village_slug' => 'curahsawo', 'kind' => 'service', 'tracking_code' => 'REQ-CHAT-123456',
            'title' => 'Surat keterangan domisili', 'category' => 'Administrasi', 'name' => 'Warga',
            'contact' => '081234567890', 'email' => '', 'notify_by_email' => false,
            'description' => 'Permohonan surat domisili.', 'status' => 'Masuk', 'admin_note' => '',
            'target_at' => null, 'assigned_to_user_id' => null, 'created_at' => now(), 'updated_at' => now(),
        ]);
        $this->actingAs($admin)->withSameOriginHeaders();
        $conversationId = '92b8eed0-6869-445a-ae73-6404502c1653';

        $this->postChat($conversationId, 'Ubah permohonan layanan')->assertOk();
        $this->postChat($conversationId, '1')->assertOk();
        $this->postChat($conversationId, '1')->assertOk();
        $this->postChat($conversationId, '4')->assertOk();
        $this->postChat($conversationId, '1')->assertOk();

        $this->assertDatabaseHas('village_requests', ['id' => $requestId, 'status' => 'Selesai']);
        $this->assertDatabaseHas('village_request_status_history', [
            'request_id' => $requestId,
            'status' => 'Selesai',
            'changed_by_user_id' => $admin->id,
        ]);
    }

    public function test_owner_can_create_an_admin_account_through_chat_with_a_generated_password(): void
    {
        $this->fakeIntent('users', 'create');
        $admin = $this->createVillageAdmin('curahsawo');
        $this->actingAs($admin)->withSameOriginHeaders();
        $conversationId = 'b47a65e7-12df-4ba4-9626-6696e85d45e9';

        $this->postChat($conversationId, 'Tambah akun admin')->assertOk();
        $this->postChat($conversationId, 'Admin Baru')->assertOk();
        $this->postChat($conversationId, 'admin.baru')->assertOk();
        $summary = $this->postChat($conversationId, 'admin.baru@curahsawo.test')->assertOk();
        $this->assertStringContainsString('Admin Baru', $summary->json('text'));
        $created = $this->postChat($conversationId, '1')->assertOk();
        $this->assertStringContainsString('Kata sandi sementara', $created->json('text'));

        $this->assertDatabaseHas('users', [
            'name' => 'Admin Baru',
            'username' => 'admin.baru',
            'email' => 'admin.baru@curahsawo.test',
            'village_slug' => 'curahsawo',
            'is_admin' => true,
            'admin_role' => 'editor',
            'is_active' => true,
        ]);
    }

    public function test_owner_can_reset_an_admin_password_without_storing_or_echoing_plaintext_in_chat_state(): void
    {
        $this->fakeIntent('users', 'update');
        $admin = $this->createVillageAdmin('curahsawo');
        $target = $this->createVillageAdminUser('editor');
        $this->actingAs($admin)->withSameOriginHeaders();
        $conversationId = 'a9eb21f0-1a16-43de-af37-17323e3e31d2';
        $password = 'NewSecurePassphrase2026!';

        $this->postChat($conversationId, 'Ubah akun admin')->assertOk();
        $this->postChat($conversationId, '1')->assertOk();
        $this->postChat($conversationId, '3')->assertOk();
        $this->postChat($conversationId, $password)->assertOk();
        $confirmation = $this->postChat($conversationId, $password)->assertOk();
        $this->assertStringNotContainsString($password, $confirmation->json('text'));
        $storedState = (string) DB::table('admin_chat_conversations')->where('conversation_id', $conversationId)->value('state');
        $this->assertStringNotContainsString($password, $storedState);

        $this->postChat($conversationId, '1')->assertOk();

        $this->assertTrue(Hash::check($password, $target->fresh()->password));
    }

    public function test_admin_can_upload_a_photo_to_village_media_through_the_channel_neutral_chat_endpoint(): void
    {
        Storage::fake('public');
        Http::preventStrayRequests();
        $admin = $this->createVillageAdmin('curahsawo', 'editor');

        $response = $this->actingAs($admin)->withSameOriginHeaders()->post('/api/admin/chat', [
            'message' => 'Unggah foto ke media desa',
            'altText' => 'Warga kerja bakti',
            'file' => UploadedFile::fake()->image('kerja-bakti.jpg'),
        ], ['Accept' => 'application/json']);

        $response->assertCreated()->assertJsonPath('text', 'Foto berhasil diunggah ke Media desa.');
        $media = DB::table('village_media')->where('village_slug', 'curahsawo')->first();
        $this->assertNotNull($media);
        $this->assertSame('Warga kerja bakti', $media->alt_text);
        Storage::disk('public')->assertExists($media->path);
        Http::assertNothingSent();
    }

    public function test_owner_only_account_menu_is_not_offered_to_editor(): void
    {
        $admin = $this->createVillageAdmin('curahsawo', 'editor');
        Http::preventStrayRequests();

        $response = $this->actingAs($admin)->withSameOriginHeaders()->postJson('/api/admin/chat', ['message' => '1']);

        $response->assertOk();
        $this->assertStringNotContainsString('Akun admin', $response->json('text'));
    }

    public function test_unrecognized_ai_intent_falls_back_to_numbered_menu_without_mutating_data(): void
    {
        config(['services.tokenharbor.api_key' => 'test-token']);
        config(['services.tokenharbor.base_url' => 'https://tokenharbor.test/v1']);
        Http::fake(['tokenharbor.test/*' => Http::response([
            'choices' => [['message' => ['content' => '{"resource":"","action":"","confidence":0.1}']]],
        ])]);

        $admin = $this->createVillageAdmin('curahsawo', 'editor');
        $response = $this->actingAs($admin)->withSameOriginHeaders()->postJson('/api/admin/chat', [
            'message' => 'Halo, saya ingin mengelola data desa',
        ])->assertOk();

        $this->assertStringContainsString('belum mengenali', $response->json('text'));
        $this->assertSame('Perangkat desa', $response->json('options.0.label'));
        $this->assertSame('Berita', $response->json('options.2.label'));
        $this->assertDatabaseCount('village_officials', 0);
        $this->assertDatabaseCount('village_content', 0);
    }

    public function test_admin_can_switch_to_a_new_menu_mid_flow_after_confirmation(): void
    {
        $this->fakeIntentByMessage();
        $admin = $this->createVillageAdmin('curahsawo');
        $this->actingAs($admin)->withSameOriginHeaders();
        $conversationId = 'ce941480-9d8b-497c-98a1-a3975cd94aac';

        $this->postChat($conversationId, 'Tambah perangkat desa')->assertOk()->assertJsonPath('text', 'Isi Nama:');
        $switch = $this->postChat($conversationId, 'Tambah berita')->assertOk();
        $this->assertStringContainsString('belum selesai', $switch->json('text'));
        $this->assertSame('Pindah menu', $switch->json('options.0.label'));
        $this->assertSame('Lanjutkan proses sekarang', $switch->json('options.1.label'));

        $this->postChat($conversationId, '1')->assertOk()->assertJsonPath('text', 'Isi Judul:');
        $this->postChat($conversationId, 'batal')->assertOk();

        $this->assertDatabaseCount('village_officials', 0);
        $this->assertDatabaseCount('village_content', 0);
    }

    public function test_admin_can_resume_the_previous_flow_after_declining_a_menu_switch(): void
    {
        $this->fakeIntentByMessage();
        $admin = $this->createVillageAdmin('curahsawo');
        $this->actingAs($admin)->withSameOriginHeaders();
        $conversationId = 'ae8a6b1b-282c-4b72-88e3-857ef3105092';

        $this->postChat($conversationId, 'Tambah perangkat desa')->assertOk();
        $this->postChat($conversationId, 'Tambah berita')->assertOk();
        $this->postChat($conversationId, '2')->assertOk()->assertJsonPath('text', 'Baik, kita lanjutkan proses sebelumnya. Isi Nama:');
        $this->postChat($conversationId, 'Siti Aminah')->assertOk()->assertJsonPath('text', 'Isi Jabatan:');
        $this->postChat($conversationId, 'menu utama')->assertOk();

        $this->assertDatabaseCount('village_officials', 0);
        $this->assertDatabaseCount('village_content', 0);
    }

    public function test_guest_cannot_use_admin_chat(): void
    {
        $this->withSameOriginHeaders()->postJson('/api/admin/chat', ['message' => 'lihat perangkat'])->assertUnauthorized();
    }

    private function postChat(string $conversationId, string $message): TestResponse
    {
        return $this->withSameOriginHeaders()->postJson('/api/admin/chat', [
            'conversationId' => $conversationId,
            'message' => $message,
        ]);
    }

    private function createVillageAdmin(string $villageSlug, string $role = 'owner'): User
    {
        DB::table('village_pages')->insertOrIgnore([
            'slug' => $villageSlug,
            'name' => ucfirst($villageSlug),
            'body' => '{}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return User::factory()->create([
            'name' => 'Admin '.ucfirst($villageSlug),
            'email' => 'admin@'.$villageSlug.'.test',
            'username' => 'admin.'.$villageSlug,
            'village_slug' => $villageSlug,
            'is_admin' => true,
            'is_active' => true,
            'admin_role' => $role,
        ]);
    }

    private function createVillageAdminUser(string $role): User
    {
        return User::factory()->create([
            'name' => 'Petugas Desa',
            'email' => 'petugas@curahsawo.test',
            'username' => 'admin.petugas',
            'village_slug' => 'curahsawo',
            'is_admin' => true,
            'is_active' => true,
            'admin_role' => $role,
        ]);
    }

    private function fakeIntent(string $resource, string $action): void
    {
        config(['services.tokenharbor.api_key' => 'test-token']);
        config(['services.tokenharbor.base_url' => 'https://tokenharbor.test/v1']);
        Http::fake(['tokenharbor.test/*' => Http::response([
            'choices' => [['message' => ['content' => json_encode(['resource' => $resource, 'action' => $action, 'confidence' => 0.99])]]],
        ])]);
    }

    private function fakeIntentByMessage(): void
    {
        config(['services.tokenharbor.api_key' => 'test-token']);
        config(['services.tokenharbor.base_url' => 'https://tokenharbor.test/v1']);
        Http::fake(function (ClientRequest $request) {
            $message = mb_strtolower($request['messages'][1]['content']);
            $resource = str_contains($message, 'berita') ? 'news' : 'officials';

            return Http::response([
                'choices' => [['message' => ['content' => json_encode([
                    'resource' => $resource,
                    'action' => 'create',
                    'confidence' => 0.99,
                ])]]],
            ]);
        });
    }

    private function withSameOriginHeaders(): static
    {
        $applicationUrl = parse_url((string) config('app.url'));
        $scheme = $applicationUrl['scheme'] ?? 'http';
        $host = $applicationUrl['host'] ?? 'localhost';
        $port = $applicationUrl['port'] ?? null;
        $origin = $scheme.'://'.$host.($port ? ':'.$port : '');

        return $this->withServerVariables([
            'HTTP_HOST' => $host.($port ? ':'.$port : ''),
            'SERVER_PORT' => $port ?? ($scheme === 'https' ? 443 : 80),
            'HTTPS' => $scheme === 'https' ? 'on' : 'off',
        ])->withHeader('Origin', $origin);
    }
}
