<div class="modal fade" id="modal_cash_statement" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitleModaladjustment">Cash Statement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form 
                  class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" 
                  id="AdjustmentForm" 
                  action="{{url('/fa-report/cash-statement')}}">

                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Date
                                </label>
                            
                                @component('input::text')
                                    @slot('id', 'daterange')
                                    @slot('name', 'daterange')
                                    @slot('id_error', 'daterange')
                                @endcomponent
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Cash Account
                                </label>
                            
                                <select class="_select2 form-control" name="coa" style="width:100%">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Currency
                                </label>
                            
                                @component('input::select')
                                    @slot('id', 'currency_id')
                                    @slot('name', 'currency')
                                    @slot('class', 'currency')
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
                                            @slot('id', 'view_cash_statement')
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

<script src="{{ asset('vendor/courier/frontend/functions/select2/currency.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/currency.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/daterange/cash-statement.js')}}"></script>
<script>
    $(document).ready(function () {
      let _url = window.location.origin;
      modal = $('#modal_cash_statement');

      modal.find("[name=daterange]").daterangepicker({
        buttonClasses: "m-btn btn",
        applyClass: "btn-primary",
        cancelClass: "btn-secondary",
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
@endpush

