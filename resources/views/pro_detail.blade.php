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
                    <div class="detail bw">
                        <div class="note">
                            <ul class="list-inline">
                                <li><a href="http://127.0.0.1:8000" class="color"><i class="fa fa-home"></i> Home</a>
                                </li>
                                <li> /</li>
                                <li class="color">{{$products->category_name}}</li>
                                <li> /</li>
                                <li>
                                    <a href="{{URL::to('category')}}/{{$products->sub_category_name}}"
                                       class="color">{{$products->sub_category_name}}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="pro-detail">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="pro-spec">
                                        <?php
                                        $images = json_decode($products->images);
                                        ?>
                                        <div class="img-spec">
                                            <img src="{{$images[0]}}" alt="main-image" class="bigImg">
                                            <br>
                                            <div class="clearfix"></div>
                                            <br>
                                        </div>
                                        <div class="pro-more">
                                            <ul class="list-inline">
                                                @if(count($images)>1)
                                                    @foreach($images as $key=>$image)
                                                        <li class="thumbnail pro-thumbnail pointer"
                                                            style="width:60px;height: 60px;background-image:url('{{$image}}');background-size:contain;"
                                                            data="{{$image}}"></li>&nbsp;
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{URL::to('/')}}/detail/{{$prducts->id}}"
                                           class="btn btn-default btn-xs pull-right"><i class="fa fa-share"></i> Share
                                            to Facebook</a>
                                        <h3 class="pro-name color">{{$products->name}}</h3>
                                        <div class="price-detail">
                                            <b>Price: ${{$products->price}}</b>
                                        </div>
                                        <div class="posted">
                                            <ul class="list-inline">
                                                <li>
                                                    <small>Posted
                                                        on {{date('F d, Y', strtotime($products->created_at))}}</small>
                                                </li>
                                                <li>
                                                    <small>Views: {{$products->views}}</small>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="desc">
                                            <h3 style="margin:0px;"><b>Descriptoin</b></h3>
                                            <hr style="margin:10px 0px;">
                                            <p>{!! $products->description !!}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="lef-info">
                                        <div class="contact-info">
                                            <div class="profile1"
                                                 style="background-image:url('{{asset('images/profile-defult.png')}}');background-size: contain;">
                                            </div>
                                            <div class="text-profile">
                                                <p><b>{{$user->name}}</b></p>
                                                <a href="{{URL::to('store')}}/{{$user->id}}" class="text-white">Show all
                                                    product</a>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <p><i class="fa fa-phone"></i> {{($user->phone)?$user->phone:'xxx xxx xxx'}}</p>
                                    <p><a href="{{URL::to('store')}}/{{$user->id}}" class="color"><i
                                                    class="fa fa-globe"></i> {{URL::to('store')}}/{{$user->id}}</a></p>
                                    <div class="location">
                                        <h3><b>Location</b></h3>
                                    </div>
                                    <div class="iframe">
                                        </iframe>
                                        <iframe width="100%" height="258" frameborder="0" scrolling="no" marginheight="0"
                                                marginwidth="0"
                                                src="https://maps.google.com/maps?q=11.585230,104.86620&hl=es;z=17.5&amp;output=embed"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-detail">
                        <div class="col-md-12">
                            <div class="profile1"
                                 style="background-image:url('{{asset('images/profile-defult.png')}}');background-size: contain;">
                            </div>
                            <div class="go">
                                <a href="{{URL::to('store')}}/{{$user->id}}"
                                   class="btn btn-warning btn-xs pull-right"><i class="fa fa-shopping-cart"></i> Go to
                                    shop</a>
                            </div>
                            <div class="text-profile">
                                <p><b>{{$user->name}}</b></p>
                                <a href="{{URL::to('store')}}/{{$user->id}}" class="color">{{URL::to('store')}}
                                    /{{$user->id}}</a>
                            </div>

                        </div>
                    </div>
                    <br>
                    <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
                    <div class="product-relate">
                        <productuser/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@include('layouts.foot')