<?php

namespace App\Http\Controllers;

use App\Services\WhatsAppAdminChatHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JsonException;

class WhatsAppAdminChatWebhookController extends Controller
{
    public function verify(Request $request): Response
    {
        $verifyToken = (string) config('services.whatsapp.verify_token');
        abort_if($verifyToken === '', 503, 'WhatsApp webhook belum dikonfigurasi.');

        $mode = (string) $request->query('hub_mode', $request->query('hub.mode'));
        $token = (string) $request->query('hub_verify_token', $request->query('hub.verify_token'));
        $challenge = (string) $request->query('hub_challenge', $request->query('hub.challenge'));

        abort_unless($mode === 'subscribe' && $challenge !== '' && hash_equals($verifyToken, $token), 403);

        return response($challenge, 200)->header('Content-Type', 'text/plain');
    }

    public function receive(Request $request, WhatsAppAdminChatHandler $handler): JsonResponse
    {
        $appSecret = (string) config('services.whatsapp.app_secret');
        abort_if($appSecret === '', 503, 'WhatsApp webhook belum dikonfigurasi.');

        $signature = (string) $request->header('X-Hub-Signature-256');
        $expectedSignature = 'sha256='.hash_hmac('sha256', $request->getContent(), $appSecret);
        abort_unless(hash_equals($expectedSignature, $signature), 403);

        try {
            $payload = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            return response()->json(['message' => 'Payload JSON tidak valid.'], 400);
        }

        abort_unless(is_array($payload), 400, 'Payload webhook tidak valid.');

        if (($payload['object'] ?? null) !== 'whatsapp_business_account') {
            return response()->json(['ok' => true]);
        }

        $entries = $payload['entry'] ?? [];
        abort_unless(is_array($entries), 400, 'Daftar entry webhook tidak valid.');

        foreach ($entries as $entry) {
            $changes = is_array($entry) ? ($entry['changes'] ?? []) : [];
            foreach (is_array($changes) ? $changes : [] as $change) {
                $value = is_array($change) ? ($change['value'] ?? []) : [];
                $messages = is_array($value) ? ($value['messages'] ?? []) : [];
                foreach (is_array($messages) ? $messages : [] as $message) {
                    if (is_array($message) && is_string($message['id'] ?? null) && is_string($message['from'] ?? null)) {
                        $handler->handle($message);
                    }
                }
            }
        }

        return response()->json(['ok' => true]);
    }
}
