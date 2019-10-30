<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @yield('head')
</head>
<body>
    @yield('content')
    @include('register')
    @include('login')
    @include('confirm')
    @include('layouts.footer')
    @yield('foot')
    @include('inc.message')
</body>
</html>