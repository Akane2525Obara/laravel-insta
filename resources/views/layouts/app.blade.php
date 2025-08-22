<!doctype html>
{{-- 1 data-bs-theme="light" --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    {{-- <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Dark Mode Improvements -->
    <meta name="color-scheme" content="light dark">
    <style>
        /* ===== 読みやすいダーク配色（最小構成） ===== */
        [data-bs-theme="dark"] {
            /* 基本色 */
            --bs-body-bg: #0e1116;
            --bs-body-color: #e9eef5;
            --bs-border-color: #2b313a;

            /* カード/入力/メニュー */
            --bs-card-bg: #151a21;
            --bs-card-border-color: #2b313a;
            --bs-input-bg: #0f1319;
            --bs-dropdown-bg: #151a21;

            /* リンクと見出し */
            --bs-link-color: #85c4ff;
            --bs-link-hover-color: #d2e9ff;
            --bs-heading-color: #ffffff;

            /* 薄文字の明度アップ（名前/補助テキスト対策） */
            --bs-secondary-color: #c9d2dc;
            --bs-secondary-color-rgb: 201, 210, 220;
        }

        /* ナビはテーマ色に追随しつつ境界を強調 */
        [data-bs-theme="dark"] .navbar {
            background-color: var(--bs-card-bg) !important;
            border-color: var(--bs-border-color) !important;
        }

        /* list-group / form / dropdown のコントラスト */
        [data-bs-theme="dark"] .list-group-item {
            background-color: var(--bs-card-bg);
            color: var(--bs-body-color);
            border-color: var(--bs-card-border-color);
        }

        [data-bs-theme="dark"] .form-control {
            border-color: var(--bs-border-color);
        }

        [data-bs-theme="dark"] .dropdown-menu {
            border-color: var(--bs-card-border-color);
        }

        /* 薄色バッジが暗所で飛ばないように */
        [data-bs-theme="dark"] .badge.bg-light {
            color: #0f1115;
        }

        /* トグルボタンの視認性 */
        [data-bs-theme="dark"] #theme-toggle {
            color: var(--bs-body-color);
            border-color: #3a4350;
        }

        /* スムーズな切り替え */
        body,
        .navbar,
        .card,
        .list-group-item,
        .form-control,
        .dropdown-menu {
            transition: background-color .2s ease, color .2s ease, border-color .2s ease, box-shadow .2s ease;
        }

        /* カードの影を少し強めに */
        [data-bs-theme="dark"] .card {
            box-shadow: 0 2px 8px rgba(0, 0, 0, .55);
        }

        /* 文字が薄い問題の最終対処 */
        [data-bs-theme="dark"] .text-muted,
        [data-bs-theme="dark"] .text-body-secondary,
        [data-bs-theme="dark"] small,
        [data-bs-theme="dark"] .small,
        [data-bs-theme="dark"] .text-secondary {
            --bs-text-opacity: 1 !important;
            color: #cfd6df !important;
        }

        [data-bs-theme="dark"] .text-dark,
        [data-bs-theme="dark"] a.text-dark {
            color: var(--bs-body-color) !important;
        }

        [data-bs-theme="dark"] .bg-white,
        [data-bs-theme="dark"] .card.bg-white {
            background-color: var(--bs-card-bg) !important;
            color: var(--bs-body-color) !important;
            border-color: var(--bs-card-border-color) !important;
        }

        [data-bs-theme="dark"] .list-group-item *:not(a) {
            color: var(--bs-body-color) !important;
        }

        /* 任意：検索欄などのプレースホルダ */
        [data-bs-theme="dark"] ::placeholder {
            color: rgba(233, 238, 245, .75);
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles   {{-- LivewireのCSS --}}
</head>

<body>
    <div id="app">
        {{-- Navbar --}}
        <nav class="navbar navbar-expand-md bg-body border-bottom shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <h1 class="h5 mb-0">{{ config('app.name') }}</h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                        @if (!request()->is('admin/*'))
                            <ul class="navbar-nav ms-auto">
                                <form action="{{ route('search') }}" style="width:300px">
                                    <input type="search" name='search' class="form-control form-control-sm"
                                        placeholder="Search...">
                                </form>
                            </ul>
                        @endif
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            {{-- Dark mode toggle --}}
                            <li class="nav-item">
                                <button id="theme-toggle" class="btn btn-outline-secondary btn-sm">
                                    <span id="theme-icon">🌙</span>
                                </button>
                            </li>

                            {{-- Home --}}
                            <li class="nav-item" title="Home">
                                <a href="{{ route('index') }}" class="nav-link"><i
                                        class="fa-solid fa-house text-body icon-sm"></i></a>
                            </li>

                          {{-- Direct Messages --}}
                            <li class="nav-item" title="Messages">
                                <a href="{{ route('conversations.index') }}" class="nav-link">
                                    <i class="fa-solid fa-envelope text-dark icon-sm"></i>
                                </a>
                            </li>




                            {{-- Create Post --}}
                            <li class="nav-item" title="Create Post">
                                <a href="{{ route('post.create') }}" class="nav-link"><i
                                        class="fa-solid fa-circle-plus text-body icon-sm"></i></a>
                            </li>

                            {{-- Account --}}
                            <li class="nav-item dropdown">
                                <button id="account-dropdown" class="btn shadow-none nav-link" data-bs-toggle="dropdown">
                                    @if (Auth::user()->avatar)
                                        <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}"
                                            class="rounded-circle avatar-sm">
                                    @else
                                        <i class="fa-solid fa-circle-user text-body icon-sm"></i>
                                    @endif
                                </button>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="account-dropdown">
                                    @if (Gate::allows('admin'))
                                        <a href="{{ route('admin.users') }}" class="dropdown-item">
                                            <i class="fa-solid fa-user-gear"></i> Admin
                                        </a>
                                        <hr class="dropdown-divider">
                                    @endif

                                    {{-- Profile --}}
                                    <a href="{{ route('profile.show', Auth::user()->id) }}" class="dropdown-item">
                                        <i class="fa-solid fa-circle-user"></i> Profile
                                    </a>

                                    {{-- Logout --}}
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa-solid fa-right-from-bracket"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
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
                    @if (request()->is('admin/*'))
                        <div class="col-3">
                            <div class="list-group">
                                <a href="{{ route('admin.users') }}"
                                    class="list-group-item {{ request()->is('admin/users') ? 'active' : '' }}">
                                    <i class="fa-solid fa-users"></i> Users
                                </a>
                                <a href="{{ route('admin.posts') }}"
                                    class="list-group-item {{ request()->is('admin/posts') ? 'active' : '' }}">
                                    <i class="fa-solid fa-newspaper"></i> Posts
                                </a>
                                <a href="{{ route('admin.categories') }}" class="list-group-item">
                                    <i class="fa-solid fa-tags"></i> Categories
                                </a>
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

    @livewireScripts  {{-- LivewireのJS --}}
</body>

{{-- Dark mode toggle script --}}
<script>
    const html = document.documentElement;
    const key = 'theme';

    // 初期適用
    const saved = localStorage.getItem(key);
    if (saved === 'dark' || saved === 'light') {
        html.setAttribute('data-bs-theme', saved);
    } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        html.setAttribute('data-bs-theme', 'dark');
    } else {
        html.setAttribute('data-bs-theme', 'light');
    }

    // アイコン更新
    function syncIcon() {
        const icon = document.getElementById('theme-icon');
        if (icon) {
            icon.textContent = (html.getAttribute('data-bs-theme') === 'dark') ? '☀️' : '🌙';
        }
    }
    syncIcon();

    // クリックで切替
    document.getElementById('theme-toggle')?.addEventListener('click', () => {
        const next = (html.getAttribute('data-bs-theme') === 'dark') ? 'light' : 'dark';
        html.setAttribute('data-bs-theme', next);
        localStorage.setItem(key, next);
        syncIcon();
    });

    // OSテーマ変更に追随（保存がない場合のみ）
    const mq = window.matchMedia('(prefers-color-scheme: dark)');
    mq.addEventListener?.('change', e => {
        if (!localStorage.getItem(key)) {
            html.setAttribute('data-bs-theme', e.matches ? 'dark' : 'light');
            syncIcon();
        }
    });
</script>

</html>
