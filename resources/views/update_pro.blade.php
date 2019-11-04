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
                                    <li>
                                        <a href="{{URL::to('update-profile')}}"><i class="fa fa-pencil"></i> Update
                                            profile
                                            info</a>
                                    </li>
                                    <li class="active">
                                        <a href="{{URL::to('update/product/')}}/{{$product->id}}"><i
                                                    class="fa fa-edit"></i> Update
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
                                <div class="alert alert-success"><p><b>{{$errors->first('message')}}</b></p></div>
                            @endif
                            <form action="{{URL::to('update-ads')}}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{$product->id}}">
                                <div class="form-group">
                                    <label for="">Category <span class="error"
                                                                 title="The field is required">*</span></label>
                                    <select name="category_name" id="category" class="form-control" required>
                                        <option value="">Select category</option>
                                        @if(!empty($categories))
                                            @foreach($categories as $category)
                                                <option value="{{$category->name}}"
                                                        data-id="{{$category->id}}"
                                                        @if($category->name==$product->category_name)  selected @endif>{{$category->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Sub Category <span class="error"
                                                                     title="The field is required">*</span></label>
                                    <select name="sub_category_name" id="sub" class="form-control" required>
                                        <option value="{{$product->sub_category_name}}">{{$product->sub_category_name}}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Product Name <span class="error"
                                                                     title="The field is required">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           placeholder="Product name" required value="{{$product->name}}">
                                </div>
                                <div class="form-group">
                                    <label for="">Price <span class="error"
                                                              title="The field is required">*</span></label>
                                    <input type="text" name="price" id="price" class="form-control"
                                           placeholder="Price" required value="{{$product->price}}">
                                </div>
                                <div class="form-group">
                                    <label for="">Description <span class="error" title="The field is required">*</span></label>
                                    <textarea name="description" id="description" cols="30" rows="4"
                                              class="form-control"
                                              placeholder="Description" required>{{$product->description}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="username" id="username" class="form-control"
                                           placeholder="Contact name" value="{{$product->username}}">
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Email"
                                           value="{{$product->email}}">
                                </div>
                                <div class="form-group">
                                    <label for="">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                           placeholder="Phone number" value="{{$product->phone}}">
                                </div>
                                <div class="form-group">
                                    <label for="">City/Province</label>
                                    <select name="location_name" id="province" class="form-control">
                                        <option value="">Select City/Province</option>
                                        @if(!empty($locations))
                                            @foreach($locations as $location)
                                                <option value="{{$location->name}}"
                                                        @if($product->location_name==$location->name) selected @endif>{{$location->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Location detail</label>
                                    <input type="text" name="address" id="location" class="form-control"
                                           placeholder="Location detail" value="{{$product->address}}">
                                </div>
                                <input type="file" multiple id="gallery-photo-add" class="hidden" name="images[]">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> Update
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="up-pro">
                                        <img src="{{asset('images/')}}/upload_photo.png" alt=""
                                             class="img-responsive img-post">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="gallery">
                                @if(!empty($product->images))
                                    <ul class="list-inline">
                                        @foreach(json_decode($product->images) as $key=> $image)
                                            <li class="thumbnail"
                                                style="width: 120px;height: 120px;background-image:url('{{$image}}');background-size: cover;position: relative">
                                                <strong class="x" data-id="{{$product->id}}" data-url="{{$image}}"
                                                        data-key="{{$key}}">X</strong>
                                            </li>
                                        @endforeach
                                    </ul>
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
