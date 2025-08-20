<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Conversation;
use App\Notifications\NewMessageNotification;

class MessageController extends Controller
{
    /**
     * メッセージ送信
     */
    public function store(Request $request, Conversation $conversation)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        // メッセージを保存
        $conversation->messages()->create([
            'sender_id' => auth()->id(), // ← user_id ではなく sender_id
            'body' => $request->body,
            'is_read' => false, // 未読で登録
        ]);

        // 通知を送る（自分以外の参加者へ）
        foreach ($conversation->users as $user) {
            if ($user->id !== auth()->id()) {
                $user->notify(new NewMessageNotification($conversation, auth()->user()));
            }
        }

        return redirect()->route('conversations.show', $conversation);
    }

    /**
     * 既読処理
     */
    public function markAsRead(Conversation $conversation)
    {
        // 自分以外が送った未読メッセージを既読にする
        $conversation->messages()
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->route('conversations.show', $conversation);
    }
}
