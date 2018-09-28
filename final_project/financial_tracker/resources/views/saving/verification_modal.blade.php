<!-- Modal -->
<div class="modal fade" id="saving_varification_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Saving Plan Verification </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="{{config('app.url')}}/add/saving/validate" method="POST">
                @csrf

                <div class="modal-body">
                    <div id="validation_attr_div"></div>
                    <p id="validation_result"></p>
                    <p id="validation_question"></p>
                    
                </div>
                <div id="modal_footer" class="modal-footer">
                    {{-- <button id='confirm_btn' type="button" class="btn btn-default">Confirm</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> --}}
                </div>
            </form>
        </div>
    </div>
</div>
