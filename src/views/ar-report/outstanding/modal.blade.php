<div class="modal fade" id="modal_outstanding" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitleModaladjustment">Outstanding Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form 
                  class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" 
                  id="AdjustmentForm" 
                  action="{{route('fa-report.outstanding-invoice')}}">

                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Date
                                </label>
                            
                                @component('input::datepicker')
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
                            {{-- <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Department
                                </label>
                            
                                @component('input::select2')
                                    @slot('id', 'department_id')
                                    @slot('name', 'department_id')
                                    @slot('class', 'department')
                                    @slot('id_error', 'department_id')
                                @endcomponent
                            </div> --}}
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Location
                                </label>
                            
                                <select class="_select2 form-control" name="location" style="width:100%">
                                    <option value=""></option>
                                    <option value="Sidoarjo">Sidoarjo</option>
                                    <option value="Surabaya">Surabaya</option>
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Biak">Biak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Currency
                                </label>
                            
                                @component('input::select')
                                    @slot('id', 'currency_id')
                                    @slot('name', 'currency')
                                    @slot('class', 'currency')
                                    @slot('id_error', 'currency_id')
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
                                            @slot('id', 'view_outstanding_invoice')
                                            @slot('type', 'submit')
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
<script>
    let modal = $('#modal_outstanding');

    modal.find('[name=date]').daterangepicker({
      buttonClasses: "m-btn btn",
      applyClass: "btn-primary",
      cancelClass: "btn-secondary",
      singleDatePicker: true,
      showDropdown: true,
      locale: {
        format: 'DD-MM-YYYY'
      }    
    });
</script>
<script src="{{ asset('vendor/courier/frontend/functions/daterange/outstanding.js')}}"></script>

{{-- <script src="{{ asset('vendor/courier/frontend/functions/select2/department.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/department.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/currency.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/currency.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/location.js')}}"></script> --}}
@endpush

