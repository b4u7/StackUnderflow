<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'StackUnderflow') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/js/all.min.js"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.2/css/bulma.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- EasyMDE Styles -->
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">

    <!-- EasyMDE Script -->
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
</head>
<body>
<nav class="navbar is-transparent">
    <div class="navbar-brand">
        <a class="navbar-item" href="{{ route('home') }}">
            Stack Underflow
        </a>
    </div>
    <div class="searchbar navbar-item is-expanded">
        <!-- TODO: Remove the inline styling -->
        <form style="flex: 1 0 auto;" method="GET" action="{{ route('search') }}">
            @csrf
            <div class="control is-expanded">
                <input class="input" type="text" name="search" placeholder="Search">
            </div>
        </form>
    </div>
    <div class="navbar-end">
        @auth
            <div class="navbar-item">
                <div class="dropdown is-right is-hoverable">
                    <a class="dropdown-trigger">
                        <figure class="image">
                            <img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}"
                                 alt=""
                            >
                        </figure>
                    </a>
                    <div class="dropdown-menu" id="dropdown-menu-user">
                        <div class="dropdown-content">
                            <a class="dropdown-item">
                                Profile
                            </a>
                            <a class="dropdown-item">
                                Settings
                            </a>
                            <hr class="dropdown-divider">
                            <form id="logout-form" method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item is-white"
                                   type="submit"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endauth
        @guest
            <a class="navbar-item" href="{{ route('login') }}">
                Login
            </a>
            <a class="navbar-item" href="{{ route('register') }}">
                Register
            </a>
        @endguest
    </div>
</nav>
<section class="section">
    @yield('content')
</section>
@stack('scripts')
</body>
</html>
