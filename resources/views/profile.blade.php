@extends('layouts.master')
@section('title') 365daymarket @stop
@include('layouts.head')
@section('content')
    <div id="app">
        @include('layouts.header')
        <div class="container">
            <br>
            <div class="row">
                <div class="col-md-4">
                    <div class="img-profile">
                        @if(!empty(Auth::user()->image))
                            <img src="{{asset('images/')}}/{{Auth::user()->image}}" alt="">
                        @else
                            <img src="{{asset('images/profile-defult.png')}}" alt="">
                        @endif
                        <div class="pro-info">
                            <ul class="list-unstyled">
                                <li><a href="{{URL::to('/')}}/update-profile" class="color"><b><i
                                                    class="fa fa-pencil"></i> Change Info</b></a></li>
                                <li><b>Username:</b> {{Auth::user()->name}}</li>
                                <li><b>Store Url:</b> <a
                                            href="{{URL::to('store')}}/{{Auth::user()->id}}"
                                            class="color">{{URL::to('store')}}/{{Auth::user()->id}}</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="list-unstyled">
                        <li><b>Phone Number: {{Auth::user()->phone}}</b></li>
                        <li><b>Email: {{Auth::user()->email}}</b></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <div class="upgrad text-right">
                        <button class="btn btn-primary "><i class="fa fa-pencil"></i> Upgrad to business account
                        </button>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="ads-list">
                        <div class="col-md-12">
                            <div class="ads">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="{{URL::to('profile')}}"><i class="glyphicon glyphicon-folder-open"></i>
                                            &nbsp;My Ads</a>
                                    </li>
                                    <li>
                                        <a href="{{URL::to('update-profile')}}"><i class="fa fa-pencil"></i> Update
                                            profile info</a>
                                    </li>
                                    <li>
                                        <a href="{{URL::to('post')}}"><i class="glyphicon glyphicon-send"></i> Post
                                            product</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <br>
                        <div class="clearfix"></div>
                        <div class="col-md-12">
                            @if($errors->has('dlMsg'))
                                <br>
                                <div class="alert alert-success">
                                    <p>{{$errors->first('dlMsg')}}</p>
                                </div>
                            @endif
                            <myads/>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>
@stop
@include('layouts.foot')