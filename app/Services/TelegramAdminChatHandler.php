<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TelegramAdminChatHandler
{
    public function __construct(private AdminChatAssistant $assistant) {}

    /**
     * @param  array<string, mixed>  $message
     */
    public function handle(int $updateId, array $message): void
    {
        $botToken = (string) config('services.telegram.bot_token');
        abort_if($botToken === '', 503, 'Telegram bot belum dikonfigurasi.');

        $chatId = (string) $message['chat']['id'];
        $telegramUserId = (int) $message['from']['id'];
        $text = is_string($message['text'] ?? null) ? trim($message['text']) : '';
        $response = DB::transaction(function () use ($updateId, $chatId, $telegramUserId, $text): string {
            DB::table('telegram_admin_chat_updates')->where('created_at', '<', now()->subDays(7))->delete();
            DB::table('telegram_admin_chat_updates')->insertOrIgnore([
                'update_id' => $updateId,
                'response_text' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $processedUpdate = DB::table('telegram_admin_chat_updates')
                ->where('update_id', $updateId)
                ->lockForUpdate()
                ->first();

            if ($processedUpdate->response_text !== '') {
                return $processedUpdate->response_text;
            }

            $admin = User::query()
                ->where('telegram_user_id', $telegramUserId)
                ->where('is_admin', true)
                ->where('is_active', true)
                ->first();

            if (! $admin || ! DB::table('village_pages')->where('slug', $admin->village_slug)->exists()) {
                $responseText = 'Akun Telegram ini belum ditautkan ke admin desa yang aktif. ID Telegram Anda: '.$telegramUserId.'.';
            } elseif ($text === '') {
                $responseText = 'Kirim perintah dalam bentuk teks. Untuk gambar, gunakan menu Media desa di laman admin.';
            } elseif (mb_strlen($text) > 2000) {
                $responseText = 'Pesan terlalu panjang. Batas pesan adalah 2.000 karakter.';
            } else {
                $conversationId = $this->conversationId($admin, $chatId);
                $command = preg_match('/^\/(start|help)(?:@\w+)?$/i', $text) === 1
                    ? 'menu utama'
                    : (preg_match('/^\/(cancel|batal)(?:@\w+)?$/i', $text) === 1 ? 'batal' : $text);
                $reply = $this->assistant->reply($admin, $conversationId, $command);
                $responseText = $this->formatReply($reply['text'], $reply['options'] ?? []);
            }

            DB::table('telegram_admin_chat_updates')->where('update_id', $updateId)->update([
                'response_text' => $responseText,
                'updated_at' => now(),
            ]);

            return $responseText;
        });

        Http::connectTimeout(3)
            ->timeout(8)
            ->post('https://api.telegram.org/bot'.$botToken.'/sendMessage', [
                'chat_id' => $chatId,
                'text' => $response,
            ])
            ->throw();
    }

    private function conversationId(User $admin, string $chatId): string
    {
        $conversation = DB::table('admin_chat_conversations')
            ->where('user_id', $admin->id)
            ->where('channel', 'telegram')
            ->where('channel_key', $chatId)
            ->first();

        if ($conversation) {
            return $conversation->conversation_id;
        }

        $conversationId = (string) Str::uuid();
        DB::table('admin_chat_conversations')->insertOrIgnore([
            'user_id' => $admin->id,
            'conversation_id' => $conversationId,
            'state' => null,
            'channel' => 'telegram',
            'channel_key' => $chatId,
            'expires_at' => now()->addMinutes(30),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return DB::table('admin_chat_conversations')
            ->where('user_id', $admin->id)
            ->where('channel', 'telegram')
            ->where('channel_key', $chatId)
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
