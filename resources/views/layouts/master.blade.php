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
    @if(Auth::check())
        <input type="hidden" name="uid" id="uid" value="{{Auth::user()->id}}">
    @endif
    @yield('content')
    <input type="hidden" name="homeUrl" id="homeUrl" value="http://365daymarket.com/">
    @include('register')
    @include('login')
    @include('forgot')
    @include('reset')
    @include('confirm')
    @include('layouts.footer')
    @yield('foot')
    @include('inc.message')
</body>
</html>