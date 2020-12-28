@extends('frontend.master')

@section('faReport', 'm-menu__item--open m-menu__item--active')
@section('faBS', 'm-menu__item--active')
@section('content')

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
                            <h3 class="m-portlet__head-text">
                                Balance Sheet
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
                                                    @slot('id', 'daterange_balance_sheet')
                                                    @slot('name', 'daterange_balance_sheet')
                                                    @slot('id_error', 'daterange_balance_sheet')
                                                @endcomponent
                                            </div>
                                        </div>
                                        <a href="javascript:;" class="view btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-primary btn-md">
                                            <span>
                                                <span>View Balance Sheet</span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                    <div class="m-separator m-separator--dashed d-xl-none"></div>
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
                window.location.href=currentUrl+"#faBS";
            } else {
                window.location.href=currentUrl;
            }
        });
    </script>
<script src="{{ asset('vendor/courier/frontend/functions/daterange/balance-sheet.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		let _url = window.location.origin;

		$('body').on('click', '.view', function() {
			let date = $('[name=daterange_balance_sheet]').val();

			location.href=_url+"/balance-sheet/show/?daterange="+date;
		})
	});
</script>
@endpush
