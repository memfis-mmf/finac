@extends('frontend.master')

@section('faMasterCoa', 'm-menu__item--active')
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
                                Chart of Accounts
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body pb-5">
                        <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                            <div class="row align-items-center">
                                <div class="col-xl-8 order-2 order-xl-1">
                                </div>
                                <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                    <a href="{{url('master-coa/create')}}" class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-primary btn-md"><span>
                                            <i class="la la-plus-circle"></i>
                                            <span>Chart of Accounts</span>
                                        </span>
                                    </a>
                                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered table-hover table-checkable coa_datatable">
                                    <thead>
                                        <th>Account No.</th>
                                        <th>Account Name</th>
                                        <th>Account Group</th>
                                        {{-- <th>Sub Account</th>
                                        <th>Created By</th> --}}
                                        <th>Active/Inactive</th>
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
                window.location.href=currentUrl+"#faMasterCoa";
            } else {
                window.location.href=currentUrl;
            }
        });
    </script>
    <script src="{{ asset('assets/metronic/vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('vendor/courier/frontend/master-coa/index.js')}}"></script>
@endpush
