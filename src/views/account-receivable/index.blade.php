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

  table {
    min-width: 100%;
  }
</style>

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

                            @include('label::datalist')

                            <h3 class="m-portlet__head-text">
                                Account Receivable
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body pb-5">
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
                                <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                    <a href="{{url('account-receivable/create')}}" class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-primary btn-md"><span>
                                        <i class="la la-plus-circle"></i>
                                        <span>Account Receivable</span>
                                    </span></a>

                                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            {{-- @include('accountreceivableview::filter') --}}
                        </div>
                        {{-- <div class="account_receivable_datatable" id="scrolling_both"></div> --}}
                        
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered table-hover table-checkable account_receivable_datatable">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>AR NO</th>
                                            <th>Customer Name</th>
                                            <th>Ref No</th>
                                            <th>Currency</th>
                                            <th>Exchange Rate</th>
                                            <th>Total Transaction</th>
                                            <th>Account Code</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>From</th>
                                            <th>Created By</th>
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
                window.location.href=currentUrl+"#faAR";
            } else {
                window.location.href=currentUrl;
            }
        });
    </script>
<script src="{{ asset('assets/metronic/vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('vendor/courier/frontend/account-receivable/index.js')}}"></script>
@endpush
