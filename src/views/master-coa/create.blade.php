@extends('frontend.master')

@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Master Coa
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
                            Master Coa
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
                                Master Coa
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
                                            Account Type @include('label::required')
                                        </label>

                                        <select class="_select2 form-control" name="account_type" style="width:100%">
                                            <option value=""></option>
                                            <option value="Activa">Activa</option>
                                            <option value="Pasiva">Pasiva</option>
                                            <option value="Ekuitas">Ekuitas</option>
                                            <option value="Pendapatan">Pendapatan</option>
                                            <option value="Biaya">Biaya</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Account Group  @include('label::required')
                                        </label>

                                        <select class="_select2 form-control" name="account_group" style="width:100%">
                                            <option value=""></option>
                                            <option value="Header">Header</option>
                                            <option value="Detail">Detail</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Sub Account 
                                        </label>

                                        @component('input::select2')
                                            @slot('id', 'sub_account')
                                            @slot('name', 'sub_account')
                                            @slot('text', 'Sub Account')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Account No. @include('label::required')
                                        </label>

                                        @component('input::input')
                                            @slot('id', 'account_no')
                                            @slot('name', 'account_no')
                                            @slot('text', 'Account No.')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <label class="form-control-label">
                                            Account Name @include('label::required')
                                        </label>

                                        @component('input::text')
                                            @slot('id', 'account_name')
                                            @slot('text', 'Account Name')
                                            @slot('name', 'account_name')
                                            @slot('id_error', 'account_name')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Opening Balance 
                                        </label>

                                        @component('input::number')
                                            @slot('id', 'opening_balance')
                                            @slot('text', 'Opening Balance')
                                            @slot('name', 'opening_balance')
                                            @slot('id_error', 'opening_balance')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            As of Date(Opening Balance) 
                                        </label>

                                        @component('input::datepicker')
                                            @slot('id', 'date')
                                            @slot('text', 'Date')
                                            @slot('name', 'asofdate')
                                            @slot('id_error', 'date')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                                        <div class="action-buttons">
                                            @component('buttons::submit')
                                                @slot('type', 'button')
                                                @slot('id','master_coa_save')
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
<script src="{{ asset('vendor/courier/frontend/functions/select2/sub-account.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/datepicker/date.js')}}"></script>
@endpush
