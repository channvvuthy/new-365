<!-- Modal -->
<div class="modal fade" id="myModalConfirm" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirm email message</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="alert alert-{{$errors->first('btn')}}">
                        {!! $errors->first('msg') !!}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
