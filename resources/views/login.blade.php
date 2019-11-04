<!-- Modal -->
<div class="modal fade" id="myModalLogin" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Login</h4>
            </div>
            <div class="modal-body">
                <form action="{{URL::to('/')}}/login" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" placeholder="Email" class="form-control" name="email" required>
                        <span class="error">{{$errors->first('err')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" placeholder="Password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <a href="" class="color forgotInsead">Forgot your password?</a>
                    </div>
                    <hr>
                    <div class="form-group text-center">
                        <p>Don't have account?<a href="#" class="color registerInstead"> Register</a></p>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>