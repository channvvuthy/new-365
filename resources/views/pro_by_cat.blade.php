@extends('layouts.master')
@section('title') 365daymarket @stop
@include('layouts.head')
@section('content')
    <div id="app">
        @include('layouts.header')
        @include('inc.nav')
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="pro-list wbg">
                        <div class="note">
                            <ul class="list-inline">
                                <li><a href="{{URL::to('/')}}"><i class="fa fa-home"></i> Home</a></li>
                                <li> /</li>
                                <li>{{$name}}</li>
                            </ul>
                        </div>
                        @include('pro_list')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@include('layouts.foot')