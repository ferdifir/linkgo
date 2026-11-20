<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminChatMessageRequest;
use App\Services\AdminChatAssistant;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class AdminChatController extends Controller
{
    public function __invoke(AdminChatMessageRequest $request, AdminChatAssistant $assistant): JsonResponse
    {
        $data = $request->validated();
        if ($request->hasFile('file')) {
            return response()->json($assistant->uploadMedia($request->user(), $data['file'], $data['altText']), 201);
        }
        $conversationId = $data['conversationId'] ?? (string) Str::uuid();

        return response()->json($assistant->reply(
            $request->user(),
            $conversationId,
            trim($data['message']),
        ));
    }
}
