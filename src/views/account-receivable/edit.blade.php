@extends('frontend.master')

@section('faAR', 'm-menu__item--active m-menu__item--open')
@section('faARReceive', 'm-menu__item--active')
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

  table,
  table thead {
    min-width: 100% !important;
  }
</style>
<div class="m-subheader hidden">
  <input type="hidden" name="ar_uuid" value="{{ Request::segment(2) }}" disabled>
  <div class="d-flex align-items-center">
    <div class="mr-auto">
      <h3 class="m-subheader__title m-subheader__title--separator">
        Payment Receive
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
              Payment Receive
            </span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
@include('cashbookview::coamodal')
{{-- coa modal ADJ --}}
<div class="modal fade" id="coa_modal_adj" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TitleModalBasic">Chart Of Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="hiderow" value="">
        <table class="table table-striped table-bordered table-hover table-checkable" id="coa_datatables_adj">
          <thead>
            <tr>
              <th>Account Code</th>
              <th>Account Name</th>
              <th></th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="modal-footer">
        <div class="flex">
          <div class="action-buttons">
            <div class="flex">
              <div class="action-buttons">
                @component('frontend.common.buttons.close')
                @slot('text', 'Close')
                @endcomponent
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- end coa modal ADJ --}}
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
                Payment Receive
              </h3>
            </div>
          </div>
        </div>
        <div class="m-portlet m-portlet--mobile">
          <div class="m-portlet__body">
            <form id="SupplierInvoiceGRNForm">
              <input type="hidden" name="ar_uuid" value="{{ Request::segment(2) }}">
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
                    @slot('value', $data->date)
                    @endcomponent
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-6">
                    <label class="form-control-label">
                      Customer @include('label::required')
                    </label>
                    <select id="customer" name="id_customer" class="form-control m-select2">
                      @foreach ($customer as $x)
                      <option value="{{ $x->id }}" @if ($x->id == $data->id_customer) selected @endif>
                        {{ $x->name }}
                      </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-6 mt-3">
                    <label class="form-control-label">
                      Project
                    </label>

                    <select class="form-control m-input" name="id_project" id="project">
                      @if ($data->project)
                      <option value="{{$data->project->id}}" selected>{{$data->project->code}}</option>
                      @else
                      <option value="">-- Select --</option>
                      @endif
                    </select>
                  </div>
                  <div class="col-md-6 mt-3">
                    <label class="form-control-label">
                      Payment Receive Type @include('label::required')
                    </label>

                    <select id="payment_type" name="payment_type" class="form-control m-input" style="">
                        <option value=""> — Select  —</option>
                        <option value="bank" {{ ($data->payment_type == 'bank')? 'selected': '' }}>Bank</option>
                        <option value="cash" {{ ($data->payment_type == 'cash')? 'selected': '' }}>Cash</option>
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
                    @slot('value', $data->coa->code)
                    @endcomponent
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-6">
                    <label class="form-control-label">
                      Account Name
                    </label>

                    <input type="text" name="account_name" value="{{ $data->coa->name }}" id="account_name"
                      class="form-control m-input" disabled>
                  </div>
                </div>
                <div class="form-group m-form__group row ">
                  <div class="col-sm-6 col-md-6 col-lg-6">
                    <label class="form-control-label">
                      Currency @include('label::required')
                    </label>
                    <select id="currency" name="currency" class="form-control m-select2">
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
                    @component('input::number')
                    @slot('id', 'exchange')
                    @slot('text', 'exchange')
                    @slot('name', 'exchangerate')
                    @slot('value', (int) $data->exchangerate)
                    @endcomponent
                  </div>
                </div>
                <div class="form-group m-form__group row ">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <label class="form-control-label">
                            Location 
                        </label>

                        <select class="_select2 form-control" name="location" style="width:100%">
                          <option value=""></option>
                          <option value="sidoarjo" {{(strtolower($data->location) == 'sidoarjo')? 'selected': ''}}>Sidoarjo</option>
                          <option value="surabaya" {{(strtolower($data->location) == 'surabaya')? 'selected': ''}}>Surabaya</option>
                          <option value="jakarta" {{(strtolower($data->location) == 'jakarta')? 'selected': ''}}>Jakarta</option>
                          <option value="biak" {{(strtolower($data->location) == 'biak')? 'selected': ''}}>Biak</option>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <label class="form-control-label">
                            Department
                        </label>
                        <select class="_select2 form-control" name="department" style="width:100%">
                            <option value=""></option>
                            @foreach ($department as $department_row)
                                <option value="{{$department_row->name}}" {{($data->department == $department_row->name)? 'selected': ''}}>{{$department_row->name}}</option>
                            @endforeach
                        </select>
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
                    @slot('name', 'ar_description')
                    @slot('rows','5')
                    @slot('value',$data->description)
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
                        <button data-target="#modal_create_invoice" data-toggle="modal" type="button"
                          class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-primary btn-md btn-modal-create-invoice"><span>
                            <i class="la la-plus-circle"></i>
                            <span>Invoice</span>
                          </span>
                        </button>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                      </div>
                    </div>
                  </div>
                </div>
                @include('accountreceivableview::modal-create-invoice')
                @include('accountreceivableview::modal-edit-invoice')
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
                        <div class="invoice_datatable" id="scrolling_both"></div>
                      </div>
                    </div>
                  </div>
                </div>
                {{-- <fieldset class="border p-2">
                  <legend class="w-auto">Credit Information</legend>
                  <div class="form-group m-form__group row">
                    <div class="col-sm-4 col-md-4 col-lg-4">
                      <label class="form-control-label">
                        Credit Total Amount
                      </label>

                      @component('label::data-info')
                      @slot('text', 'Rp '.number_format($credit_total_amount, 0, ',', '.'))
                      @endcomponent
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                      <label class="form-control-label">
                        Receive Total Amount
                      </label>

                      @component('label::data-info')
                      @slot('text', 'Rp '.number_format($payment_total_amount, 0, ',', '.'))
                      @endcomponent
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                      <label class="form-control-label">
                        Credit Balance
                      </label>

                      @component('label::data-info')
                      @slot('text', $credit_balance)
                      @endcomponent
                    </div>
                  </div>
                </fieldset> --}}
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
                        <button data-target="#coa_modal_adj" data-toggle="modal" type="button"
                          class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-primary btn-md"><span>
                            <i class="la la-plus-circle"></i>
                            <span>Adjustment</span>
                          </span>
                        </button>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                      </div>
                    </div>
                  </div>
                </div>
                @include('accountreceivableview::modal-edit-adjustment')
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
                        <div class="adjustment_datatable" id="scrolling_both"></div>
                      </div>
                    </div>
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


@push('header-scripts')
<style>
  @media (min-width: 992px) {
    .modal-invoice {
      max-width: 1300px !important;
    }
  }
</style>
@endpush

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
  });

  let page_type = '{{ $page_type ?? null }}';
</script>
<script src="{{ asset('vendor/courier/frontend/functions/reset.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/currency.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/datepicker/date.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/customer.js')}}"></script>

<script src="{{ asset('assets/metronic/vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('vendor/courier/frontend/account-receivable/edit.js')}}"></script>

@endpush