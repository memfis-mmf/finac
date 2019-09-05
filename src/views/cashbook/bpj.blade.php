@extends('frontend.master')

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
                                            <option value="46">
                                                IDR
                                            </option>
                                            <option value="103">
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

                                                    <h3>Adjustment 1</h3>
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

                                                    <h3>Adjustment 2</h3>
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
                                            @slot('id','savebpj')
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
<input hidden id="idcodeadj1-1">
<input hidden id="idcodeadj1-2">
<input hidden id="idcodeadj1-3">
<input hidden id="idcodeadj1-4">
<input hidden id="idcodeadj1-5">
<input hidden id="idcodeadj1-6">
<input hidden id="idcodeadj1-7">
<input hidden id="idcodeadj1-8">
<input hidden id="idcodeadj1-9">
<input hidden id="idcodeadj1-10">
<input hidden id="idcodeadj2-1">
<input hidden id="idcodeadj2-2">
<input hidden id="idcodeadj2-3">
<input hidden id="idcodeadj2-4">
<input hidden id="idcodeadj2-5">
<input hidden id="idcodeadj2-6">
<input hidden id="idcodeadj2-7">
<input hidden id="idcodeadj2-8">
<input hidden id="idcodeadj2-9">
<input hidden id="idcodeadj2-10">
<input hidden id="idcodeadj3-1">
<input hidden id="idcodeadj3-2">
<input hidden id="idcodeadj3-3">
<input hidden id="idcodeadj3-4">
<input hidden id="idcodeadj3-5">
<input hidden id="idcodeadj3-6">
<input hidden id="idcodeadj3-7">
<input hidden id="idcodeadj3-8">
<input hidden id="idcodeadj3-9">
<input hidden id="idcodeadj3-10">

@endsection

@push('footer-scripts')
<script src="{{ asset('vendor/courier/frontend/functions/reset.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/coa.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/datepicker/date.js')}}"></script>


