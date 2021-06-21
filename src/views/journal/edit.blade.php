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

  table td {
    white-space: nowrap !important;
  }

  table {
    min-width: 100%;
  }
</style>
<input type="hidden" name="voucher_no" value="{{ $journal->voucher_no }}" disabled>
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
<div class="modal fade" id="coa_modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <table class="table table-striped table-bordered table-hover table-checkable" id="coa_datatables">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
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
@include('journalview::modal')
@include('journalview::modal-create')
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
                                Journal
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <form id="JournalForm">
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
																						@slot('value', $journal->transaction_date->format('d-m-Y'))
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">

                                        <label class="form-control-label">
                                            Journal Type @include('label::required')
                                        </label>
																				<input type="hidden" value="{{ $journal->journal_type }}" name="journal_type" id=""/>
																				<select id="type" name="journal_type" class="form-control m-select2" disabled>
																						@foreach ($journal_type as $x)
																								<option value="{{ $x->id }}"
																										@if ($x->id == $journal->journal_type) selected @endif>
																										{{ $x->name }}
																								</option>
																						@endforeach
																				</select>
        
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">

                                        <label class="form-control-label">
                                            Currency @include('label::required')
                                        </label>

																				<select id="currency" name="currency_code" class="form-control m-select2">
																						@foreach ($currency as $currency_row)
																								<option value="{{ $currency_row->code }}"
																										@if ($currency_row->code == $journal->currency_code) selected @endif>
																										{{ $currency_row->full_name }}
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
																						@slot('value', (int) $journal->exchange_rate)
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <label class="form-control-label">
                                            Ref Doc
                                        </label>

                                        @component('input::textarea')
                                            @slot('id', 'refdoc')
                                            @slot('text', 'refdoc')
                                            @slot('name', 'ref_no')
                                            @slot('rows','5')
																						@slot('value',$journal->ref_no)
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="m-portlet">
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-caption">
                                                    <div class="m-portlet__head-title">
                                                        <span class="m-portlet__head-icon m--hide">
                                                            <i class="la la-gear"></i>
                                                        </span>

                                                        @include('label::datalist')

                                                        <h3 class="m-portlet__head-text">
                                                            Account Code
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-portlet m-portlet--mobile">
                                                <div class="m-portlet__body" style="padding-bottom:90px">
                                                    <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                                                        <div class="row align-items-center">
                                                            <div class="col-xl-8 order-2 order-xl-1">
                                                                <div class="form-group m-form__group row align-items-center">
                                                                    <div class="col-md-4">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                                                @component('buttons::create-new')
                                                                    @slot('text', 'Account Code')
                                                                    @slot('data_target', '#modal_coa_create')
                                                                @endcomponent
                                                                <div class="m-separator m-separator--dashed d-xl-none"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="accountcode_datatable" id="scrolling_both"></div> --}}
                                                    <table class="table table-striped table-bordered table-hover table-checkable accountcode_datatable">
                                                      <thead>
                                                        <th>Account Code</th> 
                                                        <th>Account Name</th> 
                                                        <th>Project</th> 
                                                        <th>Debit</th> 
                                                        <th>Credit</th> 
                                                        <th>Remark</th> 
                                                        <th>Action</th> 
                                                      </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                  <div class="col-md-6">
                                    <div class="form-group m-form__group row">
                                        <div class="col-sm-3 col-md-3 col-lg-3">
                                            <div>
                                                Total Debit
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                          <input type="text" class="form-control" disabled id="total_debit">
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <div class="col-sm-3 col-md-3 col-lg-3">
                                            <div>
                                                Total Credit
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                          <input type="text" class="form-control" disabled id="total_credit">
                                        </div>
                                    </div>
                                  </div>

                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                                        <div class="action-buttons">
                                          @if (@$page_type != 'show')
                                            @component('buttons::submit')
                                                @slot('type', 'button')
                                                @slot('id','journalsave')
                                                @slot('data_uuid', Request::segment(2))
                                            @endcomponent

                                            @include('buttons::reset')
                                          @endif

																						<a href="{{route('journal.index')}}" class="btn btn-secondary btn-md" style="">
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
  let page_type = '{{ $page_type ?? "" }}';
</script>
<script src="{{ asset('vendor/courier/frontend/functions/reset.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/select2/currency.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/datepicker/date.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/select2/type.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/select2/account-code.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/journal/edit.js')}}"></script>

<script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>

@endpush
