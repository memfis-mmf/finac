<div class="modal fade" id="modal_coa_edit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitleModalJournal">Cashbook Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="CoaForm">
                    <input type="hidden" class="form-control form-control-danger m-input" name="uuid" id="uuid">
										<input type="hidden" name="transactionnumber" value="{{$cashbook->transactionnumber}}">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                {{csrf_field()}}
                                <label class="form-control-label">
                                    Account Code
                                </label>

																<input
																	type="text"
																	class="form-control"
																	name="account_code_a"
																	value=""
																	readonly
																>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Account Name
                                </label>

																<input
																	type="text"
																	class="form-control"
																	name="account_name_a"
																	value=""
																	readonly
																>
                            </div>
                        </div>
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="form-control-label">
                                    Project
                                </label>

                                @component('input::select')
                                    @slot('id', 'id_project')
                                    @slot('text', 'id_project')
                                    @slot('name', 'id_project')
                                    @slot('class', 'project')
                                @endcomponent
                            </div>
                        </div>

                        <div class="form-group m-form__group row ">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="form-control-label">
                                    Quotation Workshop
                                </label>

                                @component('input::select')
                                    @slot('id', 'quotation_workshop_id')
                                    @slot('text', 'quotation_workshop_id')
                                    @slot('name', 'quotation_workshop_id')
                                    @slot('class', 'quotation_workshop')
                                @endcomponent
                            </div>
                        </div>
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="form-control-label">
                                    Amount
                                </label>

                                @component('input::number')
                                    @slot('id', 'amount')
                                    @slot('text', 'Amount')
                                    @slot('name', 'amount_a')
                                @endcomponent
                            </div>
                        </div>
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="form-control-label">
                                    Description
                                </label>

                                @component('input::textarea')
                                    @slot('id', 'description')
                                    @slot('text', 'Description')
                                    @slot('name', 'description_a')
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
                                            @slot('type', 'button')
                                            @slot('id', 'update_cashbook_a')
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
