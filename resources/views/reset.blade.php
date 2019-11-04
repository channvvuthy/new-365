<!-- Modal -->
<div class="modal fade" id="myReset" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Login</h4>
            </div>
            <div class="modal-body">
                <form action="{{URL::to('/')}}/reset" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="verification_code" value="{{$errors->first('verification_code')}}">
                    <div class="form-group">
                        <label for="">New password</label>
                        <input type="password" placeholder="New password" class="form-control" name="password" required>
                        <span class="error">{{$errors->first('err')}}</span>
                    </div>
                    <div class="form-group">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>