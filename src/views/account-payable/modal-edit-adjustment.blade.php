<div class="modal fade" id="modal_edit_adjustment" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitleModaladjustment">Supplier Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="AdjustmentForm">
									<input type="hidden" name="_uuid" value="" disabled>
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Debt Total Amount
                                </label>

                                @component('label::data-info')
                                  @slot('text', 'Rp '.number_format($debt_total_amount, 0, ',', '.'))
                                @endcomponent
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Paid Amount
                                </label>

                                @component('label::data-info')
                                  @slot('text', 'Rp '.number_format($payment_total_amount, 0, ',', '.'))
                                @endcomponent
                            </div>
                        </div>
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Debit
                                </label>

                                @component('input::number')
                                    @slot('id', 'debet')
                                    @slot('text', 'debet')
                                    @slot('name', 'debit_b')
                                @endcomponent
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Credit
                                </label>

                                @component('input::number')
                                    @slot('id', 'credit')
                                    @slot('text', 'credit')
                                    @slot('name', 'credit_b')
                                @endcomponent
                            </div>
                        </div>
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="form-control-label">
                                    Project
                                </label>
                                @component('input::select')
                                    @slot('text', 'Project')
                                    @slot('name', 'id_project_detail')
                                    @slot('class', 'project_detail')
                                    @slot('id_error', 'project')
                                @endcomponent
                            </div>
                        </div>
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="form-control-label">
                                    Remark
                                </label>

                                @component('input::textarea')
                                    @slot('id', 'description')
                                    @slot('text', 'description')
                                    @slot('name', 'description_b')
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
                                            @slot('id', 'update_adjustment')
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
