@extends('layouts.app')

@section('title', $conversation->title ?? 'Conversation')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Back button --}}
            <div class="mb-3">
                <a href="{{ route('conversations.index') }}" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Conversations
                </a>
            </div>

            {{-- Header --}}
            <h3 class="mb-3 text-center fw-bold sticky-top bg-white py-2 shadow-sm">
                @if($conversation->users->count() > 2)
                    {{ $conversation->title ?? 'Group Chat' }}
                @else
                    {{ $partner->name ?? 'Unknown' }}
                @endif
            </h3>

            {{-- Participants --}}
            <div class="d-flex align-items-center mb-3">
                @if($conversation->users->count() > 2)
                    <i class="fa-solid fa-users text-primary me-2" style="font-size:40px;"></i>
                    <h5 class="mb-0 fw-bold">{{ $conversation->title ?? 'Group Chat' }}</h5>
                @else
                    @if($partner && $partner->avatar)
                        <img src="{{ $partner->avatar }}" alt="{{ $partner->name }}" class="rounded-circle me-2" style="width:40px; height:40px; object-fit:cover;">
                    @else
                        <i class="fa-solid fa-circle-user text-secondary me-2" style="font-size:40px;"></i>
                    @endif
                    <h5 class="mb-0 fw-bold">{{ $partner->name ?? 'Conversation' }}</h5>
                @endif
            </div>

            {{-- Chat messages --}}
            <div class="chat-box mb-3 p-3 bg-white rounded shadow-sm" style="height:400px; overflow-y:auto;">
                @forelse($messages as $message)
                    <div class="mb-3 d-flex {{ $message->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                        @if($message->sender_id !== auth()->id())
                            @if($message->sender->avatar)
                                <img src="{{ $message->sender->avatar }}" alt="{{ $message->sender->name }}" class="rounded-circle me-2" style="width:32px; height:32px; object-fit:cover;">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary me-2" style="font-size:32px;"></i>
                            @endif
                        @endif

                        <div class="chat-bubble {{ $message->sender_id === auth()->id() ? 'chat-bubble-right' : 'chat-bubble-left' }}">
                            @if($conversation->users->count() > 2 && $message->sender_id !== auth()->id())
                                <small class="fw-bold d-block mb-1">{{ $message->sender->name ?? 'Unknown' }}</small>
                            @endif
                            <div>{{ $message->body }}</div>
                            <small class="text-muted d-block mt-1" style="font-size:0.75rem;">
                                {{ $message->created_at->format('H:i') }}
                                {{-- 既読マークは自分が送ったメッセージのみ確認 --}}
                                @if($message->sender_id === auth()->id())
                                    @if($message->is_read)
                                        <span class="text-dark ms-2">Read</span>
                                    @else
                                        <span class="text-dark ms-2">Sent</span>
                                    @endif
                                @endif
                            </small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No messages yet.</p>
                @endforelse
            </div>

            {{-- Message form --}}
           <form action="{{ route('conversations.messages.store', $conversation->id) }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="body" class="form-control rounded-pill" placeholder="Type a message..." required>
                    <button type="submit" class="btn btn-primary rounded-pill ms-2 px-4">Send</button>
                </div>
            </form>

        </div>
    </div>
</div>

<style>
.chat-bubble { padding:10px 15px; border-radius:18px; max-width:70%; box-shadow:0 2px 5px rgba(0,0,0,0.1); }

.chat-bubble-left { background-color:#f1f1f1; color:#333; border-bottom-left-radius:0; }

.chat-bubble-right { background-color:#0d6efd; color:white; border-bottom-right-radius:0; }

.chat-box { background-color:#f9fafb; }
</style>
@endsection
