<!-- Modal -->
<div class="modal fade" id="myModalRegister" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Register</h4>
            </div>
            <div class="modal-body">
                <form action="{{URL::to('/')}}/register" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" placeholder="Email" class="form-control" name="email" required>
                        @if($errors->has('email'))
                            <span class="error">{{$errors->first('email')}}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" placeholder="Password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group text-center">
                        <p>Have already account?<a href="#" class="color loginInstead"> Login</a></p>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>