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
                                                        <label class="form-control-label">
                                                            Ref Quotation No. @include('frontend.common.label.required')
                                                        </label>

                                                        @component('input::inputrightbutton')
                                                        @slot('text', 'Ref Quotation No')
                                                        @slot('id', 'refquono')
                                                        @slot('name', 'refquono')
                                                        @slot('id_error', 'refquono')
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

                                                                            @component('frontend.common.label.data-info')
                                                                            @slot('text', 'XXX')
                                                                            @slot('id', 'name')
                                                                            @endcomponent
                                                                        </div>
                                                                        <br/>
                                                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                                                        <br/>
                                                                            <label class="form-control-label">
                                                                                Level
                                                                            </label>

                                                                            @component('frontend.common.input.input')
                                                                            @slot('text', '')
                                                                            @slot('id', 'level')
                                                                            @slot('name', 'level')
                                                                            @endcomponent
                                                                        </div>
                                                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                                                        <br/>
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

                                                        @component('frontend.common.input.datepicker')
                                                        @slot('id', 'date')
                                                        @slot('text', 'Date')
                                                        @slot('name', 'date')
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

                                                        @component('frontend.common.input.select2')
                                                        @slot('id', 'currency')
                                                        @slot('text', 'Currency')
                                                        @slot('name', 'currency')
                                                        @slot('id_error', 'currency')
                                                        @endcomponent
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <br/>
                                                        <label class="form-control-label">
                                                            Exchange Rate @include('frontend.common.label.required')
                                                        </label>

                                                        @component('frontend.common.input.number')
                                                        @slot('text', 'exchange')
                                                        @slot('name', 'exchange')
                                                        @slot('id_error', 'exchange')
                                                        @slot('id', 'exchange')
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
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Account Code @include('frontend.common.label.required')
                                        </label>

                                        @component('input::inputrightbutton')
                                        @slot('rows', '5')
                                        @slot('id', 'coa')
                                        @slot('name', 'coa')
                                        @slot('text', 'Account Code')
                                        @slot('id_error', 'coa')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
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
                                
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12 col-md-12 col-lg-12 footer">
                                        <div class="flex">
                                            <div class="action-buttons">
                                                @component('frontend.common.buttons.submit')
                                                @slot('type','button')
                                                @slot('id', 'add-quotation')
                                                @slot('class', 'add-quotation')
                                                @endcomponent

                                                @include('frontend.common.buttons.reset')

                                                @include('frontend.common.buttons.back')
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
</script>
<script src="{{ asset('js/frontend/functions/repeater-core.js') }}"></script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ $browser_key }}&callback=initMap"></script>

<script src="{{ asset('js/frontend/functions/select2/customer.js') }}"></script>
{{-- <script src="{{ asset('js/frontend/functions/fill-combobox/customer.js') }}"></script> --}}

<script src="{{ asset('js/frontend/functions/select2/currency.js') }}"></script>
<script src="{{ asset('js/frontend/functions/fill-combobox/currency.js') }}"></script>


<script src="{{ asset('js/frontend/functions/select2/ref.js') }}"></script>
<script src="{{ asset('js/frontend/functions/select2/phone.js') }}"></script>
<script src="{{ asset('js/frontend/functions/select2/email.js') }}"></script>
<script src="{{ asset('js/frontend/functions/select2/fax.js') }}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/select2/bank.js') }}"></script>
<script src="{{ asset('js/frontend/functions/select2/address.js') }}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/select2/city.js') }}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/select2/country.js') }}"></script>
<script src="{{ asset('js/frontend/functions/select2/attn.js') }}"></script>

<script src="{{ asset('js/frontend/quotation/form-reset.js') }}"></script>
<script src="{{ asset('js/frontend/functions/datepicker/date.js')}}"></script>
<script src="{{ asset('js/frontend/quotation/workpackage.js') }}"></script>
<script src="{{ asset('js/frontend/quotation/create.js') }}"></script>
<script src="{{ asset('js/frontend/quotation/repeater.js') }}"></script>


@endpush