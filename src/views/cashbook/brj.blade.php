@extends('frontend::master')

@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Cashbook - Bank Receive Journal
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
                            Cashbook - Bank Receive Journal
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
                                Cashbook - Bank Receive Journal
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="CoaForm">
                            <input type="hidden" class="form-control form-control-danger m-input" name="uuid" id="uuid">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        {{csrf_field()}}
                                        <label class="form-control-label">
                                            Bank Payment Journal No. @include('label::required')
                                        </label>

                                        @component('input::inputreadonly')
                                        @slot('id', 'bpjno')
                                        @slot('text', 'bpjno')
                                        @slot('name', 'bpjno')
                                        @slot('id_error', 'bpjno')
                                        @slot('help_text','Bank Payment Journal No.')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Date Transaction @include('label::required')
                                        </label>

                                        @component('input::datepicker')
                                        @slot('id', 'date')
                                        @slot('text', 'Date')
                                        @slot('name', 'date')
                                        @slot('id_error', 'date')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        {{csrf_field()}}
                                        <label class="form-control-label">
                                            Payment To @include('label::required')
                                        </label>

                                        @component('input::text')
                                        @slot('id', 'pto')
                                        @slot('text', 'pto')
                                        @slot('name', 'pto')
                                        @slot('id_error', 'pto')
                                        @slot('help_text','Payment To')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Ref No @include('label::required')
                                        </label>

                                        @component('input::text')
                                        @slot('id', 'refno')
                                        @slot('text', 'refno')
                                        @slot('name', 'refno')
                                        @slot('help_text','Reference No')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Currency @include('label::required')
                                        </label>

                                        @component('input::text')
                                        @slot('id', 'code')
                                        @slot('text', 'Code')
                                        @slot('name', 'code')
                                        @slot('id_error', 'code')
                                        @slot('help_text','code')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Exchange Rate @include('label::required')
                                        </label>

                                        @component('input::number')
                                        @slot('id', 'exchange')
                                        @slot('text', 'exchange')
                                        @slot('name', 'exchange')
                                        @slot('help_text','Exchange Rate')
                                        @endcomponent
                                    </div>
                                </div>

                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Account Code @include('label::required')
                                        </label>

                                        @component('input::text')
                                        @slot('id', 'coa')
                                        @slot('text', 'coa')
                                        @slot('name', 'coa')
                                        @slot('id_error', 'coa')
                                        @slot('help_text','Account Code')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Account Code Description @include('label::required')
                                        </label>

                                        @component('input::text')
                                        @slot('id', 'acd')
                                        @slot('text', 'acd')
                                        @slot('name', 'acd')
                                        @slot('help_text','Account Code Description')
                                        @endcomponent
                                    </div>
                                </div>

                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <label class="form-control-label">
                                            Remark @include('label::required')
                                        </label>

                                        @component('input::textarea')
                                        @slot('id', 'remark')
                                        @slot('text', 'remark')
                                        @slot('name', 'remark')
                                        @slot('id_error', 'remark')
                                        @slot('help_text','remark')
                                        @endcomponent
                                    </div>
                                    
                                </div>

                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="cashbookbrj_datatable" id="scrolling_both"></div>
                                    </div>
                                </div>


                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="action-buttons">
                                            @component('buttons::submit')
                                            @slot('type', 'button')
                                            @endcomponent

                                            @include('buttons::reset')

                                            @include('buttons::close')
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
<script src="{{ asset('vendor/courier/frontend/functions/reset.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/select2/type.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/type.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/datepicker/date.js')}}"></script>


<script src="{{ asset('vendor/courier/frontend/cashbookbrj.js')}}"></script>
@endpush