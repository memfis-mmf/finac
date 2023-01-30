@extends('frontend.master')

@section('faReport', 'm-menu__item--open m-menu__item--active')
@section('faGLExportHistory', 'm-menu__item--active')
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

  /* table td,
  table th {
    white-space: nowrap !important;
  } */

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
                                General Ledger Export History
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <div class="row">
                          <div class="col-lg-12 col-md-12 col-sm-12">
                              <table class="table table-striped table-bordered table-hover table-checkable datatable">
                                <thead>
                                  <th></th>
                                  <th>Period</th>
                                  <th>Type</th>
                                  <th>Generate By</th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
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
                window.location.href=currentUrl+"#faGLExportHistory";
            } else {
                window.location.href=currentUrl;
            }
        });
    </script>
<script src="{{ asset('assets/metronic/vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script>
  $(document).ready(function () {
      let datatable = $('.datatable').DataTable({
        dom: '<"top"f>rt<"bottom">pil',
        scrollX: true,
        processing: true,
        serverSide: true,
        ajax: '{{ route("general-ledger-export-history.datatable") }}',
        order: [
          [0, 'desc'],
        ],
        columns: [
          {data: 'created_at', visible: false},
          {data: 'name_formated', searchable: false, orderable: false},
          {data: 'type'},
          {data: 'generated_by_formated', searchable: false, orderable: false},
          {data: 'name', visible: false},
          {data: 'path', visible: false},
          {data: 'user', visible: false},
        ]
      });

      $(".dataTables_length select").addClass("form-control m-input");
      $(".dataTables_filter").addClass("pull-left");
      $(".paging_simple_numbers").addClass("pull-left");
      $(".dataTables_length").addClass("pull-right");
      $(".dataTables_info").addClass("pull-right");
      $(".dataTables_info").addClass("margin-info");
      $(".paging_simple_numbers").addClass("padding-datatable");
  });
</script>
@if (Session::get('errors'))
<script type="text/javascript">
	$(document).ready(function () {
		toastr.error(`{{Session::get('errors')}}`, 'Invalid', {
				timeOut: 3000
		});
	});
</script>
@endif
@endpush
