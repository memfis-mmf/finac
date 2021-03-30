@extends('frontend.master')

@section('faAR', 'm-menu__item--active m-menu__item--open')
@section('faARInv', 'm-menu__item--active')
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
                <div class="m-portlet__head ribbon ribbon-top ribbon-ver">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>

                            @include('label::datalist')

                            <h3 class="m-portlet__head-text">
                                Invoices
                            </h3>
                        </div>
                    </div>
                    @component('frontend.common.buttons.read-help')
                        @slot('href', '/invoice.pdf/help')
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
                                <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                    <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="Button group with nested dropdown">
                                        <div class="m-btn-group btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-primary m-btn m-btn--pill-last dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius:20px;">
                                                <span>
                                                    <i class="la la-plus-circle"></i>
                                                    <span>Invoice</span>
                                                </span>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                <a class="dropdown-item" href="{{route('invoice.create')}}">
                                                    <span>
                                                        <i class="la la-plus-circle"></i>
                                                        <span>Invoice</span>
                                                    </span>
                                                </a>
                                                <!-- <a class="dropdown-item" href="{{-- {{route('frontend.invoice-sales.create')}} --}}">
                                                    <span>
                                                        <i class="la la-plus-circle"></i>
                                                        <span>Invoice Sales</span>
                                                    </span>
                                                </a> -->
                                                <!-- <a class="dropdown-item" href="{{route('frontend.invoice-workshop.create')}}">
                                                    <span>
                                                        <i class="la la-plus-circle"></i>
                                                        <span>Invoice Workshop</span>
                                                    </span>
                                                </a> -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered table-hover table-checkable invoice_datatable">
                                    <thead>
                                        <th></th>
                                        <th>Date</th>
                                        <th>Invoice No.</th>
                                        <th>Type</th>
                                        <th>Customer</th>
                                        <th>Quotation No.</th>
                                        <th>Currency</th>
                                        <th>Total</th>
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
@include('invoiceview::approvemodal')
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
<script src="{{ asset('vendor/courier/frontend/functions/reset.js')}}"></script>
@if (Session::get('success'))
	<script type="text/javascript">
		toastr.success('{{Session::get("success")}}', 'Success',  {
			timeOut: 2000
		});
	</script>
@endif
<script>
$(document).on("click", ".open-AddUuidApproveDialog", function () {
     var uuid = $(this).data('uuid');
     //console.log(uuid);
     $(".modal-body #uuid-approve").val(uuid);
     // As pointed out in comments,
     // it is unnecessary to have to manually call the modal.
     // $('#addBookDialog').modal('show');
});
</script>

<script src="{{ asset('vendor/courier/frontend/invoice/invoice.js')}}"></script>
@endpush
