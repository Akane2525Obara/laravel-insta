<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class ConversationController extends Controller
{
    // 会話一覧
    public function index()
    {
        $user = auth()->user();

        // 自分が参加している会話を取得
        $conversations = $user->conversations()->with('users')->get();

        // 会話ごとの未読通知をまとめる
        $notifications = $user->unreadNotifications()
            ->where('type', \App\Notifications\NewMessageNotification::class)
            ->get()
            ->groupBy(function ($notification) {
                return $notification->data['conversation_id'];
            });

        // 新しい会話作成用に他ユーザー一覧
        $allUsers = User::where('id', '!=', $user->id)->get();

        return view('conversations.index', compact('conversations', 'allUsers', 'notifications'));
    }

    // 会話作成
    public function store(Request $request)
    {
        $request->validate([
            'users' => 'required|array|min:1',
            'users.*' => 'exists:users,id',
            'title' => 'nullable|string|max:255',
        ]);

        $selectedUsers = $request->users;

        if (count($selectedUsers) === 1) {
            // 1対1チャット
            $userId = $selectedUsers[0];

            $conversation = Conversation::whereHas('users', fn($q) => $q->where('users.id', auth()->id()))
                ->whereHas('users', fn($q) => $q->where('users.id', $userId))
                ->first();

            if (!$conversation) {
                $conversation = Conversation::create(['title' => null]);
                $conversation->users()->attach([auth()->id(), $userId]);
            }
        } else {
            // グループチャット
            $conversation = Conversation::create([
                'title' => $request->title ?? 'Group Chat',
            ]);
            $conversation->users()->attach(array_merge($selectedUsers, [auth()->id()]));
        }

        return redirect()->route('conversations.show', $conversation);
    }

    // 会話表示（通知とメッセージ既読を更新）
    public function show(Conversation $conversation)
    {
        // 🔹 通知を既読にする
        Auth::user()->unreadNotifications
            ->where('data.conversation_id', $conversation->id)
            ->each(function (DatabaseNotification $notification) {
                $notification->markAsRead();
            });

        // 🔹 メッセージを既読にする（自分以外が送った未読メッセージのみ）
        Message::where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = $conversation->messages()->with('sender')->orderBy('created_at', 'asc')->get();
        $partner = null;

        if (!$conversation->is_group) {
            $partner = $conversation->users()->where('users.id', '!=', Auth::id())->first();
        }

        return view('conversations.show', compact('conversation', 'messages', 'partner'));
    }

    // プロフィールから1対1チャット開始
    public function start(User $user)
    {
        $authUser = Auth::user();

        if ($authUser->id === $user->id) {
            return redirect()->back()->with('error', 'You cannot message yourself.');
        }

        // 既存の1対1会話を検索
        $conversation = Conversation::whereNull('title')
            ->whereHas('users', fn($q) => $q->where('user_id', $authUser->id))
            ->whereHas('users', fn($q) => $q->where('user_id', $user->id))
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create();
            $conversation->users()->attach([$authUser->id, $user->id]);
        }

        return redirect()->route('conversations.show', $conversation->id);
    }
}
