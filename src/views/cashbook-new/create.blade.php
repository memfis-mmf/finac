@extends('frontend.master')

@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Cashbook
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
                            Cashbook
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

                            @include('label::create-new')

                            <h3 class="m-portlet__head-text">
                                Cashbook
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
                                            Cashbook Type @include('label::required')
                                        </label>

                                        @component('input::select')
                                            @slot('id', 'cashbook_type')
                                            @slot('name', 'cashbook_type')
                                            @slot('text', 'Cashbook Type')
                                            @slot('style', 'width:100%')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Date Transaction @include('label::required')
                                        </label>

                                        @component('input::datepicker')
                                            @slot('id', 'date')
                                            @slot('text', 'Date')
                                            @slot('name', 'transaction_date')
                                            @slot('id_error', 'date')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Payment To @include('label::required')
                                        </label>

                                        @component('input::text')
                                            @slot('id', 'payment_to')
                                            @slot('text', 'Payment To')
                                            @slot('name', 'payment_to')
                                            @slot('id_error', 'payment_to')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Ref No @include('label::required')
                                        </label>

                                        @component('input::text')
                                            @slot('id', 'ref_no')
                                            @slot('text', 'Ref No')
                                            @slot('name', 'ref_no')
                                            @slot('id_error', 'ref_no')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Currency @include('label::required')
                                        </label>

                                        @component('input::select')
                                            @slot('id', 'currency')
                                            @slot('text', 'Currency')
                                            @slot('name', 'currency')
                                            @slot('id_error', 'currency')
                                        @endcomponent
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
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Account Code @include('label::required')
                                        </label>

                                        @component('input::inputrightbutton')
                                            @slot('id', 'coa')
                                            @slot('text', 'coa')
                                            @slot('name', 'coa')
                                            @slot('type', 'text')
                                            @slot('style', 'width:100%')
                                            @slot('data_target', '#coa_modal')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Account Code Name
                                        </label>

                                        @component('input::inputreadonly')
                                        @slot('id', 'acd')
                                        @slot('text', 'acd')
                                        @slot('name', 'acd')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                                        <div class="action-buttons">
                                            @component('buttons::submit')
                                                @slot('type', 'button')
                                                @slot('id','cashbook_save')
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
<input hidden id="coaid">

@endsection

@push('footer-scripts')
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/coa.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/coamodal.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/currency.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/currencyfa.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/datepicker/date.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/cashbook-type.js')}}"></script>

<script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>
@endpush
