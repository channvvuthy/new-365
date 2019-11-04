<div class="container">
    <form class="form-inline" method="get" action="{{URL::to('filter')}}">
        <div class="form-group">
            <div class="btn-group">
                <select class="form-control no-border" name="category">
                    <option value="">Choose Category</option>
                    @if(!empty($categories))
                        @foreach($categories as $category)
                            <option value="{{$category->name}}">{{$category->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="btn-group">
                <select class="form-control no-border" name="location">
                    <option value="">Choose Location</option>
                    @if(!empty($locations))
                        @foreach($locations as $location)
                            <option value="{{$location->name}}">{{$location->name}}</option>
                        @endforeach
                    @endif
                </select>
                <input type="hidden" name="home" value="Search from home">
            </div>
        </div>
        <div class="form-group flex">
            <input class="form-control" type="text" value="" id="filter_id" placeholder="What you are looking for..." name="name">
            <button type="submit" class="btn btn-default last"><i class="glyphicon glyphicon-search"></i> Search
            </button>
        </div>
    </form>
</div>