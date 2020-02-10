@extends('frontend.master')

@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Account Receivable Reports
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
                            Account Receivable Reports
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

                            @component('label::datalist')
                            @slot('text','Ar Reports')
                            @endcomponent

                            <h3 class="m-portlet__head-text">
                                Account Receivable Reports
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row ">
                            {{-- Outstanding --}}
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="p-5">
                                    <button type="button" class="btn btn-primary m-btn m-btn--pill-last w-100" data-target="#modal_outstanding" data-toggle="modal">
                                        <span>
                                            <i class="la la-plus-circle"></i>
                                            <span>Outstanding Invoice</span>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            @include('arreport-outstandingview::modal')

                            {{-- Customer TB --}}
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="p-5">
                                    <button type="button" class="btn btn-primary m-btn m-btn--pill-last w-100" data-target="#modal_customer_tb" data-toggle="modal">
                                        <span>
                                            <i class="la la-plus-circle"></i>
                                            <span>Customer Trial Balance</span>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            @include('arreport-customertbview::modal')

                        </div>
                        <div class="form-group m-form__group row ">
                            {{-- Aging Receivable Detail --}}
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="p-5">
                                    <button type="button" class="btn btn-primary m-btn m-btn--pill-last w-100" data-target="#modal_aging_rd" data-toggle="modal">
                                        <span>
                                            <i class="la la-plus-circle"></i>
                                            <span>Aging Receivable Detail</span>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            @include('arreport-agingview::modal')

                            {{-- Account Recivables History --}}
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="p-5">
                                    <button type="button" class="btn btn-primary m-btn m-btn--pill-last w-100" data-target="#modal_account_rh" data-toggle="modal">
                                        <span>
                                            <i class="la la-plus-circle"></i>
                                            <span>Account Reecivables History</span>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            @include('arreport-accountrhview::modal')

                        </div>
                        <div class="form-group m-form__group row ">
                            {{-- Invoice Paid --}}
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="p-5">
                                    <button type="button" class="btn btn-primary m-btn m-btn--pill-last w-100" data-target="#modal_invoice_paid" data-toggle="modal">
                                        <span>
                                            <i class="la la-plus-circle"></i>
                                            <span>Invoice Paid</span>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            @include('invoicepview::modal')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
