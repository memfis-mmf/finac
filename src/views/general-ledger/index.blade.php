@extends('frontend.master')

@section('faReport', 'm-menu__item--open m-menu__item--active')
@section('faGL', 'm-menu__item--active')
@section('content')

@include('cashbookview::coamodal')
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
                                General Ledger
                            </h3>
                        </div>
                    </div>
                    @component('frontend.common.buttons.read-help')
                        @slot('href', '/general-ledger.pdf/help')
                    @endcomponent
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                            <div class="row align-items-center">
                                <div class="col-xl-6 order-2 order-xl-1">
                                    <div class="form-group m-form__group row align-items-center">
                                        <div class="col-sm-7 col-md-7 col-lg-7">
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
                                <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                                    <button href="javascript:;" class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-info btn-md select-all-coa">
                                      <span>
                                        <i class="la la-check-square-o"></i>
                                        <span>Select All Coa</span>
                                      </span>
                                    </button>

                                    <button href="javascript:;" class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-danger btn-md delete-all-coa">
                                      <span>
                                        <i class="la la-trash"></i>
                                        <span>Delete All Coa</span>
                                      </span>
                                    </button>

                                    @component('buttons::create-new')
                                    @slot('text', 'Add COA')
                                    @slot('data_target', '#coa_modal')
                                    @endcomponent
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
                                    <a href="javascript:;"
                                        class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-info btn-md print"><span>
                                            <i class="la la-print"></i>
                                            <span>Print</span>
                                        </span>
                                    </a>
                                    <a href="javascript:;"
                                        class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-primary btn-md view"><span>
                                            <i class="la la-external-link-square"></i>
                                            <span>View</span>
                                        </span>
                                    </a>
                                    <a href="javascript:;"
                                        class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-success btn-md export"><span>
                                            <i class="far fa-file-excel"></i>
                                            <span>Export to Excel</span>
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
    <script>
        $(document).ready(function() {
            let currentUrl = window.location.href;
            let _hash = currentUrl.split('#');
            if (_hash.length < 2) {
                window.location.href=currentUrl+"#faGL";
            } else {
                window.location.href=currentUrl;
            }
        });
        let all_coa = {!! $all_coa !!};
    </script>
<script src="{{ asset('vendor/courier/frontend/functions/daterange/general-ledger.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/general-ledger/index.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/coa.js')}}"></script>
<script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>
@if (Session::get('errors'))
<script type="text/javascript">
	$(document).ready(function () {
		toastr.error(`{{Session::get('errors')}}`, 'Invalid', {
				timeOut: 3000
		});
	});
</script>
@endif
@if (Session::get('success'))
<script type="text/javascript">
	$(document).ready(function () {
		toastr.success(`{{Session::get('success')}}`, 'Success', {
				timeOut: 3000
		});
	});
</script>
@endif
@endpush
