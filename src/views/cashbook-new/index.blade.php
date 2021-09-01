@extends('frontend.master')

@section('faCashbook', 'm-menu__item--active')
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

  table td,
  table th {
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
        <div class="m-portlet__head ribbon ribbon-top ribbon-ver">
          <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
              <span class="m-portlet__head-icon m--hide">
                <i class="la la-gear"></i>
              </span>

              @include('label::datalist')

              <h3 class="m-portlet__head-text">
                Cashbooks
              </h3>
            </div>
          </div>
          @component('frontend.common.buttons.read-help')
          @slot('href', '/cashbook.pdf/help')
          @endcomponent
        </div>
        <div class="m-portlet m-portlet--mobile">
          <div class="m-portlet__body pb-5">
            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
              <div class="row align-items-center">
                <div class="col-xl-8 order-2 order-xl-1">
                  <div class="form-group m-form__group row align-items-center">
                    <div class="col-md-4">
                    </div>
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
                        <button
                          class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-primary btn-md mt-4">Filter</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                  <a id="export" href="{{ route('cashbook.export') }}" target="_blank"
                    class="btn m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air btn-success btn-md" style="">
                    <span>
                      <i class="fa fa-file-download"></i>
                      <span>Export All</span>
                    </span>
                  </a>
                  <a href="{{url('cashbook/create')}}"
                    class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-primary btn-md"><span>
                      <i class="la la-plus-circle"></i>
                      <span>Cashbook</span>
                    </span>
                  </a>
                  <div class="m-separator m-separator--dashed d-xl-none"></div>
                </div>
              </div>
            </div>
            @include('cashbookview::approvemodal')

            <div class="row">
              <div class="col-md-12">
                <table class="table table-striped table-bordered table-hover table-checkable cashbook_datatable">
                  <thead>
                    <th>Date</th>
                    <th>Transaction No</th>
                    <th>Journal No</th>
                    <th>Total Transaction</th>
                    <th>Payment/Received By</th>
                    <th>Remark</th>
                    <th>Status</th>
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

<script src="{{ asset('assets/metronic/vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('vendor/courier/frontend/cashbook/index.js')}}"></script>
<script>
  $(document).on("click", ".open-AddUuidApproveDialog", function () {
  var uuid = $(this).data('uuid');
  $(".modal-body #uuid-approve").val(uuid);
});
</script>
@endpush