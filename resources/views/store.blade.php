@extends('layouts.master')
@section('title') 365daymarket @stop
@include('layouts.head')
@section('content')
    <div id="app">
        @include('store_header')
        <div class="container">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="store">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile">
                                        @if(!empty($user))
                                            @if(!empty($user->image))
                                                <img src="{{asset('images')}}/{{$user->image}}" alt=""
                                                     class="img-responsive">
                                            @else
                                                <img src="{{asset('images/profile-defult.png')}}" class="img-responsive"
                                                     alt="">
                                            @endif
                                        @endif
                                        <div style="position: relative;top:20px;">
                                            <p><b>{{$user->name}}</b></p>
                                            <p><b>Member since {{date('F d, Y', strtotime($user->created_at))}}</b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-3 col-lg-offset-1">
                                    <ul class="list-inline" style="padding-left: 20px;">
                                        <li><a href="" class="color"><b>All Posts</b></a></li>
                                        <li><a href="" class="color"><b>Contact</b></a></li>
                                        <li><a href="" class="color"><b>Member Status</b></a></li>
                                    </ul>
                                </div>
                                <div class="col-md-8 text-right">
                                    <ul class="list-inline">
                                        <li><a href="" class="btn btn-default btn-md"><i class="fa fa-share"></i> Share</a></li>
                                        <li><a href="" class="btn btn-primary btn-md"><i class="fa fa-phone"></i> Call Now</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@include('layouts.foot')