@include('filter')
<div class="clearfix"></div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="btn-group">
                        <div id="list" class="btn btn-default btn-sm"><span
                                    class="glyphicon glyphicon-th-list"></span></div>
                        <div id="grid" class="btn btn-default btn-sm active"><span
                                    class="glyphicon glyphicon-th"></span></div>
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <div class="pull-right">
                        <form action="?" class="form-inline" id="formSort">
                            <div class="form-group">
                                @if(count($_GET))
                                    @foreach($_GET as $key=> $input)
                                        @if($key!='sort')
                                            <input type="hidden" class="" name="{{$key}}" value="{{$_GET[$key]}}">
                                        @endif
                                    @endforeach
                                @endif
                                <label class="" for="pwd">&nbsp; Sort:</label>
                                <select name="sort" class="form-control" id="sort">
                                    <option value="new_ads" @if(@$_GET['sort']=="new_ads") selected @endif>New ads
                                    </option>
                                    <option value="most_view" @if(@$_GET['sort']=="most_view") selected @endif>Most
                                        View
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
                        <div class="grid">
                            @if(!empty($product->images))
                                <?php
                                $image = json_decode($product->images, true);?>
                                <a href="{{URL::to('detail')}}/{{$product->id}}"><img
                                            class="group list-group-image img-responsive" src="{{$image[0]}}"></a>
                            @endif


                            <div class="pro-des">
                                <p class="group inner list-group-item-text det">{{$product->sub_category_name}} / Post
                                    On
                                    : {{date('F d, Y', strtotime($product->created_at))}}</p>
                            </div>
                            <div class="pro-price"><p><b>${{$product->price}}</b></p></div>
                            <ul class="list-inline list-thum hidden">
                                @foreach($image as $img)
                                    <li class="thumbnail"
                                        style="width:70px;height: 70px;background-image:url('{{$img}}');background-size: contain;">
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="page">
            <div class="col-md-12">
                {{$products->render()}}
            </div>
        </div>

    </div><!--/.container-->
</div>
