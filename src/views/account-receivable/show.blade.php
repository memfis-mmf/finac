@extends('frontend.master')

@section('faAR', 'm-menu__item--active m-menu__item--open')
@section('faARReceive', 'm-menu__item--active')
@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Payment Receive
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
                            Payment Receive
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

                            @include('label::show')

                            <h3 class="m-portlet__head-text">
                                Payment Receive
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <form id="SupplierInvoiceGRNForm">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Date
                                        </label>

                                        @component('label::data-info')
                                            @slot('text', 'generated')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Customer
                                        </label>

                                        @component('label::data-info')
                                            @slot('text', 'generated')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Account Code
                                        </label>

                                        @component('label::data-info')
                                            @slot('text', 'generated')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Account Name
                                        </label>

                                        @component('label::data-info')
                                            @slot('text', 'generated')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Currency
                                        </label>

                                        @component('label::data-info')
                                            @slot('text', 'generated')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Exchange Rate
                                        <span id="requi" class="requi" style="font-weight: bold;color:red">*</span>
                                        </label>

                                        @component('label::data-info')
                                            @slot('text', 'generated')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <label class="form-control-label">
                                            Remark
                                        </label>

                                        @component('label::data-info')
                                            @slot('text', 'generated')
                                        @endcomponent
                                    </div>
                                </div>
                                {{-- datatables --}}
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="m-portlet m-portlet--mobile">
                                            <div class="m-portlet__body">
                                                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                                                    <div class="row align-items-center">
                                                        <div class="col-xl-6 order-2 order-xl-1">
                                                            <div class="form-group m-form__group row align-items-center">
                                                                <div class="col-md-6">
                                                                    <div class="m-input-icon m-input-icon--left">
                                                                        <input type="text" class="form-control m-input" placeholder="Search..."
                                                                            id="generalSearch">
                                                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                                                            <span><i class="la la-search"></i></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                                                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="invoice_datatable" id="scrolling_both"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <fieldset class="border p-2">
                                    <legend class="w-auto">Debt Information</legend>
                                    <div class="form-group m-form__group row">
                                        <div class="col-sm-4 col-md-4 col-lg-4">
                                            <label class="form-control-label">
                                                Debt Total Amount
                                            </label>

                                            @component('label::data-info')
                                                @slot('text', 'generated')
                                            @endcomponent
                                        </div>
                                        <div class="col-sm-4 col-md-4 col-lg-4">
                                            <label class="form-control-label">
                                                Payment Total Amount
                                            </label>

                                            @component('label::data-info')
                                                @slot('text', 'generated')
                                            @endcomponent
                                        </div>
                                        <div class="col-sm-4 col-md-4 col-lg-4">
                                            <label class="form-control-label">
                                                Payment Total Amount
                                            </label>

                                            @component('label::data-info')
                                                @slot('text', 'generated')
                                            @endcomponent
                                        </div>
                                    </div>
                                </fieldset>
                                {{-- datatables --}}
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="m-portlet m-portlet--mobile">
                                            <div class="m-portlet__body">
                                                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                                                    <div class="row align-items-center">
                                                        <div class="col-xl-6 order-2 order-xl-1">
                                                            <div class="form-group m-form__group row align-items-center">
                                                                <div class="col-md-6">
                                                                    <div class="m-input-icon m-input-icon--left">
                                                                        <input type="text" class="form-control m-input" placeholder="Search..."
                                                                            id="generalSearch">
                                                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                                                            <span><i class="la la-search"></i></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                                                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="adjustment_datatable" id="scrolling_both"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                                        <div class="action-buttons">
                                            @include('buttons::back')
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
                window.location.href=currentUrl+"#faAR";
            } else {
                window.location.href=currentUrl;
            }
        });
    </script>
<script src="{{ asset('vendor/courier/frontend/account-receivable/show.js')}}"></script>
@endpush
