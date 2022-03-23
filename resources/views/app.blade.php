<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', 'StackUnderflow') }}</title>
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/011810e4a7.js" crossorigin="anonymous"></script>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    @routes
    <script src="{{ mix('/js/app.js') }}" defer></script>
</head>
<body>
{{--@include('cookie-consent::index')--}}
@inertia
</body>
</html>
