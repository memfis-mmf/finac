<div class="modal fade" id="modal_ap" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitleModaladjustment">Account Payable History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="AdjustmentForm" action="{{route('fa-report.ap-history')}}">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row pb-0 pt-0">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Date Period
                                </label>

                                @component('input::datepicker')
                                    @slot('id', 'daterange')
                                    @slot('class', 'daterange')
                                    @slot('name', 'daterange')
                                    @slot('id_error', 'daterange_account_Payable_history')
                                @endcomponent
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 pl-5">
                                <h5 class="text-primary">Additional Filter</h5>
                            </div>
                        </div>
                        <div class="form-group m-form__group row pb-1 pt-0">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Department
                                </label>

                                @component('input::select2')
                                    @slot('class', 'department')
                                    @slot('name', 'department')
                                    @slot('id_error', 'department')
                                @endcomponent
                            </div>
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
                        <div class="form-group m-form__group row pb-1 pt-1">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Supplier
                                </label>

                                @component('input::select')
                                    @slot('id', '_vendor')
                                    @slot('name', 'vendor')
                                    @slot('id_error', 'vendor')
                                @endcomponent
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Currency
                                </label>

                                <select class="_select2 form-control" name="currency" style="width:100%">
                                    <option value=""></option>
                                    @foreach ($data_currency as $data_currency_row)
                                      <option value="{{ $data_currency_row->id }}">{{ "($data_currency_row->symbol) $data_currency_row->name" }}</option>
                                    @endforeach
                                </select>

                                {{-- <select name="currency" class="form-control" id="currency">
                                  <option value="">-- Select --</option>
                                  @foreach ($data_currency as $currency_row)
                                    <option value="{{ $currency_row->id }}">{{ "{$currency_row->name} ({$currency_row->symbol})" }}</option>
                                  @endforeach
                                </select> --}}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="flex">
                            <div class="action-buttons">
                                <div class="flex">
                                    <div class="action-buttons">
                                        @component('buttons::submit')
                                            @slot('id', 'view')
                                            @slot('type', 'submit')
                                            @slot('color','primary')
                                            @slot('text','view')
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
    <script src="{{ asset('vendor/courier/frontend/functions/daterange/account-Payable-history.js')}}"></script>

    {{-- <script src="{{ asset('vendor/courier/frontend/functions/select2/department.js')}}"></script>
    <script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/department.js')}}"></script>

    <script src="{{ asset('vendor/courier/frontend/functions/select2/currency.js')}}"></script>
    <script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/currency.js')}}"></script>

    <script src="{{ asset('vendor/courier/frontend/functions/select2/location.js')}}"></script> --}}

    <script>
      $(document).ready(function () {
        $('._select2').select2({
            placeholder : '-- Select --'
        });

        $('#_vendor').select2({
          ajax: {
            url: `{{route('frontend.supplier.select2')}}`,
            dataType: 'json'
          },
          width: '100%'
        });

        $(".daterange").daterangepicker({
            buttonClasses: "m-btn btn",
            applyClass: "btn-primary",
            cancelClass: "btn-secondary",
            locale: {
              format: 'DD/MM/YYYY'
            }
        });
      });
    </script>
@endpush

