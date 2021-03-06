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
                                        <li class="active">
                                            <a href="{{URL::to('store')}}/{{$user->id}}" class="color">
                                                &nbsp;All Posts</a>
                                        </li>
                                        <li>
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
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="btn-group">
                                                <a href="#" id="list" class="btn btn-default btn-sm"><span
                                                            class="glyphicon glyphicon-th-list"></span></a>
                                                <a href="#" id="grid" class="btn btn-default btn-sm"><span
                                                            class="glyphicon glyphicon-th"></span></a>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <div class="pull-right">
                                                <form action="?" class="form-inline" id="formSort">
                                                    <div class="form-group">

                                                        <label class="" for="pwd">&nbsp; Sort:</label>

                                                        <select name="sort" class="form-control" id="sort">
                                                            <option value="new_ads"
                                                                    @if(@$_GET['sort']=='new_ads') selected @endif>New
                                                                ads
                                                            </option>
                                                            <option value="most_view"
                                                                    @if(@$_GET['sort']=='most_view') selected @endif>
                                                                Most View
                                                            </option>
                                                        </select>
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
                                                    $image = json_decode($product->images, true);?>
                                                    <div class="img-store">
                                                        <a href="{{URL::to('/')}}/detail/{{$product->id}}"><img
                                                                    class="group list-group-image img-responsive"
                                                                    src="{{$image[0]}}"></a>
                                                    </div>
                                                @endif
                                                <div class="pro-des">
                                                    <h4 class="group inner list-group-item-heading"><a
                                                                href="{{URL::to('/')}}/detail/{{$product->id}}">{{$product->name}}</a>
                                                    </h4>
                                                </div>

                                                <div class="pro-des">
                                                    <p class="group inner list-group-item-text det">{{$product->sub_category_name}}
                                                        / Post On
                                                        : {{date('F d, Y', strtotime($product->created_at))}}</p>
                                                </div>
                                                <div class="pro-price"><p><b>${{$product->price}}</b></p></div>

                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="page">
                                    {{$products->links()}}
                                </div>

                            </div><!--/.container-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('meta')
    <meta property="og:url" content="{{URL::to('store')}}/{{$user->id}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{$user->name}}"/>
    <meta property="og:description" content="Member Since {{date("d F Y", strtotime($user->created_at))}}"/>
    <meta property="og:image"
          content="{{asset('images')}}/{{$user->image}}"/>

@stop
@include('layouts.foot')