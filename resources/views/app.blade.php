<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} | Movies in close-up</title>
        <meta name="description" content="A social media platform for movie enthusiasts.">

        <meta property="og:url" content="{{ config('app.url', 'http://localhost') }}">
        <meta property="og:type" content="website">
        <meta property="og:title" content="Coda">
        <meta property="og:description" content="Movies in close-up">
        <meta property="og:image" content="{{ config('app.url', 'http://localhost') }}/img/icon.png">

        <link rel="manifest" href="/site.webmanifest">
        <link rel="apple-touch-icon" href="/img/icon.png">

        <meta name="theme-color" content="#3766AF">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Domine&family=Merriweather&family=Raleway:wght@400;600&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
