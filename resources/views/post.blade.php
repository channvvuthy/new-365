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
                                @if(Auth::user()->hasStore)
                                    <li><b>Store Name:</b> {{Auth::user()->hasStore->name}}</li>
                                @else
                                    <li><b>Store Name:</b> Not setup yet</li>
                                @endif
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
                                    <li>
                                        <a href="{{URL::to('update-profile')}}"><i class="fa fa-pencil"></i> Update profile
                                            info</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{URL::to('post')}}"><i class="glyphicon glyphicon-send"></i> Post product</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <br>
                        <div class="clearfix"></div>
                        <br>
                        <br>
                        <div class="col-md-6">
                            <form action="update-profile" method="post" enctype="">
                                <div class="form-group">
                                    <label for="">Category</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Sub Category</label>
                                    <select name="sub" id="sub" class="form-control">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Product Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           placeholder="Phone number">
                                </div>
                                <div class="form-group">
                                    <label for="">Price</label>
                                    <input type="text" name="price" id="price" class="form-control"
                                           placeholder="Phone number">
                                </div>
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea name="description" id="description" cols="30" rows="4" class="form-control"
                                              placeholder="Description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="username" id="username" class="form-control"
                                           placeholder="Contact name">
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                           placeholder="Phone number">
                                </div>
                                <div class="form-group">
                                    <label for="">City/Province</label>
                                    <select name="province" id="province" class="form-control">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Location detail</label>
                                    <input type="text" name="location" id="location" class="form-control"
                                           placeholder="Location detail">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Create</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <div class="up-pro">
                                <img src="{{asset('images/')}}/upload_photo.png" alt="" class="img-responsive">
                                <input type="file" name="image" id="" class="hidden">
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