@extends('frontend.master')

@section('faReport', 'm-menu__item--active')
@section('content')
@php
  use Illuminate\Support\Carbon;
@endphp
<style>
  tr.nowrap td, 
  td.nowrap {
    white-space: nowrap;
  }

  thead td {
    white-space: nowrap !important;
  }
</style>
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
<div class="m-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="m-portlet">
                <div class="m-portlet__head ribbon ribbon-top ribbon-ver">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>

                            @component('label::create-new')
                            @slot('text', 'Report')
                            @endcomponent

                            <h3 class="m-portlet__head-text">
                                Outstanding Invoice
                            </h3>
                        </div>
                    </div>
                    @component('frontend.common.buttons.read-help')
                        @slot('href', '/outstanding-invoice.pdf/help')
                    @endcomponent
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                 <h1>OUTSTANDING INVOICE</h1>
                                 <h4>As of Date. {{ Carbon::parse($date)->format('d F Y')  }}</h4>
                                </div>
                            </div>
                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <table width="100%" cellpadding="3">
                                        <!-- <tr>
                                            <td width="12%" valign="top">MMF Department</td>
                                            <td width="1%" valign="top">:</td>
                                            <td width="77%" valign="top">{{ $department ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>MMF Location</td>
                                            <td>:</td>
                                            <td>{{ $request->location ?? '-' }}</td>
                                        </tr> -->
                                        <tr>
                                            <td>Currency</td>
                                            <td>:</td>
                                            <td>{{ $currency ?? 'All' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12" style="overflow: auto">   
                                  @foreach ($vendor as $vendor_row)
                                    <table width="100%" cellpadding="3" class="table-head">
                                        <tr>
                                            <td width="12%" valign="top"><b>Customer Name</b></td>
                                            <td width="1%" valign="top"><b>:</b></td>
                                            <td width="77%" valign="top"><b>{{ $vendor_row->name }}</b></td>
                                        </tr>
                                    </table>
                                    <table width="100%"  cellpadding="4" class="table-body" page-break-inside: auto;>  
                                        <thead style="border-bottom:2px solid black;">     
                                            <tr>
                                                <td width="19%" align="left" valign="top" style="padding-left:8px;"><b>Invoice No.</b></td>
                                                <td width="8%"align="center" valign="top"><b>Date</b></td>
                                                <td width="8%"align="center" valign="top"><b>Due Date</b></td>
                                                <td width="17%"align="center" valign="top"><b>Ref No.</b></td>
                                                <td width="4%"align="center" valign="top"><b>Currency</b></td>
                                                <td width="6%"align="center" valign="top" colspan="2"><b>Rate</b></td>
                                                <td width="9%"align="center" valign="top"  colspan="2"><b>Total Invoice</b></td>
                                                {{-- <td width="13%"align="center" valign="top"  colspan="2"><b>VAT</b></td> --}}
                                                <td width="13%"align="center" valign="top"  colspan="2"><b>Outstanding Balance</b></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach ($vendor_row->supplier_invoice as $supplier_invoice_row)
                                            <tr class="nowrap">
                                                <td width="19%" align="left" valign="top" style="padding-left:8px;">{{ $supplier_invoice_row->transaction_number }}</td>
                                                <td width="8%"align="center" valign="top">{{ Carbon::parse($supplier_invoice_row->updated_at)->format('d F Y') }}</td>
                                                <td width="8%"align="center" valign="top">{!! $supplier_invoice_row->due_date !!}</td>
                                                <td width="17%"align="left" valign="top">{{ $supplier_invoice_row->quotations->number ?? '-' }}</td>
                                                <td width="4%"align="center" valign="top">{{ $supplier_invoice_row->currencies->code }}</td>
                                                <td width="1%" align="right" valign="top">Rp </td>
                                                <td width="5%"align="left" valign="top">{{ number_format($supplier_invoice_row->exchange_rate, 2, ',', '.') }}</td>
                                                <td width="1%" align="right" valign="top">{{ $supplier_invoice_row->currencies->symbol }}</td>
                                                <td width="8%"align="right" valign="top" >{{ number_format($supplier_invoice_row->grandtotal_foreign, 2, ',', '.') }}</td>
                                                {{-- <td width="1%" align="right" valign="top">{{ $supplier_invoice_row->currencies->symbol }}</td>
                                                <td width="12%"align="right" valign="top">{{ number_format($supplier_invoice_row->ppnvalue, 2, ',', '.') }}</td> --}}
                                                <td width="1%" align="right" valign="top">{{ $supplier_invoice_row->currencies->symbol }}</td>
                                                <td width="12%"align="right" valign="top">{{ number_format($supplier_invoice_row->ending_balance['amount'], 2, ',', '.') }}</td>
                                            </tr>
                                            @endforeach
                                            @foreach ($vendor_row->sum_total as $sum_total_index => $sum_total_row)
                                              <tr style="border-top:2px solid black;" >
                                                  <td colspan="5"></td>
                                                  <td align="left" valign="top" colspan="2"><b>Total {{ strtoupper($sum_total_index) }}</b></td>
                                                  <td width="1%" align="right" valign="top" class="table-footer"><b>{{ $sum_total_row['symbol'] }}</b></td>
                                                  <td width="12%"align="right" valign="top" class="table-footer"><b>{{ number_format($sum_total_row['grandtotal_foreign'], 2, ',', '.') }}</b></td>
                                                  {{-- <td width="1%" align="right" valign="top" class="table-footer"><b>{{ $sum_total_row['symbol'] }}</b></td>
                                                  <td width="12%" align="right" valign="top" class="table-footer"><b>{{ number_format($sum_total_row['ppnvalue'], 2, ',', '.') }}</b></td> --}}
                                                  <td width="1%" align="right" valign="top" class="table-footer"><b>{{ $sum_total_row['symbol'] }}</b></td>
                                                  <td width="12%"align="right" valign="top" class="table-footer"><b>{{ number_format($sum_total_row['ending_value'], 2, ',', '.') }}</b></td>
                                              </tr>   
                                            @endforeach
                                        </tbody>
                                    </table>
                                  @endforeach
                                </div>
                            </div>
                            <hr>
                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12 text-right">
                                    <div class="action-buttons">
                                        @component('buttons::submit')
                                        @slot('data_toggle', 'modal')
                                        @slot('data_target', '#modal_outstanding_ap')
                                        @slot('type', 'button')
                                        @slot('text', 'Change Filter')
                                        @slot('color', 'primary')
                                        @slot('icon', 'fa-filter')
                                        @endcomponent

                                        <a href="{{ $print }}" 
                                          target="_blank" class="btn btn-success btn-md add text-white"> 
                                          <span>
                                              <i class="fa fa-print"></i>
                                              <span>Print</span>
                                          </span>
                                        </a>

                                        <a href="{{ $export }}" 
                                          target="_blank" class="btn btn-success btn-md add text-white"> 
                                          <span>
                                              <i class="fa fa-file-excel"></i>
                                              <span>Export to Excel</span>
                                          </span>
                                        </a>

                                        <a href="{{ route('fa-report.index') }}" class="btn btn-secondary btn-md" style="">
                                          <span>
                                            <i class="la la-undo"></i>
                                          </span>
                                          Back
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
<input hidden id="coaid">
@include('arreport-outstandingview::modal-ap')

@endsection
