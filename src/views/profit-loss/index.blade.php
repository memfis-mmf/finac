@extends('frontend.master')

@section('faReport', 'm-menu__item--open m-menu__item--active')
@section('faPL', 'm-menu__item--active')
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
                                Profit & Loss
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
                                                    @slot('id', 'daterange_profitloss')
                                                    @slot('name', 'daterange_profitloss')
                                                    @slot('id_error', 'daterange_profitloss')
                                                @endcomponent
                                            </div>
                                        </div>
                                        <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="Button group with nested dropdown">
                                            <a href="javascript:;" data-href="{{url('profit-loss/view-pl')}}" class="m-btn btn btn-primary view-pl">
                                                <span>
                                                <span>View Profit & Loss </span>
                                                </span>
                                            </a>
                                            {{-- <a href="javascript:;" data-href="{{url('profit-loss/detail-pl')}}" class="btn btn-primary m-btn m-btn--pill-last detail-pl">
                                                <span>
                                                <span>Detail Profit & Loss</span>
                                                </span>
                                            </a> --}}
                                        </div>
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
                window.location.href=currentUrl+"#faPL";
            } else {
                window.location.href=currentUrl;
            }
        });
    </script>
<script src="{{ asset('vendor/courier/frontend/profit-loss/index.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/daterange/profit-loss.js')}}"></script>
@endpush
