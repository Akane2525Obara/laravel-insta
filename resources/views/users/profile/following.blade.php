@extends('layouts.app')
 
@section('title', 'Following')
 
@section('content')
    {{-- profile header --}}
    @include('users.profile.header')

    {{-- following list --}}
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h3 class="text-secondary mb-0">Following</h3>

            @if($user->following->isEmpty())
                <p>Not following anyone yet.</p>
            @else
                <ul class="list-group">
                    @foreach($user->following as $following)
                        <li class="list-group-item d-flex align-items-center">
                            
                            {{-- icon --}}
                            @if ($following->following->avatar)
                                <img src="{{ $following->following->avatar }}" 
                                     alt="{{ $following->following->name }}" 
                                     class="rounded-circle me-3 avatar-sm">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary text-center icon-sm me-3"></i>
                            @endif
                            
                            {{-- name --}}
                            <a href="{{ route('profile.show', $following->following->id) }}" 
                               class="text-decoration-none text-dark ms-3 flex-grow-1">
                                {{ $following->following->name }}
                            </a>
                            
                            {{-- Follow / Following button --}}
                            @if (Auth::id() !== $following->following->id)
                                @if (Auth::user()->isFollowing($following->following->id))
                                    {{-- following button --}}
                                    <form action="{{ route('follow.destroy', $following->following->id) }}" method="POST" class="ms-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-secondary btn-sm fw-bold">Following</button>
                                    </form>
                                @else
                                    {{-- follow button --}}
                                    <form action="{{ route('follow.store', $following->following->id) }}" method="POST" class="ms-2">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm fw-bold">Follow</button>
                                    </form>
                                @endif
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
