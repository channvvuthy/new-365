@if($errors->has('msg'))
    <script>
        $(document).ready(function () {
            $("#myModalConfirm").modal('show');
        })
    </script>
@endif

@if($errors->has('email'))
    <script>
        $(document).ready(function () {
            $("#myModalRegister").modal('show');
        })
    </script>
@endif
@if($errors->has('err'))
    <script>
        $(document).ready(function () {
            $("#myModalLogin").modal('show');
        })
    </script>
@endif
@if($errors->has('login'))
    <script>
        $(document).ready(function () {
            $("#myModalLogin").modal('show');
        })
    </script>
@endif
@if($errors->has('errForgot'))
    <script>
        $(document).ready(function () {
            $("#myForgot").modal('show');
        })
    </script>
@endif
@if($errors->has('verification_code'))
    <script>
        $(document).ready(function () {
            $("#myReset").modal('show');
        })
    </script>
@endif