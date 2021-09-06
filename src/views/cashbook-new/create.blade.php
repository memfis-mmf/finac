@extends('frontend.master')

@section('faCashbook', 'm-menu__item--active')
@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Cashbook
            </h3>
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">
                    -
                </li>
                <li class="m-nav__item">
                    <a href="#" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Cashbook
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
@include('cashbookview::coamodal')
<div class="m-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>

                            @include('label::create-new')

                            <h3 class="m-portlet__head-text">
                                Cashbook
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <form id="SupplierInvoiceGRNForm">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Cashbook Reference
                                        </label>

                                        <select class="form-control m-input _select2" name="cashbook_ref" id="cashbook_ref">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Cashbook Type @include('label::required')
                                        </label>

                                        <select class="form-control m-input _select2" name="cashbook_type" id="cashbook_types">
                                            <option value=""></option>
                                            <option value="bp">Bank Payment</option>
                                            <option value="br">Bank Receive</option>
                                            <option value="cp">Cash Payment</option>
                                            <option value="cr">Cash Receive</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6 mt-2">
                                        <label class="form-control-label">
                                            Date Transaction @include('label::required')
                                        </label>

                                        @component('input::datepicker')
                                            @slot('id', 'date')
                                            @slot('text', 'Date')
                                            @slot('name', 'transactiondate')
                                            @slot('id_error', 'date')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6 mt-2">
                                        <label class="form-control-label">
                                            Department
                                        </label>

                                        @component('input::select')
                                            @slot('id', '_department')
                                            @slot('name', 'company_department')
                                            @slot('text', 'Department')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6 mt-2">
                                        <label class="form-control-label">
                                            Location
                                        </label>

                                        <select class="_select2 form-control" name="location" style="width:100%">
                                            <option value=""></option>
                                            <option value="sidoarjo">Sidoarjo</option>
                                            <option value="surabaya">Surabaya</option>
                                            <option value="jakarta">Jakarta</option>
                                            <option value="biak">Biak</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6 mt-2">
                                        <label class="form-control-label">
                                            <span class="payment_receive">Payment To</span> @include('label::required')
                                        </label>

                                        @component('input::text')
                                            @slot('id', 'payment_to')
                                            @slot('text', 'Payment To')
                                            @slot('name', 'personal')
                                            @slot('id_error', 'payment_to')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6 mt-2">
                                        <label class="form-control-label">
                                            Ref No @include('label::required')
                                        </label>

                                        @component('input::text')
                                            @slot('id', 'ref_no')
                                            @slot('text', 'Ref No')
                                            @slot('name', 'refno')
                                            @slot('id_error', 'ref_no')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6 mt-2">
                                        <label class="form-control-label">
                                            Exchange Rate @include('label::required')
                                        <span id="requi" class="requi" style="font-weight: bold;color:red">*</span>
                                        </label>
                                        @component('input::numberreadonly')
                                            @slot('id', 'exchange')
                                            @slot('text', 'exchange')
                                            @slot('name', 'exchangerate')
                                        @endcomponent
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                          Multi Currency
                                        </label>
                                        @component('input::checkbox')
                                            @slot('id', 'multy_currency')
                                            @slot('name', 'multy_currency')
                                            @slot('value', '1')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">

                                      <div class="form-group common-currency">
                                        <label class="form-control-label">
                                            Currency @include('label::required')
                                        </label>

                                        <select class="currency w-100" id="currency" name="currency"></select>
                                      </div>

                                      <div class="form-group second-currency d-none">
                                        <label class="form-control-label">
                                            Currency to @include('label::required')
                                        </label>

                                        <select class="double-currency w-100" id="double-currency" name="second_currency"></select>
                                      </div>

                                    </div>
                                  </div>

                                  <div class="row">

                                    <div class="col-sm-6 col-md-6 col-lg-6 mt-2">
                                        <label class="form-control-label">
                                            Account Code @include('label::required')
                                        </label>

                                        @component('input::inputrightbutton')
                                            @slot('id', 'coa')
                                            @slot('text', 'coa')
                                            @slot('name', 'accountcode')
                                            @slot('type', 'text')
                                            @slot('style', 'width:100%')
                                            @slot('data_target', '#coa_modal')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6 mt-2">
                                        <label class="form-control-label">
                                            Account Code Name
                                        </label>

                                        @component('input::inputreadonly')
                                        @slot('id', 'acd')
                                        @slot('text', 'acd')
                                        @slot('name', 'account_name')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    
                                    
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                                        <div class="action-buttons">
                                            @component('buttons::submit')
                                                @slot('type', 'button')
                                                @slot('id','cashbook_save')
                                            @endcomponent

                                            @include('buttons::reset')

                                            @include('buttons::back')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input hidden id="coaid">

