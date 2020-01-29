@extends('frontend.master')

@section('content')
<div class="m-subheader hidden">
	<input type="hidden" name="ar_uuid" value="{{ Request::segment(2) }}" disabled>
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

                            @include('label::edit')

                            <h3 class="m-portlet__head-text">
                                Account Receivable
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <form id="SupplierInvoiceGRNForm">
													<input type="hidden" name="ar_uuid" value="{{ Request::segment(2) }}">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Date @include('label::required')
                                        </label>

                                        @component('input::datepicker')
                                            @slot('id', 'date')
                                            @slot('text', 'Date')
                                            @slot('name', 'transactiondate')
                                            @slot('id_error', 'date')
                                            @slot('value', $data->date)
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Customer @include('label::required')
                                        </label>
																				<select id="customer" name="id_customer" class="form-control m-select2">
																						@foreach ($customer as $x)
																								<option value="{{ $x->id }}"
																										@if ($x->id == $data->id_customer) selected @endif>
																										{{ $x->name }}
																								</option>
																						@endforeach
																				</select>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Account Code @include('label::required')
                                        </label>

                                        @component('input::inputrightbutton')
                                            @slot('id', 'coa')
                                            @slot('text', 'coa')
                                            @slot('name', 'accountcode')
                                            @slot('type', 'text')
                                            @slot('style', 'width:100%')
                                            @slot('data_target', '#coa_modal')
																						@slot('value', $data->coa->code)
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Account Name
                                        </label>

																				<input type="text" value="{{ $data->coa->name }}" id="account_name" class="form-control m-input" disabled>
                                    </div>
                                </div>
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
                                            @slot('name', 'exchangerate')
																						@slot('value', (int) $data->exchangerate)
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
                                            @slot('text', 'Remark')
                                            @slot('name', 'ar_description')
                                            @slot('rows','5')
                                            @slot('value',$data->description)
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
                                                <button data-target="#modal_create_invoice" data-toggle="modal" type="button" class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-primary btn-md"><span>
                                                        <i class="la la-plus-circle"></i>
                                                        <span>Invoice</span>
                                                    </span>
                                                </button>
                                                <div class="m-separator m-separator--dashed d-xl-none"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @include('accountreceivableview::modal-create-invoice')
                                @include('accountreceivableview::modal-edit-invoice')
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
                                                <div class="invoice_datatable" id="scrolling_both"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <fieldset class="border p-2">
                                    <legend class="w-auto">Debt Information</legend>
                                    <div class="form-group m-form__group row">
                                        <div class="col-sm-4 col-md-4 col-lg-4">
                                            <label class="form-control-label">
                                                Debt Total Amount
                                            </label>

                                            @component('label::data-info')
                                                @slot('text', number_format($debt_total_amount, 0, 0, '.'))
                                            @endcomponent
                                        </div>
                                        <div class="col-sm-4 col-md-4 col-lg-4">
                                            <label class="form-control-label">
                                                Payment Total Amount
                                            </label>

                                            @component('label::data-info')
                                                @slot('text', number_format($payment_total_amount, 0, 0, '.'))
                                            @endcomponent
                                        </div>
                                        <div class="col-sm-4 col-md-4 col-lg-4">
                                            <label class="form-control-label">
																							Debt Balance
                                            </label>

                                            @component('label::data-info')
                                                @slot('text', number_format($debt_balance, 0, 0, '.'))
                                            @endcomponent
                                        </div>
                                    </div>
                                </fieldset>
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
                                                <button data-target="#coa_modal" data-toggle="modal" type="button" class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-primary btn-md"><span>
                                                        <i class="la la-plus-circle"></i>
                                                        <span>Adjustment</span>
                                                    </span>
                                                </button>
                                                <div class="m-separator m-separator--dashed d-xl-none"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @include('accountreceivableview::modal-edit-adjustment')
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
                                                <div class="adjustment_datatable" id="scrolling_both"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                                        <div class="action-buttons">
                                            @component('buttons::submit')
                                                @slot('type', 'button')
                                                @slot('id','account_receivable_save')
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


@push('header-scripts')
    <style>
        @media (min-width: 992px){
            .modal-invoice {
                max-width: 1300px !important;
            }
        }
    </style>
@endpush

@push('footer-scripts')
<script src="{{ asset('vendor/courier/frontend/functions/reset.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/coamodal.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/currency.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/datepicker/date.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/customer.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/account-receivable/edit.js')}}"></script>

<script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>
@endpush
