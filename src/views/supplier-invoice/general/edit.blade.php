@extends('frontend.master')

@section('faAP', 'm-menu__item--active m-menu__item--open')
@section('faAPSI', 'm-menu__item--active')
@section('content')
<input type="hidden" value="{{ Request::segment(2) }}" name="si_uuid" id=""/>
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Supplier Invoice General
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
                            Supplier Invoice General
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
@include('cashbookview::coamodal')
@include('supplierinvoicegeneralview::modal-create')
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

                            @include('label::edit')

                            <h3 class="m-portlet__head-text">
                                Supplier Invoice General
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
                                            Date @include('label::required')
                                        </label>

                                        @component('input::datepicker')
                                            @slot('id', 'date')
                                            @slot('text', 'Date')
                                            @slot('name', 'transaction_date')
                                            @slot('id_error', 'date')
                                                                                        @slot('value', $data->transaction_date)
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Vendor @include('label::required')
                                        </label>
                                                                                <select id="vendor" name="id_supplier" class="form-control m-select2">
                                                                                        @foreach ($vendor as $x)
                                                                                                <option value="{{ $x->id }}"
                                                                                                        @if ($x->id == $data->id_supplier) selected @endif>
                                                                                                        {{ $x->name }}
                                                                                                </option>
                                                                                        @endforeach
                                                                                </select>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group m-form__group row ">
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <label class="form-control-label">
                                                    Term Of Payment
                                                </label>

                                                @component('input::number')
                                                    @slot('id', 'term_of_payment')
                                                    @slot('text', 'Term Of Payment')
                                                    @slot('name', 'term_of_payment')
                                                    @slot('id_error', 'term_of_payment')
                                                                                                        @slot('value', $data->closed)
                                                @endcomponent
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <label class="form-control-label">
                                                    Due Date
                                                </label>

                                                <div class="input-group date">
                                                  <input type="text" disabled="disabled" id="valid_until" name="valid_until" class="form-control" value="{{$data->due_date}}">
                                                  <div class="input-group-append">
                                                      <span class="input-group-text">
                                                      <i class="la la-calendar glyphicon-th"></i>
                                                      </span>
                                                  </div>
                                                </div>

                                                {{-- @component('input::datepicker')
                                                    @slot('id', 'valid_until')
                                                    @slot('text', 'Due Date')
                                                    @slot('name', 'valid_until')
                                                    @slot('id_error', 'valid_until')
                                                                                                        @slot('value', $data->due_date)
                                                @endcomponent --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group m-form__group row ">
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <label class="form-control-label">
                                                    Currency @include('label::required')
                                                </label>
                                                                                                <select id="currency" name="currency" class="form-control m-select2">
                                                                                                        @foreach ($currency as $x)
                                                                                                                <option value="{{ $x->code }}"
                                                                                                                        @if ($x->code == $data->currency) selected @endif>
                                                                                                                        {{ $x->full_name }}
                                                                                                                </option>
                                                                                                        @endforeach
                                                                                                </select>
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
                                                                                                        @slot('value', $data->exchange_rate)
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>
                                </div>  <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">

                                        <label class="form-control-label">
                                            Account Code
                                        </label>

                                        {{-- @component('input::inputrightbutton')
                                            @slot('id', 'coa')
                                            @slot('text', 'coa')
                                            @slot('name', 'coa')
                                            @slot('type', 'text')
                                            @slot('style', 'width:100%')
                                            @slot('data_target', '#coa_modal')
                                            @slot('value', $data->coa->code)
                                        @endcomponent --}}

                                        <select name="account_code" id="" class="_accountcode form-control">
                                            <option value="{{$data->coa->code}}" selected>
                                                {{$data->coa->name.' ('.$data->coa->code.')'}}
                                            </option>
                                        </select>

                                        {{-- @component('input::select2')
                                            @slot('id', '_accountcode')
                                            @slot('class', '_accountcode')
                                            @slot('text', 'Account Code')
                                            @slot('name', 'account_code')
                                            @slot('id_error', 'accountcode')
                                        @endcomponent --}}
                                    </div>

                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Project
                                        </label>

                                        <select class="form-control m-input" name="id_project" id="project">
                                          @if (@$data->project->id)
                                            <option value="{{$data->project->id}}" selected>{{$data->project->code}}</option>
                                          @endif
                                        </select>
                                    </div>
                                    {{-- <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Account Code Name
                                        </label>

                                                                                <input type="text" value="{{ $data->coa->name }}" id="account_name" class="form-control m-input" disabled>
                                    </div> --}}
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <label class="form-control-label">
                                            Remark
                                        </label>

                                        @component('input::textarea')
                                            @slot('id', 'remark')
                                            @slot('text', 'Remark')
                                            @slot('name', 'description_si')
                                            @slot('rows','5')
                                                                                        @slot('value', $data->description)
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12 col-md-12 col-lg-12 footer">
                                        <div class="row align-items-center">
                                            <div class="col-xl-8 order-2 order-xl-1">
                                                <div class="form-group m-form__group row align-items-center">
                                                    <div class="col-md-4">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 order-1 order-xl-2 m--align-right">
                                                <button data-target="#modal_coa_create" data-toggle="modal" type="button" class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-primary btn-md"><span>
                                                        <i class="la la-plus-circle"></i>
                                                        <span>Add Account</span>
                                                    </span>
                                                </button>
                                                <div class="m-separator m-separator--dashed d-xl-none"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @include('supplierinvoicegeneralview::modal-edit')
                                {{-- datatables --}}
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="m-portlet m-portlet--mobile">
                                            <div class="m-portlet__body">
                                                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                                                    <div class="row align-items-center">
                                                        <div class="col-xl-6 order-2 order-xl-1">
                                                            <div class="form-group m-form__group row align-items-center">
                                                                <div class="col-md-6">
                                                                    <div class="m-input-icon m-input-icon--left">
                                                                        <input type="text" class="form-control m-input" placeholder="Search..."
                                                                            id="generalSearch">
                                                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                                                            <span><i class="la la-search"></i></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                                                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="general_datatable" id="scrolling_both"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                                        <div class="action-buttons">
                                            @component('buttons::submit')
                                                @slot('type', 'button')
                                                @slot('id','supplier_invoice_generalupdate')
                                            @endcomponent

                                            @include('buttons::reset')

                                                                                        <a href="{{route('trxpayment.index')}}" class="btn btn-secondary btn-md" style="">
                                                                                                <span>
                                                                                                        <i class="la la-undo"></i>
                                                                                                </span>
                                                                                                Back
                                                                                        </a>
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
                window.location.href=currentUrl+"#faAP";
            }
        });
    </script>
<script src="{{ asset('vendor/courier/frontend/functions/reset.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/currency.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/datepicker/date.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/datepicker/valid-until.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/vendor.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/supplier-invoice/general/edit.js')}}"></script>

<script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>
<script>
  $(document).ready(function() {

    let _url = window.location.origin;

    // handle select2
    $('._accountcode').select2({
        ajax: {
            url: _url+'/journal/get-account-code-select2',
            dataType: 'json'
        },
        minimumInputLength: 3,
        // templateSelection: formatSelected
    });

    $('body').on('input', '#term_of_payment', function() {
        let date = new Date($('[name=transaction_date]').val());

        console.log([
            date,
            $(this).val()
        ]);

        if (parseInt($(this).val())) {
            date.setDate(date.getDate() + parseInt($(this).val()));

        $('#valid_until').val(date.toInputFormat());
        }else{
        $('#valid_until').val('');
        }

    });

        Date.prototype.toInputFormat = function() {
       var yyyy = this.getFullYear().toString();
       var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
       var dd  = this.getDate().toString();
       return yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]); // padding
    };
  })
</script>
@endpush
