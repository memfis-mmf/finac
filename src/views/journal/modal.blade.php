<div class="modal fade" id="modal_coa_edit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitleModalJournal">Chart Of Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="CoaForm">
                    <input type="hidden" class="form-control form-control-danger m-input" name="uuid" id="uuid">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Account Code 
                                </label>

																<input type="text" id="account_code" class="form-control m-input" disabled>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Account Description @include('label::required')
                                </label>

																<input type="text" id="account_description" class="form-control m-input" disabled>
                            </div>
                        </div>
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        @component('input::radio')
                                            @slot('id', 'debet')
                                            @slot('name', 'methodpayment')
                                            @slot('text', 'Debet')
                                            @slot('value', 'debet')
                                            @slot('required','required')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        @component('input::radio')
                                            @slot('id', 'kredit')
                                            @slot('name', 'methodpayment')
                                            @slot('text', 'Kredit')
                                            @slot('value', 'kredit')
                                            @slot('required','required')
                                        @endcomponent
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Input Amount @include('label::required')
                                </label>

                                @component('input::number')
                                    @slot('id', 'amount')
                                    @slot('text', 'amount')
                                    @slot('name', 'amount')
                                @endcomponent
                            </div>
                        </div>
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="form-control-label">
                                    Remark
                                </label>

                                @component('input::textarea')
                                    @slot('id', 'remark')
                                    @slot('text', 'remark')
                                    @slot('name', 'remark')
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
                                            @slot('id', 'update_journala')
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
