<!-- Modal -->
<div class="modal fade" id="myForgot" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Forgot Password</h4>
            </div>
            <div class="modal-body">
                <form action="{{URL::to('/')}}/forgot" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    @if($errors->has('errForgot'))
                        <div class="alert alert-danger">
                            <p>{{$errors->first('errForgot')}}</p>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" placeholder="Enter your email address" class="form-control" name="email"
                               required>
                        <span class="error">{{$errors->first('err')}}</span>
                    </div>
                    <div class="form-group">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>