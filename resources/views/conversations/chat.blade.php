@extends('layouts.app')

@section('title', 'Chat')

@section('content')
<div class="container py-3">
    <div class="card shadow">
        <div class="card-header bg-light">
            <strong>
                {{ $conversation->users->where('id', '!=', auth()->id())->pluck('name')->join(', ') }}
            </strong>
        </div>
        <div class="card-body" id="chat-box" style="height: 400px; overflow-y: scroll;">
            @foreach($messages as $message)
                <div class="d-flex mb-2 {{ $message->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                    <div class="p-2 rounded 
                        {{ $message->sender_id === auth()->id() ? 'bg-primary text-white' : 'bg-light' }}" 
                        style="max-width: 70%;">
                        <small>{{ $message->sender->name }}</small><br>
                        {{ $message->body }}
                        <div class="text-muted small text-end">{{ $message->created_at->format('H:i') }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card-footer">
            <form action="{{ route('messages.store', $conversation) }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="body" class="form-control" placeholder="Type a message..." required>
                    <button class="btn btn-primary" type="submit">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