@endsection

@push('footer-scripts')
    <script>
        $(document).ready(function() {
            let currentUrl = window.location.href;
            let _hash = currentUrl.split('#');
            if (_hash.length < 2) {
                window.location.href=currentUrl+"#faCashbook";
            } else {
                window.location.href=currentUrl;
            }
        });
    </script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/coa.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/coamodal.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/currency.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/currencyfa.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/department.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/location.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/datepicker/date.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/cashbook-type.js')}}"></script>

<script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>

<script type="text/javascript">

    $(document).ready(function() {

        let _url = window.location.origin;

        $('._select2').select2({
            placeholder : '-- Select --'
        });

        $('#project').select2({
          placeholder : '-- Select --',
          ajax: {
            url: _url+'/journal/get-project-select2',
            dataType: 'json'
          },
        });

        $('[name=cashbook_ref]').select2({
          placeholder : '-- Select --',
          ajax: {
            url: '{{ route("cashbook.select.ref") }}',
            dataType: 'json'
          },
        });

        $.ajax({
          url: '/get-departments',
          type: 'GET',
          dataType: 'json',
          success: function (data) {
            $('select#_department').empty();

            $('select#_department').append(
              '<option value=""> Select a Department</option>'
            );

            $.each(data, function (key, value) {
              $('select#_department').append(
                '<option value="' + value + '">' + value + '</option>'
              );
            });
          }
        });

        let simpan = $('body').on('click', '#cashbook_save', function () {
          let form = $(this).parents('form');
          form.find('[disabled=disabled]').removeAttr('disabled');
          let _data = form.serialize();

          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/cashbook',
            data: _data,
            success: function (data) {
              if (data.errors) {
                toastr.error(data.errors, 'Invalid', {
                  timeOut: 2000
                });

              } else {
                $('.modal').modal('hide');

                toastr.success('Data Saved', 'Success', {
                  timeOut: 2000
                });

                setTimeout(function(){
                  location.href = `${_url}/cashbook/${data.uuid}/edit`;
                }, 2000);
              }
            },
            error: function(xhr) {
              if (xhr.status == 422) {
                toastr.error('Please fill required field', 'Invalid', {
                  timeOut: 2000
                });
              }else{
                toastr.error('Invalid Form', 'Invalid', {
                  timeOut: 2000
                });
              }
            }
          });
        });

        $('body').on('change', '[name=cashbook_ref]', function() {

          let val = $(this).val();

          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'get',
            url: '/cashbook/get-ref/?transactionnumber='+val,
            success: function (data) {
              if (data.errors) {
                toastr.error(data.errors, 'Invalid', {
                  timeOut: 2000
                });

              } else {
                toastr.success('Data Loaded', 'Success', {
                  timeOut: 2000
                });

                console.table(data);

                $.each( data, function( key, value ) {
                  if (key == 'cashbook_type' || key == 'transactiondate') {
                    return;
                  }

                  $(`[name=${key}]`).val(value).trigger('change');
                  // $(`[name=${key}]`).attr('disabled', '');
                });

                $(`[name=location]`).val(data.location.toLowerCase()).trigger('change');
                $(`[name=exchangerate]`).val(parseInt(data.exchangerate)).trigger('change');
                // $(`button.checkprofit`).attr('disabled', '');
              }
            }
          });
        })

        $('body').on('change', '[name=cashbook_type]', function() {
          let val = $(this).find(":selected").html();
          let _text = val.split(' ')[1];

          console.log(_text == 'Payment');

          text = _text+' From'
          if (_text == 'Payment') {
              text = _text+' To'
          }

          $('.payment_receive').html(text);
        });

        $(document).on('change', '[name=multy_currency]', function () {
          if ($(this).is(':checked')) {
            $('.second-currency').removeClass('d-none');
          } else {
            $('.second-currency').addClass('d-none');
          }
        });

    });
</script>
@endpush
