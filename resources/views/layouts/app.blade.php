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

    <!-- EasyMDE -->
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>

    <!-- CreativeBulma/Bulma TagsInput -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/@creativebulma/bulma-tagsinput@1.0.2/dist/css/bulma-tagsinput.min.css"/>
    <script
        src="https://cdn.jsdelivr.net/npm/@creativebulma/bulma-tagsinput@1.0.2/dist/js/bulma-tagsinput.min.js"></script>
</head>
<body>
<nav class="navbar is-transparent">
    <div class="navbar-brand">
        <a class="navbar-logo navbar-item" href="{{ route('home') }}">
            {{--<span>S</span>U--}}
            Stack Underflow
        </a>
    </div>
    <div class="navbar-item is-expanded">
        <form class="search-bar" method="GET" action="{{ route('search') }}">
            @csrf
            <div class="control is-expanded">
                <input class="input" type="text" name="search" placeholder="Search">
            </div>
        </form>
    </div>
    <div class="navbar-end">
        @auth
            <div class="navbar-item">
                <div class="user-profile dropdown is-right is-hoverable">
                    <a class="dropdown-trigger">
                        <img src="{{ Auth::user()->avatar }}" alt="">
                    </a>
                    <div class="dropdown-menu">
                        <div class="dropdown-content">
                            <a class="dropdown-item" href="{{ route('user.show', Auth::user()) }}">
                                Profile
                            </a>
                            <a class="dropdown-item" href="{{ route('user.edit', Auth::user()) }}">
                                Edit profile
                            </a>
                            <hr class="dropdown-divider">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item is-white"
                                   type="submit"
                                   onclick="event.preventDefault(); this.parentElement.submit();">
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
@yield('content')
@stack('scripts')
</body>
</html>
