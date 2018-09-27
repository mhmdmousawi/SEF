<!-- Modal -->
<div class="modal fade" id="saving_varification_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Verification Response:</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="{{config('app.url')}}/dashboard/change/filter" method="POST">
                @csrf

                <div class="modal-body">
                    <p>Result: </p>
                    <p id="validation_result"></p>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default">Ok</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
