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

   $conversation = Conversation::whereHas('users', function($q) {
        $q->where('id', auth()->id());
    })
    ->whereHas('users', function($q) use ($request) {
        $q->where('id', $request->user_id);
    })
    ->first();


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
