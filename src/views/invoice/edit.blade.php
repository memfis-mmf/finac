@extends('frontend.master')

@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Invoice
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
                            Invoice
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
                                Invoice
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <form id="itemform" name="itemform">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group m-form__group row">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group m-form__group row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <input hidden id="customerid">
                                                        <input hidden id="projectuuid">
                                                        <label class="form-control-label">
                                                            Ref Quotation No. @include('frontend.common.label.required')
                                                        </label>

                                                        @component('input::inputreadonly')
                                                        @slot('text', 'Ref Quotation No')
                                                        @slot('id', 'refquono')
                                                        @slot('data_target', '#refquo_modal')
                                                        @slot('name', 'refquono')
                                                        @slot('id_error', 'refquono')
                                                        @slot('value', "{$quotation->number}")
                                                        @endcomponent
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="form-group m-form__group row">
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
                                                                        <br />
                                                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                                                            <br />
                                                                            <label class="form-control-label">
                                                                                Level
                                                                            </label>

                                                                            @component('input::inputreadonly')
                                                                            @slot('text', '')
                                                                            @slot('id', 'level')
                                                                            @slot('name', 'level')
                                                                            @endcomponent
                                                                        </div>
                                                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                                                            <br />
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

                                                                            @component('frontend.common.input.select2')
                                                                            @slot('text', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi, nulla odio consequuntur obcaecati eos error recusandae minima eveniet dolor sed tempora! Ut quidem illum accusantium expedita nulla eos reprehenderit officiis?')
                                                                            @slot('id', 'address')
                                                                            @slot('name', 'address')
                                                                            @endcomponent
                                                                        </div>
                                                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                                                            <label class="form-control-label">
                                                                                City
                                                                            </label>

                                                                            @component('frontend.common.input.select2')
                                                                            @slot('text', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi, nulla odio consequuntur obcaecati eos error recusandae minima eveniet dolor sed tempora! Ut quidem illum accusantium expedita nulla eos reprehenderit officiis?')
                                                                            @slot('id', 'city')
                                                                            @slot('name', 'city')
                                                                            @endcomponent
                                                                        </div>
                                                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                                                            <label class="form-control-label">
                                                                                Country
                                                                            </label>

                                                                            @component('frontend.common.input.select2')
                                                                            @slot('text', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi, nulla odio consequuntur obcaecati eos error recusandae minima eveniet dolor sed tempora! Ut quidem illum accusantium expedita nulla eos reprehenderit officiis?')
                                                                            @slot('id', 'country')
                                                                            @slot('name', 'country')
                                                                            @endcomponent
                                                                        </div>
                                                                    </div>
                                                                    <div id="map"></div>

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
                                                <div class="form-group m-form__group row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <label class="form-control-label">
                                                            Date @include('frontend.common.label.required')
                                                        </label>

                                                        @component('input::inputreadonly')
                                                        @slot('id', 'date')
                                                        @slot('text', 'Date')
                                                        @slot('name', 'date')
                                                        @slot('value', $today)
                                                        @slot('id_error','requested_at')
                                                        @endcomponent
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group m-form__group row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <label class="form-control-label">
                                                            Currency @include('frontend.common.label.required')
                                                        </label>

                                                        @component('input::inputreadonly')
                                                        @slot('id', 'currency')
                                                        @slot('text', 'Currency')
                                                        @slot('name', 'currency')
                                                        @slot('id_error', 'currency')
                                                        @endcomponent
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <br />
                                                        <label class="form-control-label">
                                                            Exchange Rate <span id="requi" class="requi" style="font-weight: bold;color:red">

                                                                *

                                                            </span>
                                                        </label>

                                                        @component('input::numberreadonly')
                                                        @slot('id', 'exchange_rate1111')
                                                        @slot('text', 'exchange_rate1111')
                                                        @slot('name', 'exchange_rate1111')
                                                        @endcomponent
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <br />
                                                        <label class="form-control-label">
                                                            President Director
                                                        </label>

                                                        @component('frontend.common.input.input')
                                                        @slot('id', 'pdir')
                                                        @slot('name', 'pdir')
                                                        @slot('value', 'Rowin H. Mangkoesoebroto')
                                                        @endcomponent
                                                    </div>


                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Bank Name Information @include('frontend.common.label.required')
                                        </label>

                                        @component('input::select2')
                                        @slot('id', 'bankinfo')
                                        @slot('name', 'bankinfo')
                                        @slot('text', 'Bank Name Information')
                                        @slot('id_error', 'bankinfo')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div hidden id="bai_header">
                                            <label class="form-control-label">
                                                Bank Account Information
                                            </label>

                                            @component('input::inputreadonly')
                                            @slot('id', 'bai')
                                            @slot('name', 'bai')
                                            @slot('text', 'Bank Account Information')
                                            @slot('id_error', 'bankaccount')
                                            @endcomponent
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <br />
                                        <label class="form-control-label">
                                            Account Code @include('frontend.common.label.required')
                                        </label>

                                        @component('input::inputrightbutton')
                                        @slot('rows', '5')
                                        @slot('id', 'coa')
                                        @slot('name', 'coa')
                                        @slot('data_target', '#coa_modal')

                                        @slot('text', 'Account Code')
                                        @slot('id_error', 'coa')
                                        @slot('value', "{$coa->code}")
                                        @endcomponent
                                    </div>

                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div id="acd_header">
                                            <br />
                                            <label class="form-control-label">
                                                Account Code Description
                                            </label>

                                            @component('input::inputreadonly')
                                            @slot('id', 'acd')
                                            @slot('name', 'acd')
                                            @slot('text', 'Account Code Description')
                                            @slot('id_error', 'acd')
                                            @slot('value', "{$coa->description}")
                                            @endcomponent
                                        </div>
                                    </div>


                                </div>




                                <br />
                                <br />
                                <div id="hiddennext">
                                    <center>
                                        <h3 id="subjectquo">Subject</h3>
                                    </center>
                                    <br />
                                    <div class="summary_datatable" id="scrolling_both"></div>
                                    <br>
                                    <hr>

                                    <div class="form-group m-form__group row">
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-3 col-md-3 col-lg-3">
                                                    <div class="m--align-left" style="padding-top:15px">
                                                        PPH
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 col-md-2 col-lg-2">
                                                    @component('input::input')
                                                    @slot('id', 'pph')
                                                    @slot('class', 'pph')
                                                    @slot('text', '')
                                                    @slot('value', '')
                                                    @endcomponent
                                                </div>
                                                %
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    @component('input::inputreadonly')
                                                    @slot('id', 'percent')
                                                    @slot('class', 'percent')
                                                    @slot('text', '')
                                                    @slot('value', '')
                                                    @endcomponent
                                                </div>
                                                <div class="col-sm-1 col-md-1 col-lg-1">
                                                </div>
                                                <div class="col-sm-1 col-md-1 col-lg-1">
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-12 col-md-12 col-lg-12">
                                                    <fieldset class="border p-2">
                                                        <legend class="w-auto">Scheduled Payment :</legend>

                                                        <table id="scheduled_payments_datatables" class="table table-striped table-bordered" width="80%">
                                                            <tfoot>
                                                                <th></th>
                                                                <th></th>
                                                                <th colspan="2"></th>
                                                            </tfoot>
                                                        </table>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-3 col-md-3 col-lg-3">
                                                    <div class="m--align-left" style="padding-top:15px">
                                                        Freemark
                                                    </div>
                                                </div>
                                                <div class="col-sm-9 col-md-9 col-lg-9">
                                                    @component('input::textarea')
                                                    @slot('id', 'desc')
                                                    @slot('class', 'desc')
                                                    @slot('text', '')
                                                    @slot('value', "{$invoice->description}")
                                                    @endcomponent
                                                </div>
                                                <div class="col-sm-1 col-md-1 col-lg-1">
                                                </div>
                                                <div class="col-sm-1 col-md-1 col-lg-1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-3 col-md-3 col-lg-3">
                                                    <div>
                                                        Sub Total
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    @component('input::inputreadonly')
                                                    @slot('id', 'sub_total')
                                                    @slot('class', 'sub_total')
                                                    @slot('text', '')
                                                    @slot('value', '')
                                                    @endcomponent
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-3 col-md-3 col-lg-3">
                                                    <div>
                                                        Total Discount
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    @component('input::inputreadonly')
                                                    @slot('id', 'total_discount')
                                                    @slot('class', 'total_discount')
                                                    @slot('text', '0')
                                                    @slot('value', '0')
                                                    @endcomponent
                                                </div>

                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-3 col-md-3 col-lg-3">
                                                    <div>
                                                        Tax 10%
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    @component('input::inputreadonly')
                                                    @slot('id', 'tax')
                                                    @slot('class', 'tax')
                                                    @slot('text', '')
                                                    @slot('value', '')
                                                    @endcomponent
                                                </div>
                                            </div>
                                            <div class="append-other">

                                            </div>

                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-3 col-md-3 col-lg-3">
                                                    <div>
                                                        Grand Total
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    @component('input::inputreadonly')
                                                    @slot('id', 'grand_total')
                                                    @slot('class', 'grand_total')
                                                    @slot('text', '')
                                                    @slot('value', '')
                                                    @endcomponent
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-3 col-md-3 col-lg-3">
                                                    <div>
                                                        Grand Total Rupiah
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    @component('input::inputreadonly')
                                                    @slot('id', 'grand_totalrp')
                                                    @slot('class', 'grand_totalrp')
                                                    @slot('text', '')
                                                    @slot('value', '')
                                                    @endcomponent
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group m-form__group row">
                                                <div id="saveheader" class="col-sm-12 col-md-12 col-lg-12 footer">
                                                    <div class="flex">
                                                        <div class="action-buttons">
                                                            @component('frontend.common.buttons.submit')
                                                            @slot('type','button')
                                                            @slot('id', 'edit-invoice')
                                                            @slot('class', 'edit-invoice')
                                                            @endcomponent

                                                            @include('frontend.common.buttons.reset')

                                                            @include('frontend.common.buttons.back')
                                                        </div>
                                                    </div>
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
@include('cashbookview::coamodal')
@include('invoiceview::refquomodal')
@endsection

@push('header-scripts')
<style>
    #map {
        height: 200px;
    }
</style>
<style>
    fieldset {
        margin-bottom: 30px;
    }

    .padding-datatable {
        padding: 0px
    }

    .margin-info {
        margin-left: 5px
    }
</style>
@endpush
@push('footer-scripts')

<script type="text/javascript">
    $("#type_website").on('change', function() {});
    let simpan = $('.tes').on('click', '.save', function() {
        var usertype = [];
        $("select[name=project]").each(function() {
            usertype.push($(this).val());
            // alert($(this).val());
        });
        var ajaxdata = {
            "UserType": usertype
        };

        console.log(JSON.stringify(ajaxdata));
    });
</script>
<script>
    function initMap() {
        var myLatLng = {
            lat: -7.265757,
            lng: 112.734146
        };

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: myLatLng
        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Hello World!'
        });
    }
    let currencyCode = "{{$currencycode->code}}";
    var others_data = "";
    var customers = "";
    var attention = "";
    var atten_array = {};
    let invoice_uuid = "{{$invoice->uuid}}";
    var currency = "";
    var uuidquo = "";
    var tipetax = "";
    var tax = 0;
    var subtotal = 0;
    let quotation_uuid = "{{$quotation->uuid}}";
    let other_total = 0;
    let schedule_payment = "";
    let grand_total1 = 0;
    let convertidr = 0;
    let dataSchedule = "{{$quotation->scheduled_payment_amount}}";
    let dataScheduleClear = JSON.parse(dataSchedule.replace(/&quot;/g, '"'));
    let locale = 'id';
    let IDRformatter = new Intl.NumberFormat(locale, {
        style: 'currency',
        currency: 'idr',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    let ForeignFormatter = new Intl.NumberFormat(locale, {
        style: 'currency',
        currency: currencyCode,
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
</script>
<script src="{{ asset('js/frontend/functions/repeater-core.js') }}"></script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ $browser_key }}&callback=initMap"></script>

<script src="{{ asset('js/frontend/functions/select2/customer.js') }}"></script>
{{-- <script src="{{ asset('js/frontend/functions/fill-combobox/customer.js') }}"></script> --}}

<!--<script src="{{ asset('vendor/courier/frontend/functions/select2/currency.js') }}"></script>-->
<!--<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/currencyfa.js') }}"></script>-->
<script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>
<script>
    $(document).ready(function() {
        let currencyCode = "{{$currencycode->code}}";
        var others_data = "";
        var customers = "";
        var attention = "";
        var atten_array = {};
        var currency = "";
        var uuidquo = "";
        var tipetax = "";
        var tax = 0;
        var subtotal = 0;
        let quotation_uuid = "{{$quotation->uuid}}";
        let other_total = 0;
        let dataSchedule = "{{$quotation->scheduled_payment_amount}}";
        let dataScheduleClear = JSON.parse(dataSchedule.replace(/&quot;/g, '"'));
        let grand_total1 = 0;
        let convertidr = 0;
        $('select[name="attention"]').append(
            '<option value=""> Select a Attention</option>'
        );
        //console.log(quotation_uuid);
        $.ajax({
            url: '/invoice/quotation/datatables/modal/' + quotation_uuid + '/detail',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                customers = JSON.parse(data.customer);
                attention = JSON.parse(customers.attention);
                currency = data.currency;
                var levels = customers.levels[0];
                $.each(attention, function(i, attention) {
                    atten_array[i] = attention.name;
                });
                $('#attention').empty();
                $("#name").val(customers.name);
                $("#level").val(levels.name);
                $("#refquono").val(data.number);
                $("#currency").val(currency.name);

                $("h3#subjectquo").html("Subject : " + data.title);
                currencyCode = currency.code;
                if (currency.code != "idr") {
                    $("#exchange_rate1111").attr("readonly", false);
                }

                $("#exchange_rate1111").val(data.exchange_rate);
                $('select[name="attention"]').append(
                    '<option value=""> Select a Attention</option>'
                );
                $.each(window.atten_array, function(key, value) {
                    $('select[name="attention"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
                //$("#refquono").data("uuid", code);
                //console.log(code);
                //$('#refquo_modal').modal('hide');
            }
        });
    });
</script>

<script src="{{ asset('js/frontend/functions/select2/ref.js') }}"></script>
<script src="{{ asset('js/frontend/functions/select2/phone.js') }}"></script>
<script src="{{ asset('js/frontend/functions/select2/email.js') }}"></script>
<script src="{{ asset('js/frontend/functions/select2/fax.js') }}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/select2/bank.js') }}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/bank.js') }}"></script>
<script src="{{ asset('js/frontend/functions/select2/address.js') }}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/select2/city.js') }}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/select2/country.js') }}"></script>
<script src="{{ asset('js/frontend/functions/select2/attn.js') }}"></script>

<script src="{{ asset('js/frontend/quotation/form-reset.js') }}"></script>
<!--<script src="{{ asset('js/frontend/functions/datepicker/date.js')}}"></script>-->
<!--<script src="{{ asset('js/frontend/quotation/workpackage.js') }}"></script>-->
<script src="{{ asset('js/frontend/quotation/create.js') }}"></script>
<!--<script src="{{ asset('js/frontend/quotation/repeater.js') }}"></script>-->
<!--<script src="{{ asset('js/custom.js') }}"></script>-->
<script src="{{ asset('vendor/courier/frontend/invoice/coamodal-invoice.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/invoice/tableshow.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/invoice/refquomodal-invoice.js')}}"></script>
<script>
    let scheduled_payments11 = {
        init: function() {
            let scheduled_payment_datatable = $('#scheduled_payments_datatables').DataTable({
                data: dataScheduleClear,
                columns: [{
                        title: "Work Progress(%)",
                        data: "work_progress",
                        "render": function(data, type, row, meta) {
                            return data + "%";
                        }
                    },
                    {
                        title: "Amount",
                        data: "amount",
                        "render": function(data, type, row, meta) {
                            return ForeignFormatter.format(data);
                        }
                    },
                    {
                        title: "Amount(%)",
                        data: "amount_percentage",
                        "render": function(data, type, row, meta) {
                            return data + "%";
                        }
                    },
                    {
                        title: "Description",
                        data: "description"
                    }
                ],
                searching: false,
                paging: false,
                info: false,
                footer: true,
                "footerCallback": function(row, data, start, end, display) {

                    var api = this.api();
                    api.columns('0', {
                        page: 'current'
                    }).every(function() {
                        var sum = this.data();
                        let arr_work_progress = sum.join();
                        let max = arr_work_progress.split(",");
                        Array.prototype.max = function() {
                            return Math.max.apply(null, this);
                        };
                        $(api.column(0).footer()).html("Work Progress : " + max.max() + "%");
                    });
                    api.columns('1', {
                        page: 'current'
                    }).every(function() {
                        var sum = this
                            .data()
                            .reduce(function(a, b) {
                                var x = parseFloat(a) || 0;
                                var y = parseFloat(b) || 0;
                                return x + y;
                            }, 0);
                        $(api.column(1).footer()).html("Total Amount : " + ForeignFormatter.format(sum));
                    });

                    api.columns('2', {
                        page: 'current'
                    }).every(function() {
                        var sum = this
                            .data()
                            .reduce(function(a, b) {
                                var x = parseFloat(a) || 0;
                                var y = parseFloat(b) || 0;
                                return x + y;
                            }, 0);
                        $(api.column(2).footer()).html("Total Amount : " + sum + "%");
                    });

                }

            });

            $('.add_scheduled_row').on('click', function() {
                $("#work_progress_scheduled-error").html('');
                $("#amount_scheduled-error").html('');
                $("#work_progress_scheduled").removeClass('is-invalid');
                $("#amount_scheduled").removeClass('is-invalid');
                let total = $('#grand_total').attr('value');
                let work_progress_scheduled = $("#work_progress_scheduled").val();
                let amount_scheduled = $("#amount_scheduled").val();
                let description_scheduled = $("#description_scheduled").val();
                let amount_scheduled_percentage = (amount_scheduled / total) * 100;
                let sub_total = calculate_amount();
                let max = calculate_progress();
                let remaining = total - sub_total;
                if (work_progress_scheduled < max) {
                    $("#work_progress_scheduled-error").html('Work progess precentage cannot lower than ' + max + '%');
                    $("#work_progress_scheduled").addClass('is-invalid');
                } else if (work_progress_scheduled > 100) {
                    $("#work_progress_scheduled-error").html('Work progess precentage cannot exceed 100%');
                    $("#work_progress_scheduled").addClass('is-invalid');
                    return;
                } else if (parseInt(amount_scheduled) > parseInt(total)) {
                    $("#amount_scheduled-error").html('Amount inserted cannot exceed remaining ' + ForeignFormatter.format(remaining) + ' of total');
                    $("#amount_scheduled").addClass('is-invalid');
                    return;
                } else {
                    let newRow = [];
                    newRow["description"] = description_scheduled;
                    newRow["work_progress"] = work_progress_scheduled;
                    newRow["amount"] = amount_scheduled;
                    newRow["amount_percentage"] = amount_scheduled_percentage;
                    scheduled_payment_datatable
                        .row.add(newRow)
                        .draw();

                    $("#work_progress_scheduled").val(0);
                    $("#amount_scheduled").val(0);
                    $("#description_scheduled").val("");
                }
            });

            $('#scheduled_payments_datatables tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    scheduled_payment_datatable.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });

            $('.delete_row').on('click', function() {
                scheduled_payment_datatable.row('.selected').remove().draw(false);
            });

            // calculate amount
            function calculate_amount() {
                let scheduled_payment_datatable = $('#scheduled_payments_datatables').DataTable();
                let total = scheduled_payment_datatable.column(1).data().reduce(function(a, b) {
                    var x = parseFloat(a) || 0;
                    var y = parseFloat(b) || 0;
                    return x + y;
                }, 0);

                return total;
            }

            // calculate progress
            function calculate_progress() {
                let scheduled_payment_datatable = $('#scheduled_payments_datatables').DataTable();
                let arrays = scheduled_payment_datatable.column(0).data();
                let max = Math.max(arrays.join());
                return max;
            }
        }
    };

    jQuery(document).ready(function() {
        scheduled_payments11.init();
    });
</script>

@endpush