<div class="modal fade" id="modal_aging_rd" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitleModaladjustment">Aging Receivables Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="AdjustmentForm">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Date
                                </label>
                            
                                @component('input::text')
                                    @slot('id', 'date')
                                    @slot('name', 'date')
                                    @slot('id_error', 'date')
                                @endcomponent
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 pl-5">
                                <h2 class="text-primary">Additional Filter</h2>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="form-control-label">
                                    Customer
                                </label>
                            
                                @component('input::select2')
                                    @slot('id', 'customer')
                                    @slot('name', 'customer')
                                    @slot('multiple','multiple')
                                    @slot('id_error', 'customer')
                                @endcomponent
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Department
                                </label>
                            
                                @component('input::select2')
                                    @slot('id', 'department')
                                    @slot('name', 'department')
                                    @slot('multiple','multiple')
                                    @slot('id_error', 'department')
                                @endcomponent
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Location
                                </label>
                            
                                @component('input::select2')
                                    @slot('id', 'location')
                                    @slot('multiple','multiple')
                                    @slot('name', 'location')
                                    @slot('id_error', 'location')
                                @endcomponent
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Currency
                                </label>
                            
                                @component('input::select')
                                    @slot('id', 'currency')
                                    @slot('name', 'currency')
                                    @slot('id_error', 'currency')
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
                                            @slot('color','primary')
                                            @slot('text','View')
                                            @slot('icon','fa-search')
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
    

@push('footer-scripts')
<script src="{{ asset('vendor/courier/frontend/functions/daterange/aging-receivables.js')}}"></script>

<script>
    $(document).ready(function () {
      let _url = window.location.origin;
      modal = $('#modal_aging_rd');

      modal.find("[name=date]").daterangepicker({
        buttonClasses: "m-btn btn",
        applyClass: "btn-primary",
        cancelClass: "btn-secondary",
        singleDatePicker: true,
        locale: {
          format: 'DD-MM-YYYY'
        }
      });

      modal.find('[name=coa]').select2({
        placeholder: '-- Select --',
        ajax: {
          url: _url+'/journal/get-account-code-select2',
          dataType: 'json'
        }    
      });
    });

</script>

{{-- <script src="{{ asset('vendor/courier/frontend/functions/select2/customer.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/customer.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/department.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/department.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/currency.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/currency.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/location.js')}}"></script> --}}
@endpush