@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="container">
    <h3 class="mb-3 text-primary">Notifications</h3>

    <ul class="list-group shadow-sm">
        @forelse($notifications as $notification)
            <li class="list-group-item d-flex justify-content-between align-items-center 
                {{ $notification->read_at ? '' : 'fw-bold' }}">
                
                {{-- 通知メッセージ --}}
                {{ $notification->data['message'] ?? 'No message' }}

                {{-- 既読ボタン --}}
                <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="ms-3">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-primary">
                        View
                    </button>
                </form>
            </li>
        @empty
            <li class="list-group-item text-muted">No notifications yet.</li>
        @endforelse
    </ul>
</div>
@endsection
