@extends('frontend.master')

@section('faAP', 'm-menu__item--active m-menu__item--open')
@section('faAPSI', 'm-menu__item--active')
@section('content')
<style>
  .dataTables_paginate a{
      padding: 0 10px;
  }
  .dataTables_info{
      margin-top:-10px;
      margin-left:10px;
  }
  .dataTables_length{
      margin-top:-30px;
      visibility: hidden;
  }
  .dataTables_length select{
      visibility: visible;
  }

  table td {
    white-space: nowrap !important;
  }

  table {
    min-width: 100%;
  }
</style>
<input type="hidden" value="{{ Request::segment(2) }}" name="si_uuid" id="" />
<div class="m-subheader hidden">
  <div class="d-flex align-items-center">
    <div class="mr-auto">
      <h3 class="m-subheader__title m-subheader__title--separator">
        Supplier Invoice General
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
              Supplier Invoice General
            </span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
@include('cashbookview::coamodal')
@include('supplierinvoicegeneralview::modal-create')
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

              @include('label::edit')

              <h3 class="m-portlet__head-text">
                Supplier Invoice General
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
                      @slot('name', 'transaction_date')
                      @slot('id_error', 'date')
                      @slot('value', $data->transaction_date->format('d-m-Y'))
                      @endcomponent
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                      <label class="form-control-label">
                        Vendor @include('label::required')
                      </label>
                      <select id="vendor" name="id_supplier" class="form-control m-select2">
                        @foreach ($vendor as $x)
                        <option value="{{ $x->id }}" @if ($x->id == $data->id_supplier) selected @endif>
                          {{ $x->name }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group m-form__group row ">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                      <div class="form-group m-form__group row ">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                          <label class="form-control-label">
                            Term Of Payment @include('label::required')
                          </label>

                          @component('input::number')
                          @slot('id', 'term_of_payment')
                          @slot('text', 'Term Of Payment')
                          @slot('name', 'closed')
                          @slot('id_error', 'term_of_payment')
                          @slot('value', $data->closed)
                          @endcomponent
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                          <label class="form-control-label">
                            Due Date
                          </label>

                          <div class="input-group date">
                            <input type="text" disabled="disabled" id="valid_until" name="valid_until"
                              class="form-control" value="{{ $data->transaction_date->addDays($data->closed)->format('d-m-Y') }}">
                            <div class="input-group-append">
                              <span class="input-group-text">
                                <i class="la la-calendar glyphicon-th"></i>
                              </span>
                            </div>
                          </div>

                          {{-- @component('input::datepicker')
                                                      @slot('id', 'valid_until')
                                                      @slot('text', 'Due Date')
                                                      @slot('name', 'valid_until')
                                                      @slot('id_error', 'valid_until')
                                                                                                          @slot('value', $data->due_date)
                                                  @endcomponent --}}
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                      <div class="form-group m-form__group row ">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                          <label class="form-control-label">
                            Currency @include('label::required')
                          </label>
                          <select id="currency" name="currency" class="form-control m-select2" disabled>
                            @foreach ($currency as $x)
                            <option value="{{ $x->code }}" @if ($x->code == $data->currency) selected @endif>
                              {{ $x->full }}
                            </option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                          <label class="form-control-label">
                            Exchange Rate
                            <span id="requi" class="requi" style="font-weight: bold;color:red">*</span>
                          </label>
                          @component('input::numberreadonly')
                          @slot('id', 'exchange')
                          @slot('text', 'exchange')
                          @slot('name', 'exchange_rate')
                          @slot('value', $data->exchange_rate)
                          @endcomponent
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group m-form__group row ">
                    <div class="col-sm-6 col-md-6 col-lg-6">

                      <label class="form-control-label">
                        Account Code
                      </label>

                      {{-- @component('input::inputrightbutton')
                                              @slot('id', 'coa')
                                              @slot('text', 'coa')
                                              @slot('name', 'coa')
                                              @slot('type', 'text')
                                              @slot('style', 'width:100%')
                                              @slot('data_target', '#coa_modal')
                                              @slot('value', $data->coa->code)
                                          @endcomponent --}}

                      <select name="account_code" id="" class="_accountcode form-control">
                        @if (@$data->coa->code)
                        <option value="{{$data->coa->code}}" selected>
                          {{$data->coa->name.' ('.$data->coa->code.')'}}
                        </option>
                        @endif
                      </select>

                      {{-- @component('input::select2')
                                              @slot('id', '_accountcode')
                                              @slot('class', '_accountcode')
                                              @slot('text', 'Account Code')
                                              @slot('name', 'account_code')
                                              @slot('id_error', 'accountcode')
                                          @endcomponent --}}
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                      <label class="form-control-label">
                        Project
                      </label>

                      <select class="form-control m-input" name="id_project" id="project">
                        <option></option>
                        @if (@$data->project->id)
                        <option value="{{$data->project->id}}" selected>{{$data->project->code}}</option>
                        @endif
                      </select>
                    </div>
                    {{-- <div class="col-sm-6 col-md-6 col-lg-6">
                                          <label class="form-control-label">
                                              Account Code Name
                                          </label>

                                                                                  <input type="text" value="{{ $data->coa->name }}"
                    id="account_name" class="form-control m-input" disabled>
                  </div> --}}
                </div>
                <div class="form-group m-form__group row ">
                  <div class="col-sm-6">
                    <br />
                    <label class="form-control-label">
                      Location
                    </label>

                    <select class="_select2 form-control" name="location" style="width:100%">
                      <option value=""></option>
                      <option value="sidoarjo" {{ ($data->location == 'sidoarjo')? 'selected': '' }}>Sidoarjo</option>
                      <option value="surabaya" {{ ($data->location == 'surabaya')? 'selected': '' }}>Surabaya</option>
                      <option value="jakarta" {{ ($data->location == 'jakarta')? 'selected': '' }}>Jakarta</option>
                      <option value="biak" {{ ($data->location == 'biak')? 'selected': '' }}>Biak</option>
                    </select>
                  </div>
                  <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
                    <label class="form-control-label">
                      Remark
                    </label>

                    @component('input::textarea')
                    @slot('id', 'remark')
                    @slot('text', 'Remark')
                    @slot('name', 'description_si')
                    @slot('rows','5')
                    @slot('value', $data->description)
                    @endcomponent
                  </div>
                </div>
                <div class="form-group m-form__group row">
                  <div class="col-sm-12 col-md-12 col-lg-12 footer">
                    <div class="row align-items-center">
                      <div class="col-xl-8 order-2 order-xl-1">
                        <div class="form-group m-form__group row align-items-center">
                          <div class="col-md-4">
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-12 order-1 order-xl-2 m--align-right">
                        <button data-target="#modal_coa_create" data-toggle="modal" type="button"
                          class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-primary btn-md"><span>
                            <i class="la la-plus-circle"></i>
                            <span>Add Account</span>
                          </span>
                        </button>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                      </div>
                    </div>
                  </div>
                </div>
                @include('supplierinvoicegeneralview::modal-edit')
                {{-- datatables --}}
                <div class="form-group m-form__group row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="m-portlet m-portlet--mobile">
                      <div class="m-portlet__body">
                        <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                          <div class="row align-items-center">
                            <div class="col-xl-6 order-2 order-xl-1">
                              <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-6">
                                  <div class="m-input-icon m-input-icon--left">
                                    <input type="text" class="form-control m-input" placeholder="Search..."
                                      id="generalSearch">
                                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                      <span><i class="la la-search"></i></span>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                              <div class="m-separator m-separator--dashed d-xl-none"></div>
                            </div>
                          </div>
                        </div>
                        <div class="general_datatable" id="scrolling_both"></div>
                      </div>
                    </div>
                  </div>
                </div>

                {{-- datatable adjusment --}}
                <div class="form-group m-form__group row">
                  <div class="col-sm-12 col-md-12 col-lg-12 footer">
                    <div class="row align-items-center">
                      <div class="col-xl-8 order-2 order-xl-1">
                        <div class="form-group m-form__group row align-items-center">
                          <div class="col-md-4">
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-12 order-1 order-xl-2 m--align-right">
                        <button data-href="{{ route('trxpayment.adjustment.create', $data->id) }}" id="add_si_adj" type="button"
                          class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-primary btn-md"><span>
                            <i class="la la-plus-circle"></i>
                            <span>Add Adjustment</span>
                          </span>
                        </button>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group m-form__group row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="m-portlet m-portlet--mobile">
                      <div class="m-portlet__body pb-5">
                        <table
                          class="table table-striped table-bordered table-hover table-checkable supplier_invoice_adj_datatable"
                          data-url="{{ route('trxpayment.adjustment.datatables', $data->id) }}?show={{ $show ?? false }}">
                          <thead>
                            <tr>
                              <th></th>
                              <th>Account Code</th>
                              <th>Account Name</th>
                              <th>Debit</th>
                              <th>Credit</th>
                              <th>Description</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group m-form__group row ">
                  <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                    <div class="action-buttons">
                      @if (!isset($show))
                        @component('buttons::submit')
                        @slot('type', 'button')
                        @slot('id','supplier_invoice_generalupdate')
                        @endcomponent

                        @include('buttons::reset')
                      @endif

                      <a href="{{route('trxpayment.index')}}" class="btn btn-secondary btn-md" style="">
                        <span>
                          <i class="la la-undo"></i>
                        </span>
                        Back
                      </a>
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

<div class="modal-section">
</div>

@endsection

@push('footer-scripts')
<script>
  $(document).ready(function() {
    let currentUrl = window.location.href;
    let _hash = currentUrl.split('#');
    if (_hash.length < 2) {
        window.location.href=currentUrl+"#faAP";
    } else {
        window.location.href=currentUrl;
    }

    if ('{{ $show ?? "" }}') {
      $('input').attr('disabled', 'disabled');
      $('select').attr('disabled', 'disabled');
      $('textarea').attr('disabled', 'disabled');
      $('button').attr('disabled', 'disabled');
    }
  });

  let show = '{{ $show ?? "" }}';
</script>
<script src="{{ asset('vendor/courier/frontend/functions/reset.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/currency.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/datepicker/date.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/datepicker/valid-until.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/vendor.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/supplier-invoice/general/edit.js')}}"></script>

<script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>
<script>
  $(document).ready(function() {

    let _url = window.location.origin;

    $('._select2').select2({
      allowClear: true,
      placeholder: '-- Select --'
    });

    // handle select2
    $('._accountcode').select2({
        placeholder: '-- Select --',
        ajax: {
            url: _url+'/journal/get-account-code-select2',
            dataType: 'json'
        },
        minimumInputLength: 3,
        // templateSelection: formatSelected
    });

    $('body').on('input', '#term_of_payment', function() {
      let transaction_date_arr = $('[name=transaction_date]').val().split('-')
      let date = new Date(transaction_date_arr[2], transaction_date_arr[1], transaction_date_arr[0]);

			if (parseInt($(this).val())) {
				date.setDate(date.getDate() + parseInt($(this).val()));

	      $('#valid_until').val(('0'+date.getDate()).slice(-2)+'-'+('0'+date.getMonth()).slice(-2)+'-'+date.getFullYear());
			}else{
	      $('#valid_until').val('');
			}
    });

        Date.prototype.toInputFormat = function() {
       var yyyy = this.getFullYear().toString();
       var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
       var dd  = this.getDate().toString();
       return yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]); // padding
    };
  })
</script>
@endpush