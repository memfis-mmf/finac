@extends('frontend.master')

@section('faReport', 'm-menu__item--active')
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
                                <div class="pl-5 pr-5">
                                    <button type="button" class="btn btn-primary m-btn m-btn--pill-last w-100 btn-large" data-target="#modal_outstanding" data-toggle="modal">
                                        <span>
                                        <i class="la la-file-o btn-icon"></i>
                                            <span><h3>Outstanding Invoice</h3></span>
                                            <span>Shows Outstanding Invoice</span>

                                        </span>
                                    </button>
                                </div>
                            </div>

                            @include('arreport-outstandingview::modal')

                            {{-- Customer TB --}}
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="pl-5 pr-5">
                                    <button type="button" class="btn btn-primary m-btn m-btn--pill-last w-100 btn-large" data-target="#modal_customer_tb" data-toggle="modal">
                                        <span>
                                        <i class="la la-file-o btn-icon"></i>
                                            <span><h3>Customer Trial Balance</h3></span>
                                            <span>Shows the report due to customer receivables</span>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            @include('arreport-customertbview::modal')

                        </div>
                        <div class="form-group m-form__group row ">
                            {{-- Aging Receivable Detail --}}
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="pl-5 pr-5 pt-5">
                                    <button type="button" class="btn btn-primary m-btn m-btn--pill-last w-100 btn-large" data-target="#modal_aging_rd" data-toggle="modal">
                                        <span>
                                        <i class="la la-file-o btn-icon"></i>
                                            <span><h3>Aging Receivable Detail</h3></span>
                                            <span>Shows list of payment of invoices</span>
                                            
                                        </span>
                                    </button>
                                </div>
                            </div>

                            @include('arreport-agingview::modal')

                            {{-- Account Receivables History --}}
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="pl-5 pr-5 pt-5">
                                    <button type="button" class="btn btn-primary m-btn m-btn--pill-last w-100 btn-large" data-target="#modal_account_rh" data-toggle="modal">
                                        <span>
                                        <i class="la la-file-o btn-icon"></i>
                                            <span><h3>Account Receivables History</h3></span>
                                            <span>Shows report of receivables customer</span>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            @include('arreport-accountrhview::modal')

                        </div>
                        <div class="form-group m-form__group row ">
                            {{-- Invoice Paid --}}
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="pl-5 pr-5 pt-5">
                                    <button type="button" class="btn btn-primary m-btn m-btn--pill-last w-100 btn-large" data-target="#modal_invoice_paid" data-toggle="modal">
                                        <span>
                                        <i class="la la-file-o btn-icon"></i>
                                            <span><h3>Invoice Paid</h3></span>
                                            <span>Shows detailed transaction of account receivables</span>
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

@push('header-scripts')
<style>
.btn-large{
    height:100px;
    width:100px;
}

.btn-icon{
    float:left;
    font-size:50px;

}

</style>
@endpush

@push('footer-scripts')
    <script>
        $(document).ready(function() {
            let currentUrl = window.location.href;
            let _hash = currentUrl.split('#');
            if (_hash.length < 2) {
                window.location.href=currentUrl+"#faReport";
            } else {
                window.location.href=currentUrl;
            }
        });
    </script>
@endpush