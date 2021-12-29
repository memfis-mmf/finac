@extends('frontend.master')

@section('faAR', 'm-menu__item--active m-menu__item--open')
@section('faARInv', 'm-menu__item--active')
@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Invoice Sales
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
                    <a href="{{ route('invoice.index') }}" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Invoice Sales
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

                            @include('frontend.common.label.create-new')

                            <h3 class="m-portlet__head-text">
                                Invoice Sales
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <form id="itemform" name="itemform">
                            <div class="form-group m-form__group row">
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <label class="form-control-label">
                                        Ref Quotation No. @include('frontend.common.label.required')
                                    </label>

                                    @component('input::inputrightbutton')
                                        @slot('text', 'Ref Quotation No')
                                        @slot('id', 'refquono')
                                        @slot('data_target', '#refquo_modal')
                                        @slot('name', 'refquono')
                                        @slot('id_error', 'refquono')
                                    @endcomponent

                                    <div class="form-group m-form__group row mt-4">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <fieldset class="border p-2">
                                                <legend class="w-auto">Identifier Customer</legend>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="m-portlet__head">
                                                        <div class="m-portlet__head-tools">
                                                            <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                                                                <li class="nav-item m-tabs__item">
                                                                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1" role="tab">
                                                                        <i class="la la-bell-o"></i> General
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item m-tabs__item">
                                                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab">
                                                                        <i class="la la-bell-o"></i> Contact
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item m-tabs__item">
                                                                    <a class="nav-link m-tabs__link " data-toggle="tab" href="#m_tabs_6_3" role="tab">
                                                                        <i class="la la-cog"></i> Address
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="m-portlet__body">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group m-form__group row">
                                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                                        <label class="form-control-label">
                                                                            Customer Name
                                                                        </label>

                                                                        @component('input::inputreadonly')
                                                                        @slot('text', 'XXX')
                                                                        @slot('id', 'name')
                                                                        @endcomponent
                                                                    </div>
                                                                </div>
                                                                <div class="form-group m-form__group row">
                                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                                        <label class="form-control-label">
                                                                            Attention
                                                                        </label>

                                                                        @component('frontend.common.input.select2')
                                                                        @slot('text', 'Bp. Romdani')
                                                                        @slot('id', 'attention')
                                                                        @slot('name', 'attention')
                                                                        @endcomponent
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group m-form__group row">
                                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                                        <label class="form-control-label">
                                                                            Phone
                                                                        </label>

                                                                        @component('frontend.common.input.select2')
                                                                        @slot('text', '+62xxxxxxx / 07777777')
                                                                        @slot('id', 'phone')
                                                                        @slot('name', 'phone')
                                                                        @endcomponent

                                                                    </div>
                                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                                        <label class="form-control-label">
                                                                            Fax
                                                                        </label>

                                                                        @component('frontend.common.input.select2')
                                                                        @slot('text', '+62xxxxxxx / 07777777')
                                                                        @slot('id', 'fax')
                                                                        @slot('name', 'fax')
                                                                        @endcomponent
                                                                    </div>
                                                                </div>
                                                                <div class="form-group m-form__group row">
                                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                                        <label class="form-control-label">
                                                                            Email
                                                                        </label>

                                                                        @component('frontend.common.input.select2')
                                                                        @slot('text', '+62xxxxxxx / 07777777')
                                                                        @slot('id', 'email')
                                                                        @slot('name', 'email')
                                                                        @endcomponent

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <div class="form-group m-form__group row">
                                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                                        <label class="form-control-label">
                                                                            Address
                                                                        </label>

                                                                        @component('input::inputreadonly')
                                                                        @slot('text', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi, nulla odio consequuntur obcaecati eos error recusandae minima eveniet dolor sed tempora! Ut quidem illum accusantium expedita nulla eos reprehenderit officiis?')
                                                                        @slot('id', 'address')
                                                                        @slot('name', 'address')
                                                                        @endcomponent
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group m-form__group row">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="form-control-label">
                                                Date @include('frontend.common.label.required')
                                            </label>

                                            @component('input::datepicker')
                                                @slot('id', 'date')
                                                @slot('text', 'Date')
                                                @slot('name', 'date')
                                                @slot('id_error', 'date')
                                                @slot('id_error','requested_at')
                                            @endcomponent
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="form-control-label">
                                                Currency @include('frontend.common.label.required')
                                            </label>

                                            @component('input::select')
                                            @slot('id', 'currency')
                                            @slot('text', 'Currency')
                                            @slot('name', 'currency')
                                            @slot('id_error', 'currency')
                                            @endcomponent
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="form-control-label">
                                                Exchange Rate <span id="requi" class="requi" style="font-weight: bold;color:red">
                                                    *
                                                </span>
                                            </label>

                                            @component('frontend.common.input.input')
                                                @slot('id', 'exchange_rate1111')
                                                @slot('text', 'exchange_rate1111')
                                                @slot('name', 'exchange_rate1111')
                                            @endcomponent
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="form-control-label">
                                                Director
                                            </label>

                                            @component('frontend.common.input.input')
                                                @slot('id', 'presdir')
                                                @slot('name', 'presdir')
                                                @slot('value', 'Rowin H. Mangkoesoebroto')
                                            @endcomponent
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label class="form-control-label">
                                                Bank Name Information @include('frontend.common.label.required')
                                            </label>

                                            @component('input::select2')
                                                @slot('id', 'bankinfo')
                                                @slot('name', 'bankinfo')
                                                @slot('class', 'bankinfo')
                                                @slot('text', 'Bank Name Information')
                                                @slot('multiple','multiple')
                                                @slot('id_error', 'bankinfo')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group m-form__group row">
                                        <div id="saveheader" class="col-sm-12 col-md-12 col-lg-12 footer">
                                            <div class="flex">
                                                <div class="action-buttons">
                                                    @component('frontend.common.buttons.submit')
                                                    @slot('type','button')
                                                    @slot('id', 'add-invoice')
                                                    @slot('class', 'add-invoice')
                                                    @endcomponent

                                                    @include('frontend.common.buttons.reset')

                                                    @include('frontend.common.buttons.back')
                                                </div>
                                            </div>
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

@include('invoiceview::refquomodal')
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
    <script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{ asset('js/frontend/functions/datepicker/date.js')}}"></script>
    <script src="{{ asset('js/frontend/functions/select2/ref.js') }}"></script>
    <script src="{{ asset('js/frontend/functions/select2/phone.js') }}"></script>
    <script src="{{ asset('js/frontend/functions/select2/email.js') }}"></script>
    <script src="{{ asset('js/frontend/functions/select2/fax.js') }}"></script>
    <script src="{{ asset('js/frontend/functions/select2/attn.js') }}"></script>
    <script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/currencyfa.js')}}"></script>
    <script src="{{ asset('vendor/courier/frontend/functions/select2/bank.js') }}"></script>
    <script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/bank.js') }}"></script>

    <script src="{{ asset('vendor/courier/frontend/invoice/refquomodal-invoice.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            let _url = window.location.origin;

            $('body').on('change', '#currency', function() {
                let val = $(this).val();

                if (val == 'idr') {
                    $('#exchange_rate1111').val(1);
                    $('#exchange_rate1111').attr('disabled', 'disabled');
                }
            });
        });
    </script>
