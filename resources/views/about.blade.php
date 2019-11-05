@extends('layouts.master')
@section('title') 365daymarket @stop
@include('layouts.head')
@section('content')
    <div id="app">
        @include('layouts.header')
        <br>
        <div class="container">
            <div class="bw" style="    border: 1px solid #ddd;
    border-radius: 4px;">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        @if($errors->has('success'))
                            <br>
                            <div class="alert alert-success">{{$errors->first('success')}}</div>
                        @endif
                        <br>
                        <form action="about" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="">Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Your name"
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="">
                                    Email address
                                </label>
                                <input type="email" name="" id="email" class="form-control" placeholder="Your email"
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="">Message</label>
                                <textarea name="message" id="message" rows="5" class="form-control"
                                          placeholder="Your message" required></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> Send</button>
                            </div>
                        </form>
                    </div>
                </div>
                <br><br><br><br><br><br><br><br><br><br><br><br><br>
            </div>
        </div>

    </div>
@stop
@include('layouts.foot')