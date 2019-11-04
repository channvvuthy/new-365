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
                                            <ul class="list-inline" style="position: relative;bottom: -40px;">
                                                <li><a href="" class="btn btn-default btn-md"><i
                                                                class="fa fa-share"></i>
                                                        Share</a></li>
                                                <li><a href="" class="btn btn-primary btn-md"><i
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
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="{{URL::to('store')}}/{{$user->id}}" class="color">
                                                &nbsp;All Posts</a>
                                        </li>
                                        <li>
                                            <a href="#" class="color">Contact</a>
                                        </li>
                                        <li>
                                            <a href="#" class="color">Member Status</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="btn-group">
                                                <a href="#" id="list" class="btn btn-default btn-sm"><span
                                                            class="glyphicon glyphicon-th-list"></span></a>
                                                <a href="#" id="grid" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th"></span></a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <div class="pull-right">
                                                <form action="" class="form-inline">
                                                    <div class="form-group">
                                                        <label class="" for="pwd">&nbsp; Sort:</label>
                                                        <select name="postby" class="form-control"><option value="last">New ads</option> <option value="popular">Most View</option></select>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <br>
                                <div id="products" class="list-group">
                                    @if(!empty($products))
                                        @foreach($products as $product)
                                            <div class="item col-lg-4">
                                                @if(!empty($product->images))
                                                    <?php
                                                    $image = json_decode($product->images,true);?>
                                                        <a href="{{URL::to('/')}}/detail/{{$product->id}}"><img class="group list-group-image img-responsive" src="{{$image[0]}}"></a>
                                                @endif
                                                <div class="pro-des">
                                                    <h4 class="group inner list-group-item-heading"><a href="{{URL::to('/')}}/detail/{{$product->id}}">{{$product->name}}</a></h4>
                                                </div>

                                                <div class="pro-des">
                                                    <p class="group inner list-group-item-text det">{{$product->sub_category_name}} / Post On
                                                        : {{date('F d, Y', strtotime($product->created_at))}}</p>
                                                </div>
                                                <div class="pro-price"><p><b>${{$product->price}}</b></p></div>

                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="page">
                                    {{$products->render()}}
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