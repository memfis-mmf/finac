@extends('frontend.master')

@section('faAP', 'm-menu__item--active m-menu__item--open')
@section('faAPSI', 'm-menu__item--active')
@section('content')
<style>
  .dataTables_paginate a {
    padding: 0 10px;
  }

  .dataTables_info {
    margin-top: -10px;
    margin-left: 10px;
  }

  .dataTables_length {
    margin-top: -30px;
    visibility: hidden;
  }

  .dataTables_length select {
    visibility: visible;
  }

  table {
    min-width: 100%;
  }

  table td {
    white-space: nowrap !important;
  }
</style>

<div class="m-content">
  <div class="row">
    <div class="col-lg-12">
      <div class="m-portlet">
        <div class="m-portlet__head ribbon ribbon-top ribbon-ver">
          <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
              <span class="m-portlet__head-icon m--hide">
                <i class="la la-gear"></i>
              </span>

              @include('label::datalist')

              <h3 class="m-portlet__head-text">
                Supplier Invoice
              </h3>
            </div>
          </div>
          @component('frontend.common.buttons.read-help')
              @slot('href', '/supplier-invoice.pdf/help')
          @endcomponent
        </div>
        <div class="m-portlet m-portlet--mobile">
          <div class="m-portlet__body">
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
              <div class="row align-items-center">
                <div class="col-xl-8 order-2 order-xl-1">
                  <div class="form-group m-form__group row align-items-center">
                    <div class="col-md-4">
                      {{-- <div class="m-input-icon m-input-icon--left">
                        <input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch">
                        <span class="m-input-icon__icon m-input-icon__icon--left">
                          <span><i class="la la-search"></i></span>
                        </span>
                      </div> --}}
                    </div>
                    {{-- @include('buttons::filter') --}}
                  </div>
                </div>
                <div class="col-md-12 mb-2">
                  <form action="" class="form-filter-datatable">
                    <div class="row">
                      <div class="col-md-3">
                        <label for="">Status</label>
                        <select name="status" class="form-control _select2">
                          <option value="all">All</option>
                          <option value="open">Open</option>
                          <option value="approved">Approved</option>
                        </select>
                      </div>
                      <div class="col">
                        <button class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-success btn-md mt-4">Filter</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                  <div class="m-btn-group m-btn-group--pill btn-group" role="group"
                    aria-label="Button group with nested dropdown">
                    <a href="{{ route('trxpayment.grn.create') }}" class="m-btn btn btn-primary">
                      <span>
                        <i class="la la-plus-circle"></i>
                        <span>GRN</span>
                      </span>
                    </a>
                    <a href="{{ route('trxpayment.create') }}"
                      class="btn btn-primary m-btn m-btn--pill-last text-white">
                      <span>
                        <i class="la la-plus-circle"></i>
                        <span>General</span>
                      </span>
                    </a>
                  </div>

                  <div class="m-separator m-separator--dashed d-xl-none"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              @include('supplierinvoiceview::filter')
            </div>

            <div class="row">
              <div class="col-md-12">
                {{-- <div class="supplier_invoice_datatable" id="scrolling_both"></div> --}}
                <table
                  class="table table-striped table-bordered table-hover table-checkable supplier_invoice_datatable">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>SI NO</th>
                      <th>Type</th>
                      <th>Supplier Name</th>
                      <th>Status</th>
                      <th>Currency</th>
                      <th>Exchange Rate</th>
                      <th>Grandtotal Foreign Before Adj</th>
                      <th>Grandtotal Foreign</th>
                      <th>Grandtotal IDR Before Adj</th>
                      <th>Grandtotal IDR</th>
                      <th>Account Code</th>
                      <th>Created By</th>
                      <th>Updated By</th>
                      <th>Approved By</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
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
      window.location.href=currentUrl+"#faAP";
    } else {
      window.location.href=currentUrl;
    }
  });
</script>
<script src="{{ asset('assets/metronic/vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('vendor/courier/frontend/supplier-invoice/index.js')}}"></script>
@endpush