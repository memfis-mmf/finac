@extends('frontend.master')

@section('faMasterCoa', 'm-menu__item--active')
@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Master Coa
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
                            Master Coa
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
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
                                Master Coa
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
                                            Account Type @include('label::required')
                                        </label>

                                        <select class="_select2 form-control" name="account_type" style="width:100%">
                                            <option value=""></option>
                                            <option value="activa">Activa</option>
                                            <option value="pasiva">Pasiva</option>
                                            <option value="ekuitas">Ekuitas</option>
                                            <option value="pendapatan">Pendapatan</option>
                                            <option value="biaya">Biaya</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Account Group  @include('label::required')
                                        </label>

                                        <select class="_select2 form-control" name="account_group" style="width:100%">
                                            <option value=""></option>
                                            <option value="Header">Header</option>
                                            <option value="Detail">Detail</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Sub Account @include('label::required')
                                        </label>

                                        @component('input::select2')
                                            @slot('id', 'sub_account')
                                            @slot('name', 'sub_account')
                                            @slot('text', 'Sub Account')
                                            @slot('disabled', 'disabled')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Account No. @include('label::required')
                                        </label>

                                        @component('input::input')
                                            @slot('id', 'account_no')
                                            @slot('name', 'account_no')
                                            @slot('text', 'Account No.')
                                            @slot('editable', 'readonly')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <label class="form-control-label">
                                            Account Name @include('label::required')
                                        </label>

                                        @component('input::text')
                                            @slot('id', 'account_name')
                                            @slot('text', 'Account Name')
                                            @slot('name', 'account_name')
                                            @slot('id_error', 'account_name')
                                        @endcomponent
                                    </div>
                                </div>
                                {{-- <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Opening Balance
                                        </label>

                                        @component('input::number')
                                            @slot('id', 'opening_balance')
                                            @slot('text', 'Opening Balance')
                                            @slot('name', 'opening_balance')
                                            @slot('id_error', 'opening_balance')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            As of Date(Opening Balance)
                                        </label>

                                        @component('input::datepicker')
                                            @slot('id', 'date')
                                            @slot('text', 'Date')
                                            @slot('name', 'asofdate')
                                            @slot('id_error', 'date')
                                        @endcomponent
                                    </div>
                                </div> --}}
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                                        <div class="action-buttons">
                                            @component('buttons::submit')
                                                @slot('type', 'button')
                                                @slot('id','master_coa_save')
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

@endsection

@push('footer-scripts')
    <script>
        $(document).ready(function() {
            let currentUrl = window.location.href;
            let _hash = currentUrl.split('#');
            if (_hash.length < 2) {
                window.location.href=currentUrl+"#faMasterCoa";
            } else {
                window.location.href=currentUrl;
            }
        });
    </script>
<script src="{{ asset('vendor/courier/frontend/functions/select2/sub-account.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/datepicker/date.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    let _url = window.location.origin;

    $('._select2').select2({
      placeholder: '-- Select --'
    });

    $('body').on('change', '[name=account_group]', function() {
      $('[name=account_no]').val('');
      $('[name=sub_account]').removeAttr('disabled');
    })

    // set data to sub account
    $('body').on('change', '[name=account_type]', function() {

      let coa_type = $(this).val();
      let _data = {
        'coa_type' : coa_type, //activa, pasiva, ekuitas, pendapatan, biaya
      };

      mApp.blockPage()

      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'get',
          url: `/master-coa/get-subaccount`,
          data: _data,
          success: function (data) {
              if (data.errors) {
                  toastr.error(data.errors, 'Invalid', {
                      timeOut: 3000
                  });
              } else {
                  $('#sub_account').empty();
                  $('#sub_account').select2({
                      data: data,
                      placeholder: '-- Select --',
                      escapeMarkup: function(markup) {
                          return markup;
                      },
                      templateResult: function(data) {
                          return data.html;
                      },
                      templateSelection: function(data) {
                          return data.text;
                      }
                  });
              }
          }
      })
      .fail(function () {
          mApp.unblockPage()
      })
      .done(function () {
          mApp.unblockPage()
      });

    });

    $('body').on('change', '[name=sub_account]', function() {
        let form = $(this).parents('form');
        let _data = form.serializeArray();

        mApp.blockPage()

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'get',
            url: `/master-coa/generate-new-coa`,
            data: _data,
            success: function (data) {
                if (data.errors) {
                    toastr.error(data.errors, 'Invalid', {
                        timeOut: 3000
                    });
                } else {
                    $('#account_no').val(data);
                }
            }
        })
        .fail(function () {
            mApp.unblockPage()
        })
        .done(function () {
            mApp.unblockPage()
        });
    });

    $('body').on('click', '#master_coa_save', function() {
        let form = $(this).parents('form');
        let _data = form.serializeArray();

        mApp.blockPage()

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: `/master-coa`,
            data: _data,
            success: function (data) {
                if (data.errors) {
                    toastr.error(data.errors, 'Invalid', {
                        timeOut: 2000
                    });
                } else {
                    toastr.success('Data Saved', 'Success', {
                        timeOut: 2000
                    });

                    setTimeout(function(){
                        location.href = `${_url}/master-coa`;
                    }, 2000);
                }
            }
        })
        .fail(function (xhr, status, error) {
            mApp.unblockPage()

            let err = $.parseJSON(xhr.responseText).message;

            toastr.error(err, 'Invalid', {
                timeOut: 3000
            });
        })
        .done(function () {
            mApp.unblockPage()
        });
    });

  });
</script>
@endpush
