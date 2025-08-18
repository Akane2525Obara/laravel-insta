<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Conversation;

class MessageController extends Controller
{
    public function store(Request $request, Conversation $conversation)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        // メッセージを保存
        $conversation->messages()->create([
            'sender_id' => auth()->id(), // ← user_id ではなく sender_id
            'body' => $request->body,
        ]);

        return redirect()->route('conversations.show', $conversation);
    }
}
