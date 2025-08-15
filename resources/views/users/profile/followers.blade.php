@extends('layouts.app')
 
@section('title', 'Followers')
 
@section('content')
    {{-- プロフィールヘッダー --}}
    @include('users.profile.header')

    {{-- フォロワー一覧 --}}

    <div class="row justify-content-center">

        <div class=" col-md-6">

                <h3 class="text-secondary  mb-0">Followers</h3>
                
                @if($user->followers->isEmpty())
                <p>No followers yet.</p>
                @else
                <ul class="list-group">
                    @foreach($user->followers as $follower)
                    <li class="list-group-item d-flex align-items-center">
                        
                        {{-- icon --}}
                        {{-- <img src="{{ $follower->follower->avatar }}" 
                        alt="{{ $follower->follower->name }}" 
                        class="rounded-circle me-3"
                        width="40" height="40"> --}}
                        @if ($follower->follower->avatar)
                        <img src="{{$follower->follower->avatar }}" alt="{{$follower->follower->name}}" class="rounded-circle me-3 avatar-sm"
                        >
                        
                        @else
                        <i class="fa-solid fa-circle-user text-secondary text-center icon-sm me-3" ></i>
                        @endif
                        
                        {{-- name --}}
                        <a href="{{ route('profile.show', $follower->follower->id) }}" 
                            class="text-decoration-none text-dark ms-3 flex-grow-1">
                            {{ $follower->follower->name }}
                        </a>
                        
                        {{-- Follow link --}}
                        @if (Auth::id() !== $follower->follower->id)
                        @if (Auth::user()->isFollowing($follower->follower->id))
                        {{-- following button --}}
                        <form action="{{ route('follow.destroy', $follower->follower->id) }}" method="POST" class="ms-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-secondary btn-sm fw-bold">Following</button>
                        </form>
                        @else
                        {{-- follow button --}}
                        <form action="{{ route('follow.store', $follower->follower->id) }}" method="POST" class="ms-2">
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
