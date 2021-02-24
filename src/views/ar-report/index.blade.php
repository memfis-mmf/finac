@extends('frontend.master')

@section('faReport', 'm-menu__item--open m-menu__item--active')
@section('faReportTransactional', 'm-menu__item--active')
@section('content')

<div class="m-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Transactional Report
                            </h3>
                        </div>
                    </div>

                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#content_tab_1" role="tab">
                                    Account Receivable
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#content_tab_2" role="tab">
                                    Account Payable
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#content_tab_3" role="tab">
                                    Cash and Bank
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#content_tab_4" role="tab">
                                    Asset
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#content_tab_5" role="tab">
                                    Warehouse
                                </a>
                            </li>
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link" data-toggle="tab" href="#content_tab_6" role="tab">
                                    Project P/L
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="content_tab_1">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="card card-custom gutter-b bg-diagonal bg-diagonal-light-primary">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                                                <div class="d-flex flex-column mr-5">
                                                    <a href="#" data-target="#modal_outstanding" data-toggle="modal" class="h4 text-dark text-hover-primary mb-5">
                                                        Outstanding Invoice
                                                    </a>
                                                    <p class="text-dark-50">
                                                        <i class="fa fa-info-circle fa-4x"></i>
                                                        Shows Outstanding Invoice
                                                    </p>
                                                    <p class="text-dark-50">
                                                        <a href="/outstanding-invoice.pdf/help" target="_blank">
                                                            <i class="fa fa-question-circle fa-4x"></i>
                                                            Help
                                                        </a>
                                                    </p>
                                                </div>
                                                <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                                    <a href="#" data-target="#modal_outstanding" data-toggle="modal" target="_blank" class="btn font-weight-bolder text-uppercase btn-primary py-4 px-6">
                                                        View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @include('arreport-outstandingview::modal')

                                <div class="col-lg-4">
                                    <div class="card card-custom gutter-b bg-diagonal bg-diagonal-light-primary">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                                                <div class="d-flex flex-column mr-5">
                                                    <a href="#" data-target="#modal_customer_tb" data-toggle="modal" class="h4 text-dark text-hover-primary mb-5">
                                                        Customer Trial Balance
                                                    </a>
                                                    <p class="text-dark-50">
                                                        <i class="fa fa-info-circle fa-4x"></i>
                                                        Shows the report due to customer receivables
                                                    </p>
                                                    <p class="text-dark-50">
                                                        <a href="/customer-trial-balance.pdf/help" target="_blank">
                                                            <i class="fa fa-question-circle fa-4x"></i>
                                                            Help
                                                        </a>
                                                    </p>
                                                </div>
                                                <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                                    <a href="#" data-target="#modal_customer_tb" data-toggle="modal" target="_blank" class="btn font-weight-bolder text-uppercase btn-primary py-4 px-6">
                                                        View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @include('arreport-customertbview::modal')

                                <div class="col-lg-4">
                                    <div class="card card-custom gutter-b bg-diagonal bg-diagonal-light-primary">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                                            <div class="d-flex flex-column mr-5">
                                            <a href="#" data-target="#modal_aging_rd" data-toggle="modal" class="h4 text-dark text-hover-primary mb-5">
                                            Aging Receivable Detail
                                            </a>
                                            <p class="text-dark-50">
                                            <i class="fa fa-info-circle fa-4x"></i>
                                            Shows list of payment of invoices
                                            </p>
                                            </div>
                                            <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                            <a href="#" data-target="#modal_aging_rd" data-toggle="modal" target="_blank" class="btn font-weight-bolder text-uppercase btn-primary py-4 px-6">
                                                View
                                            </a>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
    
                                @include('arreport-agingview::modal')

                                <div class="col-lg-4">
                                    <div class="card card-custom gutter-b bg-diagonal bg-diagonal-light-primary">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                                                <div class="d-flex flex-column mr-5">
                                                    <a href="#" data-target="#modal_account_rh" data-toggle="modal" class="h4 text-dark text-hover-primary mb-5">
                                                        Account Receivables History
                                                    </a>
                                                    <p class="text-dark-50">
                                                        <i class="fa fa-info-circle fa-4x"></i>
                                                        Shows report of receivables customer
                                                    </p>
                                                    <p class="text-dark-50">
                                                        <a href="/account-receivables-history.pdf/help" target="_blank">
                                                            <i class="fa fa-question-circle fa-4x"></i>
                                                            Help
                                                        </a>
                                                    </p>
                                                </div>
                                                <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                                    <a href="#" data-target="#modal_account_rh" data-toggle="modal" target="_blank" class="btn font-weight-bolder text-uppercase btn-primary py-4 px-6">
                                                        View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @include('arreport-accountrhview::modal')

                                {{-- <div class="col-lg-4">
                                    <div class="card card-custom gutter-b bg-diagonal bg-diagonal-light-primary">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                                            <div class="d-flex flex-column mr-5">
                                            <a href="#" data-target="#modal_maintenance" data-toggle="modal" class="h4 text-dark text-hover-primary mb-5">
                                            Paid Invoice 
                                            </a>
                                            <p class="text-dark-50">
                                            <i class="fa fa-info-circle fa-4x"></i>
                                            Shows detailed transaction of account receivables
                                            </p>
                                            </div>
                                            <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                            <a href="#" data-target="#modal_maintenance" data-toggle="modal" target="_blank" class="btn font-weight-bolder text-uppercase btn-primary py-4 px-6">
                                                View
                                            </a>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
    
                                @include('invoicepview::modal') --}}
                            </div>
                        </div>

                        <div class="tab-pane" id="content_tab_2">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="card card-custom gutter-b bg-diagonal bg-diagonal-light-primary">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                                                <div class="d-flex flex-column mr-5">
                                                    <a href="#" data-target="#modal_ap" data-toggle="modal" class="h4 text-dark text-hover-primary mb-5">
                                                        Account Payable History
                                                    </a>
                                                    <p class="text-dark-50">
                                                        <i class="fa fa-info-circle fa-4x"></i>
                                                        Shows report of payable vendor
                                                    </p>
                                                    <p class="text-dark-50">
                                                        <a href="/account-payable-history.pdf/help" target="_blank">
                                                            <i class="fa fa-question-circle fa-4x"></i>
                                                            Help
                                                        </a>
                                                    </p>
                                                </div>
                                                <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                                    <a href="#" data-target="#modal_ap" data-toggle="modal" target="_blank" class="btn font-weight-bolder text-uppercase btn-primary py-4 px-6">
                                                        View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @include('apreport-accountrhview::modal')
                            </div>
                        </div>

                        <div class="tab-pane" id="content_tab_3">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="card card-custom gutter-b bg-diagonal bg-diagonal-light-primary">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                                                <div class="d-flex flex-column mr-5">
                                                    <a href="#" data-target="#modal_cash_statement" data-toggle="modal" class="h4 text-dark text-hover-primary mb-5">
                                                        Cash Statement
                                                    </a>
                                                    <p class="text-dark-50">
                                                        <i class="fa fa-info-circle fa-4x"></i>
                                                        Shows the report due to cash statement
                                                    </p>
                                                    <p class="text-dark-50">
                                                        <a href="/cash-statement-report.pdf/help" target="_blank">
                                                            <i class="fa fa-question-circle fa-4x"></i>
                                                            Help
                                                        </a>
                                                    </p>
                                                </div>
                                                <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                                    <a href="#" data-target="#modal_cash_statement" data-toggle="modal" target="_blank" class="btn font-weight-bolder text-uppercase btn-primary py-4 px-6">
                                                        View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @include('arreport-cashstatementview::modal')

                                <div class="col-lg-4">
                                    <div class="card card-custom gutter-b bg-diagonal bg-diagonal-light-primary">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                                                <div class="d-flex flex-column mr-5">
                                                    <a href="#" data-target="#modal_bank_statement" data-toggle="modal" class="h4 text-dark text-hover-primary mb-5">
                                                        Bank Statement
                                                    </a>
                                                    <p class="text-dark-50">
                                                        <i class="fa fa-info-circle fa-4x"></i>
                                                        Shows the report due to bank statement
                                                    </p>
                                                </div>
                                                <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                                    <a href="#" data-target="#modal_bank_statement" data-toggle="modal" target="_blank" class="btn font-weight-bolder text-uppercase btn-primary py-4 px-6">
                                                        View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @include('arreport-bankstatementview::modal')
                            </div>
                        </div>

                        <div class="tab-pane" id="content_tab_4">
                            -
                        </div>

                        <div class="tab-pane" id="content_tab_5">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="card card-custom gutter-b bg-diagonal bg-diagonal-light-primary">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                                                <div class="d-flex flex-column mr-5">
                                                    <a href="{{ route('frontend.material-transaction-history-finance.index') }}" class="h4 text-dark text-hover-primary mb-5">
                                                        Material Transaction History
                                                    </a>
                                                    <p class="text-dark-50">
                                                        <i class="fa fa-info-circle fa-4x"></i>
                                                        Shows all material transactional data
                                                    </p>
                                                </div>
                                                <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                                    <a href="{{ route('frontend.material-transaction-history-finance.index') }}" class="btn font-weight-bolder text-uppercase btn-primary py-4 px-6">
                                                        View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="card card-custom gutter-b bg-diagonal bg-diagonal-light-primary">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                                                <div class="d-flex flex-column mr-5">
                                                    <a href="{{ route('frontend.stock-monitoring-amount.index') }}" class="h4 text-dark text-hover-primary mb-5">
                                                        Stock Monitoring
                                                    </a>
                                                    <p class="text-dark-50">
                                                        <i class="fa fa-info-circle fa-4x"></i>
                                                        Shows material realtime stock data
                                                    </p>
                                                </div>
                                                <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                                    <a href="{{ route('frontend.stock-monitoring-amount.index') }}" class="btn font-weight-bolder text-uppercase btn-primary py-4 px-6">
                                                        View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="card card-custom gutter-b bg-diagonal bg-diagonal-light-primary">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                                                <div class="d-flex flex-column mr-5">
                                                    <a href="/stock-movement-value" class="h4 text-dark text-hover-primary mb-5">
                                                        Stock Movement
                                                    </a>
                                                    <p class="text-dark-50">
                                                        <i class="fa fa-info-circle fa-4x"></i>
                                                        Shows material realtime movement with value
                                                    </p>
                                                </div>
                                                <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                                    <a href="/stock-movement-value" class="btn font-weight-bolder text-uppercase btn-primary py-4 px-6">
                                                        View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="content_tab_6">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="card card-custom gutter-b bg-diagonal bg-diagonal-light-primary">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                                                <div class="d-flex flex-column mr-5">
                                                    <a href="{{ route('project-report.profit-loss.index') }}" class="h4 text-dark text-hover-primary mb-5">
                                                        Project Profit & Loss
                                                    </a>
                                                    <p class="text-dark-50">
                                                        <i class="fa fa-info-circle fa-4x"></i>
                                                        Shows report profit & loss of project
                                                    </p>
                                                </div>
                                                <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                                                    <a href="{{ route('project-report.profit-loss.index') }}" class="btn font-weight-bolder text-uppercase btn-primary py-4 px-6">
                                                        View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-maintenance" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h2>This Menu is under <b class="text-danger">Maintenance</b></h2>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('header-scripts')
<style>
    .btn-large {
        height: 100px;
        width: 100px;
    }

    .btn-icon {
        float: left;
        font-size: 50px;

    }
</style>
@endpush

@push('footer-scripts')
<script>
  $(document).ready(function() {
      let currentUrl = window.location.href;
      let _hash = currentUrl.split('#');
      if (_hash.length < 2) {
        window.location.href = currentUrl + "#faReport";
      } else {
        window.location.href = currentUrl;
      }

      $(document).on('click', '.export-to-excel', function() {
        let href = $(this).data('href');
        let daterange = $('[name=daterange]').val();

        href = href + '?daterange=' + daterange;

        window.open(href, '_blank');

      });

  });
</script>

@if (Session::get('errors'))
<script type="text/javascript">
	$(document).ready(function () {
		toastr.error(`{{Session::get('errors')}}`, 'Invalid', {
				timeOut: 3000
		});
	});
</script>
@endif

@endpush