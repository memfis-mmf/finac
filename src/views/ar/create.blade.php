@extends('frontend.master')

@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Account Receivable
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
                            Account Receivable
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
                                Account Receivable
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
                                        {{csrf_field()}}
                                        <label class="form-control-label">
                                            Customer @include('label::required')
                                        </label>

                                        @component('input::select2')
                                        @slot('id', 'customer')
                                        @slot('text', 'customer')
                                        @slot('name', 'customer')
                                        @slot('id_error', 'customer')
                                        @slot('help_text','Customer')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Customer Account Code
                                        </label>

                                        @component('input::inputreadonly')
                                        @slot('id', 'customerac')
                                        @slot('text', 'customerac')
                                        @slot('name', 'customerac')
                                        @slot('help_text','Customer Account Code')
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
                                    <div class="col-sm-6 col-md-6 col-lg-6">


                                        <label class="form-control-label">
                                            Currency @include('frontend.common.label.required')
                                        </label>

                                        @component('input::select2')
                                        @slot('id', 'currency')
                                        @slot('text', 'Currency')
                                        @slot('name', 'currency')
                                        @slot('id_error', 'currency')
                                        @endcomponent

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
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="action-buttons">
                                            @component('buttons::submit')
                                            @slot('type', 'button')
                                            @slot('id','arsave')
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
<script src="{{ asset('vendor/courier/frontend/functions/reset.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/coa.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/select2/customer.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/customer.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/select2/currency.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/currencyfa.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/datepicker/date.js')}}"></script>


<script src="{{ asset('vendor/courier/frontend/coamodal.js')}}"></script>
<script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>

<script>
    //Customer Onchange
    $('#customer').change(function() {
        var uuid_cust = $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'get',
            url: '/customerfa/' + uuid_cust,
            data: {

            },
            success: function(data) {
                if (data.errors) {
                    if (data.errors.code) {

                    }
                } else {
                    console.log(data);
                    $("#customerac").val(data.name);
                    $("#customerac").attr("uuid", data.uuid);
                }
            }
        });
    });

    //Create Account Receiveable
    let simpan = $('.action-buttons').on('click', '#arsave', function() {
        $('#simpan').text('Simpan');

        let date = $('#date').val();
        let refno = $('#refno').val();
        let customer = $('#customer').find(":selected").text();;
        let coa = $('#coa').val();
        let currency = $('#currency').find(":selected").text();;
        let exchangerate = $('#exchange').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/ar',
            data: {
                _token: $('input[name=_token]').val(),
                date: date,
                refno: refno,
                customer: customer,
                coa: coa,
                currency: currency,
                exchangerate: exchangerate
            },
            success: function(data) {
                if (data.errors) {
                    if (data.errors.code) {
                        /*
                        $('#code-error').html(data.errors.code[0]);


                        document.getElementById('code').value = code;
                        document.getElementById('name').value = name;
                        document.getElementById('type').value = type;
                        document.getElementById('level').value = level;
                        document.getElementById('description').value = description;
                        //coa_reset();
                        */
                    }


                } else {
                    //$('#modal_coa').modal('hide');
                    console.log(data.uuid);
                    toastr.success('Data berhasil disimpan.', 'Sukses', {
                        timeOut: 5000
                    });
                    window.location.replace("/ar/"+data.uuid+"/edit");

                    //$('#code-error').html('');

                    //let table = $('.coa_datatable').mDatatable();
                    //coa_reset();
                    //table.originalDataSet = [];
                    //table.reload();
                }
            }
        });
    });
</script>
@endpush