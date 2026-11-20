<?php

namespace App\Http\Controllers;

use App\Services\TelegramAdminChatHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TelegramAdminChatWebhookController extends Controller
{
    public function __invoke(Request $request, TelegramAdminChatHandler $handler): JsonResponse
    {
        $secret = (string) config('services.telegram.webhook_secret');
        abort_if($secret === '', 503, 'Telegram webhook belum dikonfigurasi.');
        abort_unless(hash_equals($secret, (string) $request->header('X-Telegram-Bot-Api-Secret-Token')), 403);

        try {
            $update = Validator::make($request->all(), [
                'update_id' => ['required', 'integer', 'min:1'],
                'message' => ['nullable', 'array'],
                'message.chat.id' => ['required_with:message', 'integer'],
                'message.chat.type' => ['required_with:message', 'string'],
                'message.from.id' => ['required_with:message', 'integer', 'min:1'],
                'message.text' => ['nullable', 'string', 'max:4096'],
            ])->validate();
        } catch (ValidationException $exception) {
            if ($request->missing('message')) {
                return response()->json(['ok' => true]);
            }

            throw $exception;
        }

        if (isset($update['message']) && ($update['message']['chat']['type'] ?? null) === 'private') {
            $handler->handle($update['update_id'], $update['message']);
        }

        return response()->json(['ok' => true]);
    }
}
