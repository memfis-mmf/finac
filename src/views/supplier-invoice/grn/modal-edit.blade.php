<div class="modal fade" id="modal_edit_grn" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitleModalJournal">Goods Received Notes (GRN)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="GrnForm">
                    <input type="hidden" class="form-control form-control-danger m-input" name="uuid" id="uuid" disabled>
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    GRN No.
                                </label>

								<input type="text" id="grn_no" class="form-control m-input" disabled>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Total Amount
                                </label>

								<input type="text" id="total_amount" class="form-control m-input" disabled>
                            </div>
                        </div>
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="form-control-label">
                                    Invoice No.
                                </label>

                                @component('input::textarea')
                                    @slot('id', 'invoice_no')
                                    @slot('text', 'invoice_no')
                                    @slot('name', 'description')
                                    @slot('rows','5')
                                @endcomponent
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="flex">
                            <div class="action-buttons">
                                <div class="flex">
                                    <div class="action-buttons">
                                        @component('buttons::submit')
                                            @slot('id', 'update_grn')
                                            @slot('type', 'button')
                                        @endcomponent

                                        @include('buttons::reset')

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
