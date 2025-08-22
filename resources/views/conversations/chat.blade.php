@extends('layouts.app')

@section('title', $conversation->title ?? 'Chat')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Chat window -->
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white fw-bold">
                    {{ $conversation->title ?? 'Chat Room' }}
                </div>

                <!-- Chat messages -->
                <div class="card-body p-3" id="chat-box" 
                     style="height: 400px; overflow-y: auto; background: #f5f7fb;">
                    
                    @foreach($messages as $message)
                        @if($message->user_id === Auth::id())
                            <!-- 自分のメッセージ -->
                            <div class="d-flex mb-3 justify-content-end">
                                <div>
                                    <!-- グループの場合は自分の名前は省略してOK -->
                                    <div class="p-2 px-3 bg-primary text-white rounded-3 shadow-sm" 
                                         style="max-width: 75%;">
                                        {{ $message->body }}
                                    </div>
                                    <small class="text-muted d-flex justify-content-end">
                                        {{ $message->created_at->format('H:i') }}
                                    </small>
                                </div>
                                <div class="ms-2">
                                    <img src="{{ Auth::user()->profile_image ?? 'https://via.placeholder.com/40' }}" 
                                         class="rounded-circle" width="40" height="40" alt="me">
                                </div>
                            </div>
                        @else
                            <!-- 他人のメッセージ -->
                            <div class="d-flex mb-3">
                                <div class="me-2">
                                    <img src="{{ $message->user->profile_image ?? 'https://via.placeholder.com/40' }}" 
                                         class="rounded-circle" width="40" height="40" alt="user">
                                </div>
                                <div>
                                    <!-- グループチャットなら名前を表示 -->
                                    @if($conversation->is_group)
                                        <div class="fw-bold small text-secondary mb-1">
                                            {{ $message->user->name }}
                                        </div>
                                    @endif
                                    <div class="p-2 px-3 bg-light rounded-3 shadow-sm" 
                                         style="max-width: 75%;">
                                        {{ $message->body }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $message->created_at->format('H:i') }}
                                    </small>
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>

                <!-- Input box -->
                <div class="card-footer bg-white border-0">
                    <form action="{{ route('messages.store', $conversation->id) }}" method="POST" class="d-flex">
                        @csrf
                        <input type="text" name="body" class="form-control rounded-pill me-2" placeholder="Type a message...">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            Send
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