<script src="{{ asset('vendor/courier/frontend/cashbookbpj.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/cashbookadj1-pay.js')}}"></script>
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
        if (val != "46") {
            document.getElementById(subunique).value = '';
        } else {
            document.getElementById(subunique).value = '1';
        }
    }
    jQuery(document).ready(function() {
        var currency = "";
        $('#currency').on('change', function() {
            currency_choose = this.value;
            currency = this.value;
            if (this.value != "46") {
                $("#exchange").attr("readonly", false);
                document.getElementById("requi").style.display = "block";

            } else {
                document.getElementById('exchange').value = '1';
                $("#exchange").attr("readonly", true);
                document.getElementById("requi").style.display = "none";

            }
        });
        let simpan = $('#savebpj').click(function() {
            var header = [
                document.getElementById("bpjno").value,
                document.getElementById("date").value,
                document.getElementById("pto").value,
                document.getElementById("refno").value,
                currency,
                document.getElementById("exchange").value,
                document.getElementById("coaid").value,
                document.getElementById("remark").value,

            ];

            var adj1 = [
                [document.getElementById("idcodeadj1-1").value, document.getElementById("nameadj1-1").value, document.getElementById("debitadj1-1").value, 0, document.getElementById("desriptionadj1-1").value],
                [document.getElementById("idcodeadj1-2").value, document.getElementById("nameadj1-2").value, document.getElementById("debitadj1-2").value, 0, document.getElementById("desriptionadj1-2").value],
                [document.getElementById("idcodeadj1-3").value, document.getElementById("nameadj1-3").value, document.getElementById("debitadj1-3").value, 0, document.getElementById("desriptionadj1-3").value],
                [document.getElementById("idcodeadj1-4").value, document.getElementById("nameadj1-4").value, document.getElementById("debitadj1-4").value, 0, document.getElementById("desriptionadj1-4").value],
                [document.getElementById("idcodeadj1-5").value, document.getElementById("nameadj1-5").value, document.getElementById("debitadj1-5").value, 0, document.getElementById("desriptionadj1-5").value],
                [document.getElementById("idcodeadj1-6").value, document.getElementById("nameadj1-6").value, document.getElementById("debitadj1-6").value, 0, document.getElementById("desriptionadj1-6").value],
                [document.getElementById("idcodeadj1-7").value, document.getElementById("nameadj1-7").value, document.getElementById("debitadj1-7").value, 0, document.getElementById("desriptionadj1-7").value],
                [document.getElementById("idcodeadj1-8").value, document.getElementById("nameadj1-8").value, document.getElementById("debitadj1-8").value, 0, document.getElementById("desriptionadj1-8").value],
                [document.getElementById("idcodeadj1-9").value, document.getElementById("nameadj1-9").value, document.getElementById("debitadj1-9").value, 0, document.getElementById("desriptionadj1-9").value],
                [document.getElementById("idcodeadj1-10").value, document.getElementById("nameadj1-10").value, document.getElementById("debitadj1-10").value, 0, document.getElementById("desriptionadj1-10").value],
            ];


            var e1 = document.getElementById("currencyadj2-1");
            var strUser1 = e1.options[e1.selectedIndex].value;

            var e2 = document.getElementById("currencyadj2-2");
            var strUser2 = e2.options[e2.selectedIndex].value;

            var e3 = document.getElementById("currencyadj2-3");
            var strUser3 = e3.options[e3.selectedIndex].value;

            var e4 = document.getElementById("currencyadj2-4");
            var strUser4 = e4.options[e4.selectedIndex].value;

            var e5 = document.getElementById("currencyadj2-5");
            var strUser5 = e5.options[e5.selectedIndex].value;

            var e6 = document.getElementById("currencyadj2-6");
            var strUser6 = e6.options[e6.selectedIndex].value;

            var e7 = document.getElementById("currencyadj2-7");
            var strUser7 = e7.options[e7.selectedIndex].value;

            var e8 = document.getElementById("currencyadj2-8");
            var strUser8 = e8.options[e8.selectedIndex].value;

            var e9 = document.getElementById("currencyadj2-9");
            var strUser9 = e9.options[e9.selectedIndex].value;

            var e10 = document.getElementById("currencyadj2-10");
            var strUser10 = e10.options[e10.selectedIndex].value;
            
            var adj2 = [
                [document.getElementById("idcodeadj2-1").value, document.getElementById("nameadj2-1").value, strUser1, document.getElementById("exchangerateadj2-1").value, document.getElementById("debitadj2-1").value, document.getElementById("creditadj2-1").value, document.getElementById("desriptionadj2-1").value],
                [document.getElementById("idcodeadj2-2").value, document.getElementById("nameadj2-2").value, strUser2, document.getElementById("exchangerateadj2-2").value, document.getElementById("debitadj2-2").value, document.getElementById("creditadj2-2").value, document.getElementById("desriptionadj2-2").value],
                [document.getElementById("idcodeadj2-3").value, document.getElementById("nameadj2-3").value, strUser3, document.getElementById("exchangerateadj2-3").value, document.getElementById("debitadj2-3").value, document.getElementById("creditadj2-3").value, document.getElementById("desriptionadj2-3").value],
                [document.getElementById("idcodeadj2-4").value, document.getElementById("nameadj2-4").value, strUser4, document.getElementById("exchangerateadj2-4").value, document.getElementById("debitadj2-4").value, document.getElementById("creditadj2-4").value, document.getElementById("desriptionadj2-4").value],
                [document.getElementById("idcodeadj2-5").value, document.getElementById("nameadj2-5").value, strUser5, document.getElementById("exchangerateadj2-5").value, document.getElementById("debitadj2-5").value, document.getElementById("creditadj2-5").value, document.getElementById("desriptionadj2-5").value],
                [document.getElementById("idcodeadj2-6").value, document.getElementById("nameadj2-6").value, strUser6, document.getElementById("exchangerateadj2-6").value, document.getElementById("debitadj2-6").value, document.getElementById("creditadj2-6").value, document.getElementById("desriptionadj2-6").value],
                [document.getElementById("idcodeadj2-7").value, document.getElementById("nameadj2-7").value, strUser7, document.getElementById("exchangerateadj2-7").value, document.getElementById("debitadj2-7").value, document.getElementById("creditadj2-7").value, document.getElementById("desriptionadj2-7").value],
                [document.getElementById("idcodeadj2-8").value, document.getElementById("nameadj2-8").value, strUser8, document.getElementById("exchangerateadj2-8").value, document.getElementById("debitadj2-8").value, document.getElementById("creditadj2-8").value, document.getElementById("desriptionadj2-8").value],
                [document.getElementById("idcodeadj2-9").value, document.getElementById("nameadj2-9").value, strUser9, document.getElementById("exchangerateadj2-9").value, document.getElementById("debitadj2-9").value, document.getElementById("creditadj2-9").value, document.getElementById("desriptionadj2-9").value],
                [document.getElementById("idcodeadj2-10").value, document.getElementById("nameadj2-10").value, strUser10, document.getElementById("exchangerateadj2-10").value, document.getElementById("debitadj2-10").value, document.getElementById("creditadj2-10").value, document.getElementById("desriptionadj2-10").value],
            ];

            var adj3 = [
                [document.getElementById("idcodeadj3-1").value, document.getElementById("nameadj3-1").value, document.getElementById("debitadj3-1").value, document.getElementById("creditadj3-1").value, document.getElementById("desriptionadj1-1").value],
                [document.getElementById("idcodeadj3-2").value, document.getElementById("nameadj3-2").value, document.getElementById("debitadj3-2").value, document.getElementById("creditadj3-2").value, document.getElementById("desriptionadj1-2").value],
                [document.getElementById("idcodeadj3-3").value, document.getElementById("nameadj3-3").value, document.getElementById("debitadj3-3").value, document.getElementById("creditadj3-3").value, document.getElementById("desriptionadj1-3").value],
                [document.getElementById("idcodeadj3-4").value, document.getElementById("nameadj3-4").value, document.getElementById("debitadj3-4").value, document.getElementById("creditadj3-4").value, document.getElementById("desriptionadj1-4").value],
                [document.getElementById("idcodeadj3-5").value, document.getElementById("nameadj3-5").value, document.getElementById("debitadj3-5").value, document.getElementById("creditadj3-5").value, document.getElementById("desriptionadj1-5").value],
                [document.getElementById("idcodeadj3-6").value, document.getElementById("nameadj3-6").value, document.getElementById("debitadj3-6").value, document.getElementById("creditadj3-6").value, document.getElementById("desriptionadj1-6").value],
                [document.getElementById("idcodeadj3-7").value, document.getElementById("nameadj3-7").value, document.getElementById("debitadj3-7").value, document.getElementById("creditadj3-7").value, document.getElementById("desriptionadj1-7").value],
                [document.getElementById("idcodeadj3-8").value, document.getElementById("nameadj3-8").value, document.getElementById("debitadj3-8").value, document.getElementById("creditadj3-8").value, document.getElementById("desriptionadj1-8").value],
                [document.getElementById("idcodeadj3-9").value, document.getElementById("nameadj3-9").value, document.getElementById("debitadj3-9").value, document.getElementById("creditadj3-9").value, document.getElementById("desriptionadj1-9").value],
                [document.getElementById("idcodeadj3-10").value, document.getElementById("nameadj3-10").value, document.getElementById("debitadj3-10").value, document.getElementById("creditadj3-10").value, document.getElementById("desriptionadj1-10").value],
            ];

            var obj = {
                'header': {
                    header
                },
                'adj1': {
                    adj1
                },
                'adj2': {
                    adj2
                },
                'adj3': {
                    adj3
                }
            };




            console.log(obj.header);
            console.log(obj.adj1);
            console.log(obj.adj2);
            console.log(obj.adj3);


            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                url: '/cashbook-bpj',
                data: {
                    _token: $('input[name=_token]').val(),
                    data: obj,
                },
                success: function(data) {
                    if (data.errors) {
                        if (data.errors.code) {
                            $('#code-error').html(data.errors.code[0]);


                            document.getElementById('code').value = code;
                            document.getElementById('name').value = name;
                            document.getElementById('type').value = type;
                            document.getElementById('level').value = level;
                            document.getElementById('description').value = description;
                        }


                    } else {
                        $('#modal_coa').modal('hide');

                        toastr.success('Data berhasil disimpan.', 'Sukses', {
                            timeOut: 5000
                        });

                        window.location.replace('{{route("cashbook.index")}}');

                    }
                }
            });
        });
    });
</script>
@endpush