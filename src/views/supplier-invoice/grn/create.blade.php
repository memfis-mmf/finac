@extends('frontend.master')

@section('faAP', 'm-menu__item--active m-menu__item--open')
@section('faAPSI', 'm-menu__item--active')
@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Supplier Invoice GRN
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
                            Supplier Invoice GRN
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
                                Supplier Invoice GRN
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
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Vendor @include('label::required')
                                        </label>

                                        @component('input::select')
                                            @slot('id', 'vendor')
                                            @slot('name', 'id_supplier')
                                            @slot('text', 'Supplier')
                                            @slot('style', 'width:100%')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group m-form__group row ">
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <label class="form-control-label">
                                                    Term Of Payment @include('label::required')
                                                </label>

                                                @component('input::number')
                                                    @slot('id', 'term_of_payment')
                                                    @slot('text', 'Term Of Payment')
                                                    @slot('name', 'closed')
                                                    @slot('id_error', 'term_of_payment')
                                                @endcomponent
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <label class="form-control-label">
                                                    Due Date
                                                </label>

                                                @component('input::datepicker')
                                                    @slot('id', 'valid_until')
                                                    @slot('text', 'Due Date')
                                                    @slot('id_error', 'valid_until')
                                                    @slot('disabled', 'disabled')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group m-form__group row ">
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <label class="form-control-label">
                                                    Currency @include('label::required')
                                                </label>

                                                @component('input::select')
                                                    @slot('id', 'currency')
                                                    @slot('text', 'Currency')
                                                    @slot('name', 'currency')
                                                    @slot('id_error', 'currency')
                                                @endcomponent
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
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <label class="form-control-label">
                                            Project
                                        </label>

                                        @component('input::select')
                                            @slot('id', 'project')
                                            @slot('name', 'id_project')
                                            @slot('text', 'Project')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6">
                                        <br />
                                        <label class="form-control-label">
                                            Location
                                        </label>

                                        <select class="_select2 form-control" name="location" style="width:100%">
                                            <option value=""></option>
                                            <option value="sidoarjo">Sidoarjo</option>
                                            <option value="surabaya">Surabaya</option>
                                            <option value="jakarta">Jakarta</option>
                                            <option value="biak">Biak</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-12 mt-4">
                                        <label class="form-control-label">
                                            Remark
                                        </label>

                                        @component('input::textarea')
                                            @slot('id', 'remark')
                                            @slot('text', 'Remark')
                                            @slot('name', 'description')
                                            @slot('rows','5')
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
                                                <button class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-primary btn-md" disabled><span>
                                                        <i class="la la-plus-circle"></i>
                                                        <span>GRN</span>
                                                    </span>
                                                </button>
                                                <div class="m-separator m-separator--dashed d-xl-none"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                                <div class="grn_datatable" id="scrolling_both"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                                        <div class="action-buttons">
                                            @component('buttons::submit')
                                                @slot('type', 'button')
                                                @slot('id','supplier_invoice_grnsave')
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
            } else {
                window.location.href=currentUrl;
            }
        });
    </script>
<script src="{{ asset('vendor/courier/frontend/functions/reset.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/currency.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/currencyfa.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/datepicker/date.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/datepicker/valid-until.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/vendor.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/supplier-invoice/grn/create.js')}}"></script>

<script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function() {

    $('._select2').select2({
      allowClear: true,
      placeholder: '-- Select --'
    });

		$('body').on('input', '#term_of_payment', function() {
      let transaction_date_arr = $('[name=transaction_date]').val().split('-')
      let date = new Date(transaction_date_arr[2], transaction_date_arr[1], transaction_date_arr[0]);

			if (parseInt($(this).val())) {
				date.setDate(date.getDate() + parseInt($(this).val()));

	      $('#valid_until').val(('0'+date.getDate()).slice(-2)+'-'+('0'+date.getMonth()).slice(-2)+'-'+date.getFullYear());
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
