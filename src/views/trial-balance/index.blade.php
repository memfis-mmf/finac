@extends('frontend.master')

@section('faReport', 'm-menu__item--open m-menu__item--active')
@section('faTB', 'm-menu__item--active')
@section('content')

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
                                Trial Balance
                            </h3>
                        </div>
                    </div>
                    @component('frontend.common.buttons.read-help')
                        @slot('href', '/trial-balance.pdf/help')
                    @endcomponent
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body place-datatable">
                        <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                            <div class="row align-items-center">
                                <div class="col-xl-8 order-2 order-xl-1">
																	<form class="" action="{{ route('trialbalance.print') }}" method="get">
                                    <div class="form-group m-form__group row align-items-center">
                                        <div class="col-md-5">
                                            <div class="m-input-icon m-input-icon--left">
                                                @component('input::datepicker')
                                                    @slot('id', 'daterange_trial_balance')
                                                    @slot('name', 'daterange')
                                                    @slot('id_error', 'daterange_trial_balance')
                                                @endcomponent
                                            </div>
                                        </div>
                                        <button class="btn m-btn--pill m-btn--air btn-success btn-sm mb-4">
                                            Print
                                        </button>
                                        <a href="javascript:;" type="button" class="text-light btn m-btn--pill m-btn--air btn-success btn-sm mb-4 ml-2 export">
                                            Export
                                        </a>
                                    </div>
																	</form>
                                </div>
                                <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                                </div>
                            </div>
                        </div>
                        <div class="trial_balance_datatable" id="scrolling_both"></div>
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
                window.location.href=currentUrl+"#faTB";
            } else {
                window.location.href=currentUrl;
            }
        });
    </script>
    <script src="{{ asset('vendor/courier/frontend/trial-balance/index.js')}}"></script>
    <script src="{{ asset('vendor/courier/frontend/functions/daterange/trial-balance.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('body').on('click', '.export', function () {
                let daterange = $('[name=daterange]').val();

                location.href=`{{route('trialbalance.export')}}?daterange=${daterange}`;
            });
        });
    </script>
@endpush
