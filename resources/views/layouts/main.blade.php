<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="userAccount" content="{{ (Auth::check()) ? Auth::user()->wallet : '' }}">
    <meta name="pubKeys" content="{{ (Auth::check()) ? Auth::user()->pubKeys : '' }}">
    <title>Staking | Golden Cage</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/script.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/waxjs.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/waxjsmain.js') }}" type="text/javascript"></script>
    <script src="https://unpkg.com/anchor-link@3"></script>
    <script src="https://unpkg.com/anchor-link-browser-transport@3"></script>
    <script src="{{ asset('js/anchor.js') }}"></script>
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/82569946" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
</head>
<body>
<div class="w-100 h-100 vh-100">
    @include('layouts.header')
    <main>
        <div class="container-fluid px-0 min-vh-100 gc-main-bg">
            @yield('content')
        </div>
    </main>
    @include('layouts.footer')
</div>

</body>
</html>
