<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<nav class="navbar is-transparent">
    <div class="navbar-brand">
        <a class="navbar-item">
            Stack Underflow
        </a>
    </div>
    <div class="navbar-item is-expanded">
        <input class="input" type="text" placeholder="Search">
    </div>
    <div class="navbar-end">
        @auth
            <div class="navbar-item">
                {{ Auth::user()->name }}
            </div>
            <div class="navbar-item">
                <div class="dropdown is-hoverable">
                    <div class="dropdown-trigger">
                        <figure class="image">
                            <div class="has-background-danger"
                                 style="width: 43px; height: 43px; border-radius: 290486px;">
                            </div>
                        </figure>
                    </div>
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
</body>
</html>
