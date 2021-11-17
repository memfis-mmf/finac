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
                <form action="{{ route('fa-report.ar.aging') }}" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row pb-0 pt-0">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Date
                                </label>
                                <span class="text-danger">*</span>

                                @component('input::text')
                                    @slot('id', 'date')
                                    @slot('name', 'date')
                                    @slot('id_error', 'date')
                                @endcomponent
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 pl-5">
                                <h5 class="text-primary">Additional Filter</h5>
                            </div>
                        </div>
                        <div class="form-group m-form__group row pt-1 pb-0">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="form-control-label">
                                    Customer
                                </label>

                                @component('input::select')
                                    @slot('id', 'customer')
                                    @slot('name', 'customer[]')
                                    @slot('multiple','multiple')
                                    @slot('id_error', 'customer')
                                @endcomponent
                            </div>
                        </div>
                        <div class="form-group m-form__group row pt-1 pb-1">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Department
                                </label>

                                <select class="form-control" name="department[]" style="width:100%" multiple>
                                  <option value=""></option>
                                  @foreach ($data_department as $department_row)
                                    <option value="{{ $department_row->uuid }}">{{ $department_row->name }}</option>
                                  @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Location
                                </label>

                                <select class="form-control" name="location" style="width:100%">
                                  <option value=""></option>
                                  <option value="sidoarjo">Sidoarjo</option>
                                  <option value="surabaya">Surabaya</option>
                                  <option value="jakarta">Jakarta</option>
                                  <option value="biak">Biak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group m-form__group row row pt-2 pb-1">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Currency
                                </label>
                                <span class="text-danger">*</span>

                                <select class="_select2 form-control" name="currency" style="width:100%">
                                    <option value=""></option>
                                    @foreach ($data_currency as $data_currency_row)
                                      <option value="{{ $data_currency_row->id }}">{{ "($data_currency_row->symbol) $data_currency_row->name" }}</option>
                                    @endforeach
                                </select>
                                {{-- @component('input::select')
                                    @slot('id', 'currency')
                                    @slot('name', 'currency')
                                    @slot('id_error', 'currency')
                                @endcomponent --}}
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
                                            @slot('type', 'submit')
                                            @slot('color','primary')
                                            @slot('text','View')
                                            @slot('iconlibrary','la')
                                            @slot('icon','la-external-link-square')
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

    modal.find("[name^=department]").select2({
      placeholder: '-- Select --'
    });

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

    modal.find('[name^=customer]').select2({
      width: '100%',
      placeholder: '-- Select --',
      ajax: {
        url: '{{ route("fa-report.ar.aging.select2.customer") }}',
        dataType: 'json'
      }
    });

    modal.find('[name=location]').select2({
      width: '100%',
      placeholder: '-- Select --',
    });

  });

</script>

@endpush
