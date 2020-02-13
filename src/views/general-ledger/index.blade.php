@extends('frontend.master')

@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                General Ledger
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
                            General Ledger
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
@include('cashbookview::coamodal')
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
                                General Ledger
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
                                        <div class="col-md-5">
                                            <div class="m-input-icon m-input-icon--left">
                                                <label class="form-control-label">
                                                    Select Period
                                                </label>
                                                @component('input::datepicker')
                                                    @slot('id', 'daterange_general_ledger')
                                                    @slot('name', 'daterange_general_ledger')
                                                    @slot('id_error', 'daterange_general_ledger')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                    @component('buttons::create-new')
                                        @slot('text', 'Add COA')
                                        @slot('data_target', '#coa_modal')
                                    @endcomponent
                                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="coa_datatable" id="scrolling_both"></div> --}}
												<table class="coa_datatable table table-hover">
													<thead>
														<tr style="background:#eee">
															<th>Account Code</th>
															<th>Account Name</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>

                        <div class="form-group m-form__group row ">
                            <div class="col-sm-12 col-md-12 col-lg-12  d-flex justify-content-end">
                                <div class="action-buttons">
                                    <a href="" class="btn m-btn--pill m-btn--air btn-outline-info btn-md "><span>
                                            <i class="la la-print"></i>
                                            <span>Print</span>
                                        </span>
                                    </a>
                                    <a href="javascript:;" class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-primary btn-md view"><span>
                                            <i class="la la-file"></i>
                                            <span>View</span>
                                        </span>
                                    </a>
                                </div>
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
<script src="{{ asset('vendor/courier/frontend/functions/daterange/general-ledger.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/general-ledger/index.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/coa.js')}}"></script>
<script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>
@endpush
