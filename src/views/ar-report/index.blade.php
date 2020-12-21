@extends('frontend.master')

@section('faReport', 'm-menu__item--active')
@section('content')

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
                                    {{-- <button type="button" class="btn btn-primary m-btn m-btn--pill-last w-100 btn-large" data-target="#modal-maintenance" data-toggle="modal"> --}}
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

                            {{-- Aging Receivable Detail --}}
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="pl-5 pr-5 pt-5">
                                    {{-- <button type="button" class="btn btn-primary m-btn m-btn--pill-last w-100 btn-large" data-target="#modal_aging_rd" data-toggle="modal"> --}}
                                    <button type="button" class="btn btn-primary m-btn m-btn--pill-last w-100 btn-large" data-target="#modal-maintenance" data-toggle="modal">
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

                            {{-- Invoice Paid --}}
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="pl-5 pr-5 pt-5">
                                    {{-- <button type="button" class="btn btn-primary m-btn m-btn--pill-last w-100 btn-large" data-target="#modal_invoice_paid" data-toggle="modal"> --}}
                                    <button type="button" class="btn btn-primary m-btn m-btn--pill-last w-100 btn-large" data-target="#modal-maintenance" data-toggle="modal">
                                        <span>
                                        <i class="la la-file-o btn-icon"></i>
                                            <span><h3>Invoice Paid</h3></span>
                                            <span>Shows detailed transaction of account receivables</span>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            @include('invoicepview::modal')

                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="pl-5 pr-5 pt-5">
                                    <button type="button" class="btn btn-primary m-btn m-btn--pill-last w-100 btn-large" data-target="#modal_ap" data-toggle="modal">
                                        <span>
                                        <i class="la la-file-o btn-icon"></i>
                                            <span><h3>Account Payable History</h3></span>
                                            <span>Shows report of payable customer</span>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            @include('apreport-accountrhview::modal')

                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="pl-5 pr-5 pt-5">
                                    <a href="{{ route('project-report.profit-loss.index') }}" type="button" class="btn btn-primary m-btn m-btn--pill-last w-100 btn-large">
                                        <span>
                                            <i class="la la-file-o btn-icon"></i>
                                            <span><h3>Project Profit & Loss</h3></span>
                                            <span>Shows report profit & loss of project</span>
                                        </span>
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