@extends('frontend.master')

@section('faFixedAssetDisposition', 'm-menu__item--active')
@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Fixed Asset Disposition
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
                            Fixed Asset Disposition
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

                            @include('label::create-new')

                            <h3 class="m-portlet__head-text">
                                Fixed Asset Disposition
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
                                           Date @include('label::required')
                                        </label>

                                        @component('input::datepicker')
                                            @slot('id', 'date')
                                            @slot('text', 'Date')
                                            @slot('name', 'asofdate')
                                            @slot('id_error', 'date')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Asset  @include('label::required')
                                        </label>

                                        @component('input::select2')
                                            @slot('id', 'master_asset')
                                            @slot('name', 'master_asset')
                                            @slot('text', 'Asset')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <fieldset class="border p-2">
                                            <legend class="w-auto">Asset Information</legend>
                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <table cellpadding="4" width="100%">
                                                        <tr>
                                                            <td width="19%"><b>Accumulated Depreciation Account</b></td>
                                                            <td width="1%">:</td>
                                                            <td width="80%">12112006 - Accm Depr Vehicles - Cars</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Depreciation Account</b></td>
                                                            <td>:</td>
                                                            <td>12112006 - Accm Depr Vehicles - Cars</td>
                                                        </tr>
                                                    </table>
                                                    <div class="form-group m-form__group row mt-4">
                                                        <div class="col-sm-4 col-md-4 col-lg-4">
                                                            <table cellpadding="4" width="100%">
                                                                <tr>
                                                                    <td width="49%" valign="top"><b>Asset Value</b></td>
                                                                    <td width="1%" valign="top">:</td>
                                                                    <td width="1%" valign="top">IDR</td>
                                                                    <td width="49%" valign="top">120.000.000</td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top"><b>Depreciation Account</b></td>
                                                                    <td valign="top">:</td>
                                                                    <td valign="top" width="1%">IDR</td>
                                                                    <td valign="top">120.000</td>
                                                                </tr>
                                                                <tr style="color:red;">
                                                                    <td valign="top"><b>Final Value</b></td>
                                                                    <td valign="top">:</td>
                                                                    <td valign="top" width="1%">IDR</td>
                                                                    <td valign="top">120.000.000</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-sm-8 col-md-8 col-lg-8">
                                                            <table cellpadding="4" width="100%">
                                                                <tr>
                                                                    <td width="19%"><b>Useful Life</b></td>
                                                                    <td width="1%">:</td>
                                                                    <td width="80%">120 Month</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><b>At Month</b></td>
                                                                    <td>:</td>
                                                                    <td>90 Month</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Selling Price @include('label::required')
                                        </label>

                                        @component('input::number')
                                            @slot('id', 'selling_price')
                                            @slot('name', 'selling_price')
                                            @slot('text', 'Selling Price')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Cash/Bank Account @include('label::required')
                                        </label>

                                        @component('input::select2')
                                            @slot('id', 'bankinfo')
                                            @slot('name', 'bankinfo')
                                            @slot('text', 'Cash/Bank Account')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Asset Profit/Loss Account @include('label::required')
                                        </label>

                                        @component('input::select2')
                                            @slot('id', 'asset_pl_account')
                                            @slot('text', 'Asset Profit/Loss Account')
                                            @slot('name', 'asset_pl_account')
                                            @slot('id_error', 'asset_pl_account')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <label class="form-control-label">
                                            Description
                                        </label>
        
                                        @component('input::textarea')
                                            @slot('id', 'description')
                                            @slot('text', 'description')
                                            @slot('name', 'description_b')
                                            @slot('rows','5')
                                        @endcomponent
                                        
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                                        <div class="action-buttons">
                                            @component('buttons::submit')
                                                @slot('type', 'button')
                                                @slot('id','fixed_asset_disposition_save')
                                            @endcomponent

                                            @include('buttons::reset')

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
                window.location.href=currentUrl+"#faFixedAssetDisposition";
            } else {
                window.location.href=currentUrl;
            }
        });
    </script>
<script src="{{ asset('vendor/courier/frontend/functions/select2/bank.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/select2/master-asset.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/select2/asset-pl-account.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/datepicker/date.js')}}"></script>
@endpush
