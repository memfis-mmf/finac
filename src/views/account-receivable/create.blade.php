@extends('frontend.master')

@section('faAR', 'm-menu__item--active m-menu__item--open')
@section('faARReceive', 'm-menu__item--active')
@section('content')
<div class="m-subheader hidden">
  <div class="d-flex align-items-center">
    <div class="mr-auto">
      <h3 class="m-subheader__title m-subheader__title--separator">
        Account Receivable
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
              Account Receivable
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
                Account Receivable
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
                      Date @include('label::required')
                    </label>

                    @component('input::datepicker')
                    @slot('id', 'date')
                    @slot('text', 'Date')
                    @slot('name', 'transactiondate')
                    @slot('id_error', 'date')
                    @endcomponent
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-6">
                    <label class="form-control-label">
                      Customer @include('label::required')
                    </label>

                    <select name="id_customer" class="form-control m-input select2" style="width:100%">
                      <option value=""></option>
                      @foreach ($customer as $customer_row)
                      <option value="{{$customer_row->id}}">{{$customer_row->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-6 mt-3">
                    <label class="form-control-label">
                      Project
                    </label>

                    @component('input::select')
                    @slot('id', 'project')
                    @slot('name', 'id_project')
                    @slot('text', 'Project')
                    @endcomponent
                  </div>
                  <div class="col-md-6 mt-3">
                    <label class="form-control-label">
                      Payment Type @include('label::required')
                    </label>

                    <select id="payment_type" name="payment_type" class="form-control m-input" style="">
                        <option value=""> — Select  —</option>
                        <option value="bank">Bank</option>
                        <option value="cash">Cash</option>
                    </select>

                  </div>
                </div>
                
                <div class="form-group m-form__group row ">
                  <div class="col-sm-6 col-md-6 col-lg-6">
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
                  <div class="col-sm-6 col-md-6 col-lg-6">
                    <label class="form-control-label">
                      Account Name
                    </label>

                    <input type="text" name="account_name" id="grn_no" class="form-control m-input" disabled>
                  </div>
                </div>
                <div class="form-group m-form__group row ">
                  <div class="col-sm-6 col-md-6 col-lg-6">
                    <label class="form-control-label">
                      Currency @include('label::required')
                    </label>

                    @component('input::select')
                    @slot('id', 'currency')
                    @slot('text', 'Currency')
                    @slot('name', 'currency')
                    @slot('id_error', 'currency')
                    @endcomponent
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-6">
                    <label class="form-control-label">
                      Exchange Rate
                      <span id="requi" class="requi" style="font-weight: bold;color:red">*</span>
                    </label>
                    @component('input::numberreadonly')
                    @slot('id', 'exchange')
                    @slot('text', 'exchange')
                    @slot('name', 'exchangerate')
                    @endcomponent
                  </div>
                </div>
                <div class="form-group m-form__group row ">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <label class="form-control-label">
                      Remark
                    </label>

                    @component('input::textarea')
                    @slot('id', 'remark')
                    @slot('text', 'Remark')
                    @slot('name', 'description')
                    @slot('rows','5')
                    @endcomponent
                  </div>
                </div>
                <div class="form-group m-form__group row ">
                  <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                    <div class="action-buttons">
                      @component('buttons::submit')
                      @slot('type', 'button')
                      @slot('id','account_receivable_save')
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
        window.location.href=currentUrl+"#faAR";
    } else {
        window.location.href=currentUrl;
    }

    $('.select2').select2({
      placeholder: 'Select Customer'
    });

  });
</script>
<script src="{{ asset('vendor/courier/frontend/functions/reset.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/currency.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/currencyfa.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/datepicker/date.js')}}"></script>

{{-- <script src="{{ asset('vendor/courier/frontend/functions/select2/vendor.js')}}"></script> --}}

<script src="{{ asset('vendor/courier/frontend/account-receivable/create.js')}}"></script>

<script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>
@endpush