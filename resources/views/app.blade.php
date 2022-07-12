<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', 'StackUnderflow') }}</title>
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link
        href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.5.0/build/styles/github.min.css"
        rel="stylesheet"
    >
    {{-- highlightjs github dark theme
    <link href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.5.0/build/styles/github-dark.min.css" rel="stylesheet">
    --}}
    <link
        href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.5.0/build/styles/github.min.css"
        rel="stylesheet"
    >
    <script src="https://kit.fontawesome.com/011810e4a7.js" crossorigin="anonymous"></script>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    @routes
    <script src="{{ mix('/js/app.js') }}" defer></script>

    @inertiaHead
</head>
<body>
{{--@include('cookie-consent::index')--}}
@inertia
</body>
{{--<script>
    // On page load or when changing themes, best to add inline in `head` to avoid FOUC
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark')
    } else {
        document.documentElement.classList.remove('dark')
    }

    // Whenever the user explicitly chooses light mode
    localStorage.theme = 'light'

    // Whenever the user explicitly chooses dark mode
    localStorage.theme = 'dark'

    // Whenever the user explicitly chooses to respect the OS preference
    localStorage.removeItem('theme')
</script>--}}
</html>
