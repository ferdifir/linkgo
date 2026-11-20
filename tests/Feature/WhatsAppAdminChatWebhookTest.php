<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class WhatsAppAdminChatWebhookTest extends TestCase
{
    use RefreshDatabase;

    private const APP_SECRET = 'test-whatsapp-app-secret';

    private const VERIFY_TOKEN = 'test-whatsapp-verify-token';

    private const ADMIN_PHONE = '6281234567890';

    public function test_meta_can_verify_the_webhook_with_the_configured_challenge(): void
    {
        config(['services.whatsapp.verify_token' => self::VERIFY_TOKEN]);

        $this->get('/api/whatsapp/webhook?hub.mode=subscribe&hub.verify_token='.self::VERIFY_TOKEN.'&hub.challenge=challenge-123')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertContent('challenge-123');
    }

    public function test_verification_and_post_requests_reject_invalid_authentication(): void
    {
        config([
            'services.whatsapp.verify_token' => self::VERIFY_TOKEN,
            'services.whatsapp.app_secret' => self::APP_SECRET,
        ]);
        Http::preventStrayRequests();

        $this->get('/api/whatsapp/webhook?hub.mode=subscribe&hub.verify_token=wrong&hub.challenge=challenge-123')
            ->assertForbidden();
        $this->postPayload(['object' => 'whatsapp_business_account'], 'sha256=invalid')->assertForbidden();

        $this->assertDatabaseCount('whatsapp_admin_chat_updates', 0);
        Http::assertNothingSent();
    }

    public function test_unlinked_sender_is_not_authorized_and_gets_a_linking_hint(): void
    {
        $this->configureWhatsApp();
        Http::fake(['https://graph.facebook.com/*' => Http::response(['messages' => [['id' => 'wamid.reply']]])]);

        $this->sendMessage('wamid.unknown', self::ADMIN_PHONE, 'Tambah perangkat desa')->assertOk();

        Http::assertSent(fn ($request): bool => $request->url() === 'https://graph.facebook.com/v23.0/test-phone-number-id/messages'
            && $request['to'] === self::ADMIN_PHONE
            && str_contains($request['text']['body'], 'belum ditautkan'));
        Http::assertNotSent(fn ($request): bool => str_contains($request->url(), 'tokenharbor.test'));
        $this->assertDatabaseCount('admin_chat_conversations', 0);
        $this->assertDatabaseCount('village_officials', 0);
    }

    public function test_linked_admin_can_finish_a_chat_flow_and_duplicate_messages_do_not_duplicate_data(): void
    {
        $this->configureWhatsApp();
        DB::table('village_pages')->insert([
            'slug' => 'curahsawo',
            'name' => 'Curahsawo',
            'body' => '{}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $admin = User::factory()->create([
            'name' => 'Admin WhatsApp',
            'email' => 'admin.whatsapp@curahsawo.test',
            'username' => 'admin.whatsapp.curahsawo',
            'village_slug' => 'curahsawo',
            'is_admin' => true,
            'is_active' => true,
            'admin_role' => 'owner',
            'whatsapp_user_id' => self::ADMIN_PHONE,
        ]);
        Http::fake([
            'https://graph.facebook.com/*' => Http::response(['messages' => [['id' => 'wamid.reply']]]),
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
            $this->sendMessage('wamid.'.($index + 1), self::ADMIN_PHONE, $message)->assertOk();
        }

        $this->sendMessage('wamid.7', self::ADMIN_PHONE, '1')->assertOk();

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
            'channel' => 'whatsapp',
            'channel_key' => self::ADMIN_PHONE,
        ]);
        $this->assertDatabaseHas('whatsapp_admin_chat_updates', ['message_id' => 'wamid.7']);
        Http::assertSent(fn ($request): bool => str_contains($request->url(), '/messages')
            && str_contains($request['text']['body'], 'Data berhasil ditambahkan'));
    }

    public function test_status_only_webhook_events_are_acknowledged_without_sending_messages(): void
    {
        $this->configureWhatsApp();
        Http::preventStrayRequests();

        $this->postPayload([
            'object' => 'whatsapp_business_account',
            'entry' => [['changes' => [['value' => ['statuses' => [['id' => 'wamid.sent']]]]]]],
        ])->assertOk()->assertJsonPath('ok', true);

        $this->assertDatabaseCount('whatsapp_admin_chat_updates', 0);
        Http::assertNothingSent();
    }

    public function test_admin_can_be_linked_to_a_whatsapp_number_from_artisan(): void
    {
        DB::table('village_pages')->insert([
            'slug' => 'curahsawo',
            'name' => 'Curahsawo',
            'body' => '{}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $admin = User::factory()->create([
            'username' => 'admin.whatsapp.curahsawo',
            'village_slug' => 'curahsawo',
            'is_admin' => true,
            'is_active' => true,
        ]);

        $exitCode = Artisan::call('admin:link-whatsapp', [
            'username' => $admin->username,
            'phone_number' => '+62 812-3456-7890',
        ]);

        $this->assertSame(0, $exitCode);
        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'whatsapp_user_id' => self::ADMIN_PHONE,
        ]);
    }

    private function configureWhatsApp(): void
    {
        config([
            'services.whatsapp.access_token' => 'test-access-token',
            'services.whatsapp.phone_number_id' => 'test-phone-number-id',
            'services.whatsapp.app_secret' => self::APP_SECRET,
            'services.whatsapp.verify_token' => self::VERIFY_TOKEN,
            'services.whatsapp.api_version' => 'v23.0',
            'services.tokenharbor.api_key' => 'test-token',
            'services.tokenharbor.base_url' => 'https://tokenharbor.test/v1',
        ]);
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function sendMessage(string $messageId, string $sender, string $text): TestResponse
    {
        return $this->postPayload([
            'object' => 'whatsapp_business_account',
            'entry' => [[
                'changes' => [[
                    'field' => 'messages',
                    'value' => [
                        'messaging_product' => 'whatsapp',
                        'metadata' => ['phone_number_id' => 'test-phone-number-id'],
                        'contacts' => [['wa_id' => $sender]],
                        'messages' => [[
                            'from' => $sender,
                            'id' => $messageId,
                            'timestamp' => '1732118400',
                            'type' => 'text',
                            'text' => ['body' => $text],
                        ]],
                    ],
                ]],
            ]],
        ]);
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function postPayload(array $payload, ?string $signature = null): TestResponse
    {
        $body = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        $signature ??= 'sha256='.hash_hmac('sha256', $body, self::APP_SECRET);

        return $this->call('POST', '/api/whatsapp/webhook', [], [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT' => 'application/json',
            'HTTP_X_HUB_SIGNATURE_256' => $signature,
        ], $body);
    }
}
