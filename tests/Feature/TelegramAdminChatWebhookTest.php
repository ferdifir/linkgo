<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class TelegramAdminChatWebhookTest extends TestCase
{
    use RefreshDatabase;

    private const WEBHOOK_SECRET = 'test-telegram-secret';

    public function test_webhook_rejects_requests_without_the_configured_telegram_secret(): void
    {
        config(['services.telegram.webhook_secret' => self::WEBHOOK_SECRET]);
        Http::preventStrayRequests();

        $this->postJson('/api/telegram/webhook', ['update_id' => 1, 'message' => []])
            ->assertForbidden();

        $this->assertDatabaseCount('telegram_admin_chat_updates', 0);
        Http::assertNothingSent();
    }

    public function test_unlinked_telegram_sender_cannot_use_admin_chat(): void
    {
        $this->configureTelegram();
        Http::fake(['https://api.telegram.org/*' => Http::response(['ok' => true])]);

        $this->sendMessage(1, 9001, 'Tambah perangkat desa')->assertOk();

        Http::assertSent(fn ($request): bool => str_contains($request->url(), '/sendMessage')
            && str_contains($request['text'], 'belum ditautkan'));
        Http::assertNotSent(fn ($request): bool => str_contains($request->url(), 'tokenharbor.test'));
        $this->assertDatabaseCount('admin_chat_conversations', 0);
        $this->assertDatabaseCount('village_officials', 0);
    }

    public function test_linked_admin_can_complete_and_repeat_a_telegram_chat_update_without_duplicate_data(): void
    {
        $this->configureTelegram();
        DB::table('village_pages')->insert([
            'slug' => 'curahsawo',
            'name' => 'Curahsawo',
            'body' => '{}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $admin = User::factory()->create([
            'name' => 'Admin Curahsawo',
            'email' => 'admin.telegram@curahsawo.test',
            'username' => 'admin.telegram.curahsawo',
            'village_slug' => 'curahsawo',
            'is_admin' => true,
            'is_active' => true,
            'admin_role' => 'owner',
            'telegram_user_id' => 9001,
        ]);
        Http::fake([
            'https://api.telegram.org/*' => Http::response(['ok' => true]),
            'tokenharbor.test/*' => Http::response([
                'choices' => [['message' => ['content' => '{"resource":"officials","action":"create","confidence":0.99}']]],
            ]),
        ]);

        $messages = [
            'Tambah perangkat desa',
            'Budi Santoso',
            'Kaur Umum',
            'lewati',
            '1',
            '1',
            '1',
        ];
        foreach ($messages as $index => $message) {
            $response = $this->sendMessage($index + 1, 9001, $message)->assertOk();
            $this->assertTrue($response->json('ok'));
        }

        $this->sendMessage(7, 9001, '1')->assertOk();

        $this->assertDatabaseHas('village_officials', [
            'village_slug' => 'curahsawo',
            'name' => 'Budi Santoso',
            'position' => 'Kaur Umum',
            'published' => true,
            'sort_order' => 1,
        ]);
        $this->assertDatabaseCount('village_officials', 1);
        $this->assertDatabaseHas('admin_chat_conversations', [
            'user_id' => $admin->id,
            'channel' => 'telegram',
            'channel_key' => '9001',
        ]);
        $this->assertDatabaseHas('telegram_admin_chat_updates', ['update_id' => 7]);
        Http::assertSent(fn ($request): bool => str_contains($request->url(), '/sendMessage')
            && str_contains($request['text'], 'Data berhasil ditambahkan'));
    }

    public function test_group_chat_messages_are_ignored(): void
    {
        $this->configureTelegram();
        Http::preventStrayRequests();

        $this->postJson('/api/telegram/webhook', [
            'update_id' => 1,
            'message' => [
                'chat' => ['id' => -10012, 'type' => 'group'],
                'from' => ['id' => 9001],
                'text' => 'lihat daftar perangkat desa',
            ],
        ], ['X-Telegram-Bot-Api-Secret-Token' => self::WEBHOOK_SECRET])->assertOk();

        $this->assertDatabaseCount('telegram_admin_chat_updates', 0);
        $this->assertDatabaseCount('admin_chat_conversations', 0);
        Http::assertNothingSent();
    }

    public function test_admin_can_be_linked_to_a_telegram_user_id_from_artisan(): void
    {
        DB::table('village_pages')->insert([
            'slug' => 'curahsawo',
            'name' => 'Curahsawo',
            'body' => '{}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $admin = User::factory()->create([
            'username' => 'admin.telegram.curahsawo',
            'village_slug' => 'curahsawo',
            'is_admin' => true,
            'is_active' => true,
        ]);

        $exitCode = Artisan::call('admin:link-telegram', [
            'username' => $admin->username,
            'telegram_user_id' => '9001',
        ]);

        $this->assertSame(0, $exitCode);
        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'telegram_user_id' => 9001,
        ]);
    }

    private function configureTelegram(): void
    {
        config([
            'services.telegram.bot_token' => 'test-bot-token',
            'services.telegram.webhook_secret' => self::WEBHOOK_SECRET,
            'services.tokenharbor.api_key' => 'test-token',
            'services.tokenharbor.base_url' => 'https://tokenharbor.test/v1',
        ]);
    }

    private function sendMessage(int $updateId, int $telegramUserId, string $text): TestResponse
    {
        return $this->postJson('/api/telegram/webhook', [
            'update_id' => $updateId,
            'message' => [
                'chat' => ['id' => $telegramUserId, 'type' => 'private'],
                'from' => ['id' => $telegramUserId],
                'text' => $text,
            ],
        ], ['X-Telegram-Bot-Api-Secret-Token' => self::WEBHOOK_SECRET]);
    }
}
