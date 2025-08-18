@extends('layouts.app')

@section('title', 'Chat')

@section('content')
<div class="container">
    <h4 class="mb-3">Chat with 
        @foreach($conversation->users as $user)
            @if($user->id !== auth()->id())
                {{ $user->name }}
            @endif
        @endforeach
    </h4>

    {{-- チャットログ --}}
    <div class="card mb-3" style="height: 400px; overflow-y: auto;">
        <div class="card-body d-flex flex-column">
            @forelse($messages as $message)
                <div class="mb-2 d-flex {{ $message->user_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                    <div class="p-2 rounded 
                        {{ $message->user_id === auth()->id() ? 'bg-primary text-white' : 'bg-light' }}" 
                        style="max-width: 70%;">
                        <small class="d-block">{{ $message->sender->name }}</small>
                        <div>{{ $message->body }}</div>
                        <small class="text-muted">{{ $message->created_at->format('H:i') }}</small>
                    </div>
                </div>
            @empty
                <p class="text-muted">No messages yet.</p>
            @endforelse
        </div>
    </div>

    {{-- 送信フォーム --}}
    <form action="{{ route('messages.store', $conversation) }}" method="POST" class="d-flex">
        @csrf
        <input type="text" name="body" class="form-control me-2" placeholder="Type a message..." required>
        <button type="submit" class="btn btn-primary">Send</button>
    </form>
</div>
@endsection
