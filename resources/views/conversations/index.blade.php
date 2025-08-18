@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Conversations</h4>
    <ul class="list-group">
        @foreach($conversations as $conversation)
            <li class="list-group-item">
                <a href="{{ route('conversations.show', $conversation) }}">
                    {{ $conversation->users->where('id','!=',auth()->id())->pluck('name')->join(', ') }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
