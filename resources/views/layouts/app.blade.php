<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <h1 class="h5 mb-0">{{ config('app.name') }}</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left -->
                @auth
                @if(!request()->is('admin/*'))
                <ul class="navbar-nav ms-auto">
                    <form action="{{route('search')}}" style="width:300px">
                        <input type="search" name='search' class="form-control form-control-sm" placeholder="Search...">
                    </form>
                </ul>
                @endif
                @endauth

                <!-- Right -->
                <ul class="navbar-nav ms-auto">
                    @guest
                        @if(Route::has('login'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        @endif
                        @if(Route::has('register'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                        @endif
                    @else
                        <li class="nav-item"><a href="{{ route('index') }}" class="nav-link"><i class="fa-solid fa-house text-dark icon-sm"></i></a></li>

                       {{-- Messages Dropdown --}}
                        <li class="nav-item dropdown">
                            <a id="messagesDropdown" class="nav-link position-relative" data-bs-toggle="dropdown" aria-expanded="false" href="#">
                                <i class="fa-solid fa-envelope text-dark icon-sm"></i>
                                @php
                                    $unreadCount = auth()->user()->unreadNotifications->count();
                                @endphp
                                @if($unreadCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $unreadCount }}
                                    </span>
                                @endif
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="messagesDropdown" style="width: 300px;">
                                <li class="dropdown-item text-center">
                                    <a href="{{ route('conversations.index') }}" class="btn btn-sm btn-outline-primary w-100">View All Conversations</a>
                                </li>
                                <li><hr class="dropdown-divider"></li>

                                @forelse(auth()->user()->unreadNotifications as $notification)
                                    <li class="dropdown-item d-flex justify-content-between align-items-center">
                                        <span>{{ $notification->data['message'] }}</span>
                                        {{-- ここで既読処理をしてから会話へ移動 --}}
                                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">Go</button>
                                        </form>
                                    </li>
                                @empty
                                    <li class="dropdown-item text-muted">No new messages</li>
                                @endforelse
                            </ul>
                        </li>

                        {{-- Create Post --}}
                        <li class="nav-item"><a href="{{ route('post.create') }}" class="nav-link"><i class="fa-solid fa-circle-plus text-dark icon-sm"></i></a></li>

                        {{-- Account Dropdown --}}
                        <li class="nav-item dropdown">
                            <button id="account-dropdown" class="btn shadow-none nav-link" data-bs-toggle="dropdown">
                                @if(Auth::user()->avatar)
                                    <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-dark icon-sm"></i>
                                @endif
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                @if(Gate::allows('admin'))
                                    <a href="{{ route('admin.users') }}" class="dropdown-item"><i class="fa-solid fa-user-gear"></i> Admin</a>
                                    <hr class="dropdown-divider">
                                @endif
                                <a href="{{ route('profile.show', Auth::user()->id) }}" class="dropdown-item"><i class="fa-solid fa-circle-user"></i> Profile</a>
                                <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                @if(request()->is('admin/*'))
                    <div class="col-3">
                        <div class="list-group">
                            <a href="{{route('admin.users')}}" class="list-group-item {{ request()->is('admin/users') ? 'active' : '' }}"><i class="fa-solid fa-users"></i> Users</a>
                            <a href="{{route('admin.posts')}}" class="list-group-item {{ request()->is('admin/posts') ? 'active' : '' }}"><i class="fa-solid fa-newspaper"></i> Posts</a>
                            <a href="{{route('admin.categories')}}" class="list-group-item"><i class="fa-solid fa-tags"></i> Categories</a>
                        </div>
                    </div>
                @endif

                <div class="col-9">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>
</div>

@livewireScripts
</body>
</html>
