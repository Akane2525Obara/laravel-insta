@extends('layouts.app')

@section('title', 'Conversations')

@section('content')
<div class="container">
    <h3 class="mb-3 text-primary">Conversations</h3>

    {{-- 新しい会話を作成 --}}
    <form action="{{ route('conversations.store') }}" method="POST" class="mb-4 p-3 border rounded bg-light">
        @csrf

        <div class="mb-2">
            <label for="title" class="form-label">Group Title</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Enter group title">
        </div>

        <div class="mb-2">
            <label for="users" class="form-label">Select users</label>
            <select name="users[]" id="users" class="form-select" multiple required>
                @foreach($allUsers as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            <small class="text-muted">Hold Ctrl (Windows) / Command (Mac) to select multiple users.</small>
        </div>

        <button class="btn btn-primary w-100">Start Conversation</button>
    </form>

    {{-- 会話リスト --}}
    <div class="list-group shadow-sm">
        @forelse($conversations as $conversation)
            <a href="{{ route('conversations.show', $conversation->id) }}"
               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                
                <div>
                    {{-- グループチャット --}}
                    @if($conversation->title)
                        <span class="fw-bold text-primary">
                            <i class="fa-solid fa-users me-1"></i> {{ $conversation->title }}
                        </span>
                        <br>
                        <small class="text-muted">
                            Members:
                            @foreach($conversation->users as $u)
                                {{ $u->id !== auth()->id() ? $u->name : 'You' }}@if(!$loop->last),@endif
                            @endforeach
                        </small>
                    @else
                        {{-- 1対1チャット --}}
                        <span class="fw-bold">
                            <i class="fa-solid fa-user me-1"></i>
                            @foreach($conversation->users as $u)
                                @if($u->id !== auth()->id())
                                    {{ $u->name }}
                                @endif
                            @endforeach
                        </span>
                    @endif
                </div>

                {{-- 未読通知数をバッジ表示 --}}
                @if(isset($notifications[$conversation->id]) && $notifications[$conversation->id]->count() > 0)
                    <span class="badge bg-danger rounded-pill">
                        {{ $notifications[$conversation->id]->count() }}
                    </span>
                @endif
            </a>
        @empty
            <div class="list-group-item text-muted">No conversations yet.</div>
        @endforelse
    </div>
</div>
@endsection
