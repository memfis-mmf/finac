<div class="modal fade" id="modal_bank_statement" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitleModaladjustment">Bank Statement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form
                  class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed"
                  id="AdjustmentForm"
                  action="{{url('/fa-report/bank-statement')}}">

                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row pt-0 pb-0">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Date
                                </label>
                                <span class="text-danger">*</span>

                                @component('input::datepicker')
                                    @slot('id', 'daterange')
                                    @slot('name', 'daterange')
                                    @slot('id_error', 'daterange')
                                @endcomponent
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Bank Account
                                </label>
                                <span class="text-danger">*</span>

                                <select class="_select2 form-control" name="bank_account" style="width:100%">
                                    <option value=""></option>
                                </select>
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
<script src="{{ asset('vendor/courier/frontend/functions/daterange/bank-statement.js')}}"></script>
<script>
    $(document).ready(function () {
      let _url = window.location.origin;
      modal = $('#modal_bank_statement');

      modal.find("[name=daterange]").daterangepicker({
        buttonClasses: "m-btn btn",
        applyClass: "btn-primary",
        cancelClass: "btn-secondary",
        locale: {
          format: 'DD-MM-YYYY'
        }
      });

      modal.find('[name=bank_account]').select2({
        placeholder: '-- Select --',
        ajax: {
          url: _url+'/fa-report/cash-statement/select2-bank-account',
          dataType: 'json'
        }
      });
    });

</script>
@endpush

