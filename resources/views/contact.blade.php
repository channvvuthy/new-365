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
                                        <div class="social pull-right">
                                            <ul class="list-inline" style="position: relative;bottom: -40px;z-index:2;">
                                                <li>
                                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{URL::to('/')}}/store/{{$user->id}}"
                                                       class="btn btn-default btn-md"><i
                                                                class="fa fa-share"></i>
                                                        Share</a></li>
                                                <li><a href="tel:010545450" class="btn btn-primary btn-md"><i
                                                                class="fa fa-phone"></i>
                                                        Call Now</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs" style="z-index:1">
                                        <li>
                                            <a href="{{URL::to('store')}}/{{$user->id}}" class="color">
                                                &nbsp;All Posts</a>
                                        </li>
                                        <li class="active">
                                            <a href="{{URL::to('contact')}}/{{$user->id}}" class="color">Contact</a>
                                        </li>
                                        <li>
                                            <a href="{{URL::to('member')}}/{{$user->id}}" class="color">Member
                                                Status</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-12">

                                <div class="clearfix"></div>
                                <br>
                                <div id="products" class="list-group contact">
                                    <div class="col-md-12">
                                        <br>
                                        <h3><b>Contact {{$user->name}}</b></h3>
                                        <ul class="list-unstyled">
                                            <li>
                                                <ul class="list-inline">
                                                    <li class="first_con">Phone Number</li>
                                                    <li>: {{$user->phone}}</li>
                                                </ul>
                                            </li>
                                            <li>
                                                <ul class="list-inline">
                                                    <li class="first_con">Website</li>
                                                    <li>: <a href="{{URL::to('/')}}/store/{{$user->id}}" class="color">{{URL::to('/')}}/store/{{$user->id}}</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <ul class="list-inline">
                                                    <li class="first_con">Location</li>
                                                    <li>: City/Province {{$user->location}}</li>
                                                </ul>
                                            </li>
                                            <li>
                                                <ul class="list-inline">
                                                    <li class="first_con">Address</li>
                                                    <li>: {{$user->address}}</li>
                                                </ul>
                                            </li>
                                        </ul>
                                        <div class="iframe">
                                            </iframe>
                                            <iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0"
                                                    marginwidth="0"
                                                    src="https://maps.google.com/maps?q={{$user->latitude}},{{$user->longitude}}&hl=es;z=17.5&amp;output=embed"></iframe>
                                        </div>
                                        <br>
                                    </div>
                                </div>


                            </div><!--/.container-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@include('layouts.foot')