@extends('layouts.app')

@section('title', 'Conversations')

@section('content')
<div class="container">
    <h3>Conversations</h3>

    {{-- 新しい会話を作成 --}}
    <form action="{{ route('conversations.store') }}" method="POST" class="mb-3">
        @csrf
        <div class="input-group">
            <select name="user_id" class="form-select" required>
                <option value="">-- Select user --</option>
                @foreach(App\Models\User::where('id', '!=', auth()->id())->get() as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary">Start</button>
        </div>
    </form>

    {{-- 会話リスト --}}
    <ul class="list-group">
        @forelse($conversations as $conversation)
            <li class="list-group-item">
                <a href="{{ route('conversations.show', $conversation->id) }}">
                    @foreach($conversation->users as $u)
                        @if($u->id !== auth()->id())
                            {{ $u->name }}
                        @endif
                    @endforeach
                </a>
            </li>
        @empty
            <li class="list-group-item">No conversations yet.</li>
        @endforelse
    </ul>
</div>
@endsection
