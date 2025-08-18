<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;

class ConversationController extends Controller
{
    public function index()
    {
        $conversations = auth()->user()->conversations()->with('users')->get();
        return view('conversations.index', compact('conversations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // 自分と相手の会話を探す
        $conversation = Conversation::whereHas('users', function ($q) {
                $q->where('users.id', auth()->id());   // ← 修正ポイント
            })
            ->whereHas('users', function ($q) use ($request) {
                $q->where('users.id', $request->user_id);  // ← 修正ポイント
            })
            ->first();

        // なければ新規作成
        if (!$conversation) {
            $conversation = Conversation::create();
            $conversation->users()->attach([auth()->id(), $request->user_id]);
        }

        return redirect()->route('conversations.show', $conversation);
    }

    public function show(Conversation $conversation)
    {
        $messages = $conversation->messages()->with('sender')->orderBy('created_at')->get();
        return view('conversations.show', compact('conversation', 'messages'));
    }
}
