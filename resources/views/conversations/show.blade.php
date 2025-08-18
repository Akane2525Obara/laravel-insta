@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Chat</h4>

    <div class="border p-3 mb-3" style="height:300px; overflow-y:scroll;">
        @foreach($messages as $message)
            <div class="@if($message->sender_id == auth()->id()) text-end @endif">
                <p><strong>{{ $message->sender->name }}:</strong> {{ $message->body }}</p>
                <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
            </div>
            <hr>
        @endforeach
    </div>

    <form action="{{ route('messages.store', $conversation) }}" method="POST">
        @csrf
        <div class="input-group">
            <input type="text" name="body" class="form-control" placeholder="Type a message...">
            <button class="btn btn-primary">Send</button>
        </div>
    </form>
</div>
@endsection
