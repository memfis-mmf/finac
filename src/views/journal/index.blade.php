@extends('frontend.master')

@section('faJournal', 'm-menu__item--active')
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

  .dataTable td:nth-child(2) {
    white-space: nowrap !important;
  }
</style>

<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Journal
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
                            Journal
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

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
                                Journal
                            </h3>
                        </div>
                    </div>
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
                                <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                    <a href="{{url('journal/create')}}" class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-primary btn-md"><span>
                                            <i class="la la-plus-circle"></i>
                                            <span>Journal</span>
                                        </span></a>
                                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            @include('journalview::filter')
                        </div>
                        {{-- <div class="journal_datatable" id="scrolling_both"></div> --}}
                        <div class="row">
                          <div class="col-lg-12 col-md-12 col-sm-12">
                              <table class="table table-striped table-bordered table-hover table-checkable journal_datatable">
                                <thead>
                                  <th>Date</th> 
                                  <th>Transaction No</th> 
                                  <th>Ref Doc</th> 
                                  <th>Currency</th> 
                                  <th width="12%">Exchange Rate</th> 
                                  <th>Journal Type</th> 
                                  <th width="15%">Total Amount</th> 
                                  <th>Created By</th> 
                                  <th>Updated By</th> 
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
                window.location.href=currentUrl+"#faJournal";
            } else {
                window.location.href=currentUrl;
            }
        });
    </script>
<script src="{{ asset('assets/metronic/vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('vendor/courier/frontend/journal/index.js')}}"></script>
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
