@extends('layouts.app')

@section('title', 'Conversation')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h3 class="mb-3">Conversation</h3>

            {{-- メッセージ一覧 --}}
            @forelse($messages as $message)
    <div class="mb-2 d-flex {{ $message->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
        <div class="p-2 rounded 
            {{ $message->sender_id === auth()->id() ? 'bg-primary text-white' : 'bg-light' }}" 
            style="max-width: 70%;">
            
            {{-- 送信者名 --}}
            <small class="d-block">
                {{ $message->sender->name ?? 'Unknown User' }}
            </small>

            {{-- 本文 --}}
            <div>{{ $message->body }}</div>

            {{-- 送信時間 --}}
            <small class="text-muted">
                {{ $message->created_at->format('H:i') }}
            </small>
        </div>
    </div>
@empty
    <p class="text-muted">No messages yet.</p>
@endforelse


        </div>
    </div>

    {{-- 送信フォーム --}}
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
           <form action="{{ route('messages.store', $conversation->id) }}" method="POST">

                @csrf
                <div class="input-group">
                    <input type="text" name="body" class="form-control" placeholder="Type a message..." required>
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
