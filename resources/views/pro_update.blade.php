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
                                    <li>
                                        <a href="{{URL::to('profile')}}"><i class="glyphicon glyphicon-folder-open"></i>
                                            &nbsp;My Ads</a>
                                    </li>
                                    <li class="active">
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
                        <br>
                        <br>
                        <div class="col-md-6">
                            @if($errors->has('message'))
                                <br>
                                <div class="alert alert-success"><p><b>{{$errors->first('message')}}</b></p></div>
                            @endif
                            <form action="update-profile" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="">Username</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           placeholder="Your name" value="{{Auth::user()->name}}">
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Email"
                                           value="{{Auth::user()->email}}">
                                </div>
                                <div class="form-group">
                                    <label for="">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                           placeholder="Phone number" value="{{Auth::user()->phone}}">
                                </div>
                                <div class="form-group">
                                    <label for="">City/Province</label>
                                    <select name="location" id="location" class="form-control">
                                        <option value="">Choose City/Province</option>
                                        @if(!empty($locations))
                                            @foreach($locations as $location)
                                                <option value="{{$location->name}}">{{$location->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Address</label>
                                    <textarea name="address" id="address" cols="30" rows="6"
                                              class="form-control">{{Auth::user()->address}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Google Map</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" placeholder="Longitude"
                                                   name="longitude" value="{{Auth::user()->longitude}}">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" placeholder="Latitude"
                                                   name="latitude" value="{{Auth::user()->latitude}}">
                                        </div>
                                    </div>
                                </div>
                                <input type="file" name="image" id="image" class="hidden">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i> Update
                                        info
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <div class="up-pro">
                                @if(!empty(Auth::user()->image))
                                    <img src="{{asset('images/')}}/{{Auth::user()->image}}" alt=""
                                         class="img-responsive">
                                @else
                                    <img src="{{asset('images/profile-defult.png')}}" alt="" class="img-responsive">
                                @endif

                            </div>
                        </div>
                        .
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>
@stop
@include('layouts.foot')