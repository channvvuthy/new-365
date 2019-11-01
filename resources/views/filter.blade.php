<div class="col-md-12">
    <form class="form-inline filter" action="{{URL::to('filter')}}" method="GET">
        <div class="form-group">
            <location/>
        </div>
        <div class="form-group">
            <label class="" for="email">&nbsp; Category : </label>
            <category type="filter"/>
        </div>
        <div class="form-group">
            <label class="" for="pwd">&nbsp; Price:</label>
            <input type="number" class="form-control from" id="from" placeholder="" name="from" value="<?php echo $_GET['from'];?>">&nbsp;&nbsp;&nbsp;
        </div>
        <div class="form-group">
            <label class="sr-only" for="pwd">To:</label>
            <input type="number" class="form-control to" id="to" placeholder="" name="to" value="<?php echo $_GET['to'];?>">&nbsp;&nbsp;&nbsp;
        </div>
        <button type="submit" class="btn btn-default search"><i class="fa fa-search"></i> &nbsp; Search</button>
    </form>
</div>