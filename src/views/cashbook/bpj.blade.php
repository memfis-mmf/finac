@extends('frontend::master')

@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Cashbook - Bank Payment Journal
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
                            Cashbook - Bank Payment Journal
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
                                Cashbook - Bank Payment Journal
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
                                            Bank Payment Journal No.
                                        </label>
                                        @component('input::inputreadonly')
                                        @slot('id', 'bpjno')
                                        @slot('text', 'bpjno')
                                        @slot('name', 'bpjno')
                                        @slot('value', $cashbookno)
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
                                            Ref No
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

                                        <select id="currency" name="currency" class="form-control m-input">
                                            <option value=""> Select a Currency</option>
                                            <option value="IDR">
                                                IDR
                                            </option>
                                            <option value="USD">
                                                USD
                                            </option>

                                        </select>

                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Exchange Rate
                                            <span id="requi" class="requi" style="font-weight: bold;color:red">

                                                *

                                            </span>
                                        </label>


                                        @component('input::numberreadonly')
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
                                            Account Code
                                        </label>

                                        @component('input::inputrightbutton')
                                        @slot('id', 'coa')
                                        @slot('text', 'coa')
                                        @slot('name', 'coa')
                                        @slot('type', 'text')
                                        @slot('style', 'width:100%')
                                        @slot('help_text','Account Code')
                                        @slot('data_target', '#coa_modal')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Account Code Description
                                        </label>

                                        @component('input::inputreadonly')
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
                                            Remark
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
                                        <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                                            <div class="row align-items-center">
                                                <div class="col-xl-12">

                                                    <h3>Adjustment 1</h3>
                                                </div>
                                            </div>
                                        </div>



                                        <!--<div class="cashbookadj1_datatable" id="scrolling_both"></div>-->
                                        <!--begin: Datatable -->
                                        <div class="cashbookadj1_datatable" id="local_data"></div>
                                        <!--end: Datatable -->

                                    </div>
                                </div>

                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                                            <div class="row align-items-center">
                                                <div class="col-xl-12">

                                                    <h3>Adjustment 2</h3>
                                                </div>
                                            </div>
                                        </div>

                                        @include('cashbookview::adj1')
                                        @include('cashbookview::adj2')
                                        @include('cashbookview::adj3')

                                        <div class="cashbookadj2_datatable" id="scrolling_both"></div>
                                    </div>
                                </div>


                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                                            <div class="row">
                                                <div class="col-xl-12">

                                                    <h3>Adjustment 3</h3>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="cashbookadj3_datatable" id="scrolling_both"></div>
                                    </div>
                                </div>


                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="action-buttons">
                                            @component('buttons::submit')
                                            @slot('type', 'button')
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
<script src="{{ asset('vendor/courier/frontend/functions/reset.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/coa.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/datepicker/date.js')}}"></script>


<script src="{{ asset('vendor/courier/frontend/cashbookbpj.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/cashbookadj1.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/cashbookadj2.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/cashbookadj3.js')}}"></script>


<script src="{{ asset('vendor/courier/frontend/coamodal.js')}}"></script>
<script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>

<script>
    var currency_choose = "";

    function curformat(val, id) {
        var num = val;
        var output = parseFloat(num).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        document.getElementById(id).value = output;
    }

    function exchangerateadj2(val, id) {

        uniquecode = id.substring(8);
        subunique = "exchangerate" + uniquecode;
        console.log(subunique);
        if (val != "IDR") {
            document.getElementById(subunique).value = '';
        } else {
            document.getElementById(subunique).value = '1';
        }
    }
    jQuery(document).ready(function() {
        $('#currency').on('change', function() {
            currency_choose = this.value;
            if (this.value != "IDR") {
                $("#exchange").attr("readonly", false);
                document.getElementById("requi").style.display = "block";

            } else {
                document.getElementById('exchange').value = '1';
                $("#exchange").attr("readonly", true);
                document.getElementById("requi").style.display = "none";

            }
        });
    });
</script>
@endpush