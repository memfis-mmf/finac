@extends('frontend.master')

@section('faAsset', 'm-menu__item--active')
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
                                Master Asset
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body pb-5">
                        <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                            <div class="row align-items-center">
                                <div class="col-xl-6 order-2 order-xl-1">
                                    <div class="form-group m-form__group row align-items-center">
                                        <div class="col-md-4">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                                    <a href="{{url('asset/create')}}" class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-primary btn-md">
                                      <span>
                                        <i class="la la-plus-circle"></i>
                                        <span>Master Asset</span>
                                      </span>
                                    </a>
                                    <a 
                                      href="#modal_form_depreciation" data-toggle="modal" 
                                      class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-info btn-md btn-depreciation">
                                      <span>
                                        <i class="fa fa-copy"></i>
                                        <span>Generate Depreciation</span>
                                      </span>
                                    </a>

                                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            @include('masterassetview::filter')
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                {{-- <div class="master_asset_datatable" id="scrolling_both"></div> --}}
                                <table class="table table-striped table-bordered table-hover table-checkable master_asset_datatable">
                                    <thead>
                                        <th>Code Asset</th>
                                        <th>Asset Name</th>
                                        <th>Ref. Doc</th>
                                        <th>Asset Value</th>
                                        <th>Useful Life</th>
                                        <th>COA Accumulate</th>
                                        <th>COA Expense</th>
                                        <th>COA Depreciation</th>
                                        <th>Depreciation Start</th>
                                        <th>Depreciation End</th>
                                        <th>Created By</th>
                                        <th>Approved By</th>
                                        <th>Actions</th>
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

<div class="modal fade" id="modal_form_depreciation">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TitleModalInstruction" style="margin-top:-5px">
          Depreciation <small id="instruction" class="m--font-focus"></small>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('asset.depreciation') }}" id="form-depreciation">
          <div class="form-group">
            <label for="">Date</label>
            <input type="text" class="form-control" name="date_generate">
          </div>

          <button class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-primary btn-md">
            <span>
              <i class="la la-plus-circle"></i>
              <span>Generate</span>
            </span>
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_history_depreciation">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TitleModalInstruction" style="margin-top:-5px">
          Depreciation <small id="instruction" class="m--font-focus"></small>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"></div>
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
                window.location.href=currentUrl+"#faAsset";
            } else {
                window.location.href=currentUrl;
            }
        });
    </script>
<script src="{{ asset('vendor/courier/frontend/master-asset/index.js')}}"></script>
<script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>
@endpush
