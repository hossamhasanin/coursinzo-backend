<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request) : JsonResponse{
        $chats = Message::query()
            ->where("sender_id", $request->user()->id)
            ->orWhere("receiver_id", $request->user()->id)
            ->groupBy('chat_id')
            ->limit(25)
            ->get(["chat_id"]);

        $chatIds = $chats->pluck("chat_id");

        $lastMessages = Message::query()
            ->whereIn("chat_id", $chatIds)
            ->orderBy("created_at", "desc")
            ->get()
            ->unique("chat_id");

        $allUserChats = [];
        foreach ($lastMessages as $lastMessage){
            $otherUserId = $lastMessage->sender_id == $request->user()->id ? $lastMessage->receiver_id : $lastMessage->sender_id;
            $otherUser = User::query()->find($otherUserId);
            $senderOrReceiverKey = $lastMessage->sender_id == $request->user()->id ? "receiver": "sender";
            $allUserChats[] = [
                "${senderOrReceiverKey}_name" => $otherUser->name,
                "chat_id" => $lastMessage->chat_id,
                "message" => $lastMessage->message,
                "image_url" => $lastMessage->image_url,
                "audio_url" => $lastMessage->audio_url
            ];
        }

        return new JsonResponse([
            "data" => $allUserChats
        ]);
    }
}
