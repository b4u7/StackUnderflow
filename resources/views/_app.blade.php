<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'StackUnderflow') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/js/all.min.js"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- EasyMDE -->
    <link href="https://unpkg.com/easymde/dist/easymde.min.css" rel="stylesheet">
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>

    <!-- Tippy.JS -->
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
</head>
<body>
<div id="app">
    <v-navbar></v-navbar>

    {{--
    <nav class="navbar bg-primary-100">
        <div class="container">
            <div class="navbar-menu">
                <div class="navbar-start">
                    <a class="navbar__item" href="{{ route('user.index') }}">
                        Users
                    </a>
                </div>
            </div>
        </div>
    </nav>
    --}}

    @yield('content')
</div>
<script>
    window.Laravel = {!! json_encode([
        'base_url' => url('/'),
        'authed' => Auth::check(),
        'user' => Auth::user(),
        'csrfToken' => csrf_token(),
        'assetUrl' => config('app.assets_url')
    ]) !!};
</script>

@stack('scripts')
</body>
</html>