@endpush
{{--
<div hidden id="quotation-sales">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="m-portlet__head">
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active" data-toggle="tab" id="m_tab_6_1_1" href="#m_tabs_6_1_1" role="tab">
                            <i class="la la-cog"></i> Item List
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" id="m_tab_6_2_2" href="#m_tabs_6_2_2" role="tab">
                            <i class="la la-briefcase"></i> Additional Info
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" id="m_tab_6_3_3" href="#m_tabs_6_3_3" role="tab">
                            <i class="la la-briefcase"></i> Account/Profit Center
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="tab-content">
            <div class="tab-pane active" id="m_tabs_6_1_1" role="tabpanel">
                @include('invoice-itemlistview::index')
            </div>
            <div class="tab-pane" id="m_tabs_6_2_2" role="tabpanel">
                @include('invoice-additionalview::index')
            </div>
            <div class="tab-pane" id="m_tabs_6_3_3" role="tabpanel">
                @include('invoice-apcview::index')
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="form-group m-form__group row">
                <div id="saveheader" class="col-sm-12 col-md-12 col-lg-12 footer">
                    <div class="flex">
                        <div class="action-buttons">
                            @component('buttons::submit')
                                @slot('text', 'Print')
                                @slot('icon', 'fa-print')
                                @slot('color', 'primary')
                            @endcomponent

                            @component('frontend.common.buttons.submit')
                                @slot('type','button')
                                @slot('id', 'add-invoice-sales')
                                @slot('class', 'add-invoice-sales')
                            @endcomponent

                            @include('frontend.common.buttons.reset')

                            @include('frontend.common.buttons.back')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
