@extends('layouts.master')
@section('title') 365daymarket @stop
@include('layouts.head')
@section('content')
    <div id="app">
        @include('layouts.header')
        @include('inc.nav')
        <div class="container">
            <product/>
        </div>
    </div>
@stop
@include('layouts.foot')