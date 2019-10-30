@if($errors->has('confirm'))
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