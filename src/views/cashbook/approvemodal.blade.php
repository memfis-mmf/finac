<div class="modal fade" id="modal_approvalcashbook" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitleModalJournal">
                    @include('label::confirmation')
                    Cashbook Confirmation
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="ApprovalCashbookForm">
                    <input type="hidden" class="form-control form-control-danger m-input" name="uuid" id="uuid-approve">
                    <div class="m-portlet__body">
                        <div class="swal2-icon swal2-warning swal2-animate-warning-icon" style="display: flex;"><span class="swal2-icon-text">!</span></div>
                        <center>
                            <h4>Are you sure
                                <br />
                                do you want to approve this transaction?
                            </h4>
                            <br/>
                        </center>
                    </div>
                    <div class="modal-footer">
                        <div class="flex">
                            <div class="action-buttons">
                                <div class="flex">
                                    <div class="action-buttons">
                                        @component('buttons::submit')
                                        @slot('id','approve')
                                        @slot('type', 'button')
                                        @slot('text','Confirm')
                                        @endcomponent


                                        @include('buttons::close')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>