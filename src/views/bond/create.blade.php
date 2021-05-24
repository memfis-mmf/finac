@extends('frontend.master')

@section('faBond', 'm-menu__item--active')
@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Bond
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
                            Bond
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
                                Bond
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <form id="MasterAssetForm">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Person @include('label::required')
                                        </label>

                                        @component('input::select')
                                            @slot('id', 'employee')
                                            @slot('text', 'Person')
                                            @slot('name', 'id_employee')
                                            @slot('id_error', 'employee')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Date @include('label::required')
                                        </label>

                                        @component('input::datepicker')
                                            @slot('id', 'date')
                                            @slot('name', 'transaction_date')
                                            @slot('text', 'Date')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Date Returned @include('label::required')
                                        </label>

                                        @component('input::datepicker')
                                            @slot('id', 'date-required')
                                            @slot('text', 'Date Returned')
                                            @slot('name', 'date_return')
                                            @slot('id_error', 'date-required')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Amount @include('label::required')
                                        </label>

                                        @component('input::number')
                                            @slot('id', 'amount')
                                            @slot('name', 'value')
                                            @slot('text', 'Amount')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <h4>Cash/Bank Account @include('label::required')</h4>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Account Code
                                        </label>


                                        @component('input::inputrightbutton')
                                            @slot('id', 'coa')
                                            @slot('text', 'coa')
                                            @slot('name', 'coac')
                                            @slot('type', 'text')
                                            @slot('style', 'width:100%')
                                            @slot('help_text','Account Code')
                                            @slot('buttonid','coa_button_1')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Account Name
                                        </label>

                                        @component('input::input')
                                            @slot('id', 'account_name_1')
                                            @slot('name', 'account_name_1')
                                            @slot('text', 'Account Name')
                                            @slot('editable', 'disabled')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <h4>Bond Account @include('label::required')</h4>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Account Code
                                        </label>

                                        @component('input::inputrightbutton')
                                            @slot('id', 'coa_bond')
                                            @slot('text', 'coa')
                                            @slot('name', 'coad')
                                            @slot('type', 'text')
                                            @slot('style', 'width:100%')
                                            @slot('help_text','Account Code')
                                            @slot('buttonid','coa_button_2')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Account Name
                                        </label>

                                        @component('input::input')
                                            @slot('id', 'account_name_2')
                                            @slot('name', 'account_name_2')
                                            @slot('text', 'Account Name')
                                            @slot('editable', 'disabled')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <label class="form-control-label">
                                            Description @include('frontend.common.label.optional')
                                        </label>

                                        @component('input::textarea')
                                            @slot('id', 'description')
                                            @slot('text', 'Description')
                                            @slot('name', 'description')
                                            @slot('rows','5')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                                        <div class="action-buttons">
                                            @component('buttons::submit')
                                                @slot('type', 'button')
                                                @slot('id','bond_save')
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
                window.location.href=currentUrl+"#faBond";
            } else {
                window.location.href=currentUrl;
            }
        });
    </script>
<script src="{{ asset('vendor/courier/frontend/functions/reset.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/employee.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/employee.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/datepicker/date.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/datepicker/date-required.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/bond/create.js')}}"></script>

<script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>
@endpush
