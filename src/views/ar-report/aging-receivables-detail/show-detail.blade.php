@extends('frontend.master')

@section('faReport', 'm-menu__item--active')
@section('content')
<style>
  tr.nowrap,
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
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>

                            @component('label::create-new')
                            @slot('text', 'Report')
                            @endcomponent

                            <h3 class="m-portlet__head-text">
                                Aging Receivable Detail
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                 <h1>AGING RECEIVABLE DETAIL</h1>
                                 <h4>Date : {{ $date }}</h4>
                                </div>
                            </div>
                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <table width="100%" cellpadding="3">
                                        <tr>
                                            <td class="nowrap" valign="top" width="1px">Department</td>
                                            <td class="nowrap" valign="top" width="1px">:</td>
                                            <td  valign="top">{{ $department }}</td>
                                        </tr>
                                        <tr>
                                            <td>Location</td>
                                            <td>:</td>
                                            <td>{{ $location }}</td>
                                        </tr>
                                        <tr>
                                            <td>Currency</td>
                                            <td>:</td>
                                            <td>{{ strtoupper($currency->code) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group m-form__group row ">

                              @foreach ($data as $customer_row)
                                @php
                                  $total_amount_current = 0;
                                  $total_amount1_6 = 0;
                                  $total_amount7_12 = 0;
                                  $total_amount_1 = 0;
                                  $total_amount_2 = 0;
                                  $total_balance = 0;
                                @endphp
                                <div class="col-sm-12 col-md-12 col-lg-12 pt-2 mt-5" style="overflow: auto">
                                  <h4>Customer Name : {{ $customer_row->name }}</h4>
                                    <table width="100%" cellpadding="4" class="table-body" page-break-inside: auto;>
                                        <thead style="border-bottom:2px solid black;">
                                            <tr>
                                                <td align="left" valign="top" style="padding-left:8px;"><b>Invoice Number</b></td>
                                                <td align="center" valign="top"><b>Due Date</b></td>
                                                <td align="center" valign="top" colspan="2" style="color:red;"><i><b>Current</b></i></td>
                                                <td align="center" valign="top" colspan="2" style="color:red;"><i><b>1-6 Months</b></i></td>
                                                <td align="center" valign="top"  colspan="2" style="color:red;"><i><b>7-12 Months</b></i></td>
                                                <td align="center" valign="top"  colspan="2" style="color:red;"><i><b> 1 Year</b></i></td>
                                                <td align="center" valign="top"  colspan="2" style="color:red;"><i><b> 2 Year</b></i></td>
                                                <td align="center" valign="top"  colspan="2"><i><b>Total Balance</b></i></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach ($customer_row->invoice as $invoice_row)
                                            <tr>
                                              <td class="nowrap" align="left" valign="top" style="padding-left:8px;">{{ $invoice_row->number }}</td>
                                              <td class="nowrap" align="right" valign="top">{{ $invoice_row->due_date }}</td>
                                              <td class="nowrap" align="right" valign="top">{{ $currency->symbol }}</td>
                                              <td class="nowrap" align="right" valign="top">{{ $class::currency_format($invoice_row->amount_current) }}</td>
                                              <td class="nowrap" align="right" valign="top">{{ $currency->symbol }}</td>
                                              <td class="nowrap" align="right" valign="top">{{ $class::currency_format($invoice_row->amount1_6) }}</td>
                                              <td class="nowrap" align="right" valign="top">{{ $currency->symbol }}</td>
                                              <td class="nowrap" align="right" valign="top">{{ $class::currency_format($invoice_row->amount7_12) }}</td>
                                              <td class="nowrap" align="right" valign="top">{{ $currency->symbol }}</td>
                                              <td class="nowrap" align="right" valign="top">{{ $class::currency_format($invoice_row->amount_1) }}</td>
                                              <td class="nowrap" align="right" valign="top">{{ $currency->symbol }}</td>
                                              <td class="nowrap" align="right" valign="top">{{ $class::currency_format($invoice_row->amount_2) }}</td>
                                              <td class="nowrap" align="right" valign="top">{{ $currency->symbol }}</td>
                                              <td class="nowrap" align="right" valign="top">{{ $class::currency_format($invoice_row->balance) }}</td>
                                            </tr>

                                            @php
                                              $total_amount_current += $invoice_row->amount_current;
                                              $total_amount1_6 += $invoice_row->amount1_6;
                                              $total_amount7_12 += $invoice_row->amount7_12;
                                              $total_amount_1 += $invoice_row->amount_1;
                                              $total_amount_2 += $invoice_row->amount_2;
                                              $total_balance += $invoice_row->balance;
                                            @endphp
                                          @endforeach

                                          <tr>
                                              <td align="center" valign="top" colspan="2"><b>Total</b></td>
                                              <td align="right" valign="top"><b>{{ $currency->symbol }}</b></td>
                                              <td align="right" valign="right"><b>{{ $class::currency_format($total_amount_current) }}</b></td>
                                              <td align="right" valign="top"><b>{{ $currency->symbol }}</b></td>
                                              <td align="right" valign="right"><b>{{ $class::currency_format($total_amount1_6) }}</b></td>
                                              <td align="right" valign="top"><b>{{ $currency->symbol }}</b></td>
                                              <td align="right" valign="right"><b>{{ $class::currency_format($total_amount7_12) }}</b></td>
                                              <td align="right" valign="top"><b>{{ $currency->symbol }}</b></td>
                                              <td align="right" valign="right"><b>{{ $class::currency_format($total_amount_1) }}</b></td>
                                              <td align="right" valign="top"><b>{{ $currency->symbol }}</b></td>
                                              <td align="right" valign="right"><b>{{ $class::currency_format($total_amount_2) }}</b></td>
                                              <td align="right" valign="top"><b>{{ $currency->symbol }}</b></td>
                                              <td align="right" valign="right"><b>{{ $class::currency_format($total_balance) }}</b></td>
                                          </tr>
                                        </tbody>
                                    </table>
                                </div>
                              @endforeach

                            </div>
                            <hr>
                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12 text-right">
                                    <div class="action-buttons">
                                        {{-- <button id="" type="button" name="submit" class="btn btn-primary btn-md add"
                                          data-target="#modal_aging_rd" data-toggle="modal">
                                          <span>
                                            <i class="fa fa-filter"></i>
                                            <span>Change Filter</span>
                                          </span>
                                        </button> --}}

                                        <a href="{{ route('fa-report.ar.aging.print', Request::all()) }}" target="_blank" class="btn btn-success btn-md">
                                            <span>
                                                <i class="fa fa-print"></i>
                                                <span>Print</span>
                                            </span>
                                        </a>

                                        <a href="{{ route('fa-report.ar.aging.export', Request::all()) }}" target="_blank" class="btn btn-success btn-md">
                                            <span>
                                                <i class="fa fa-file-excel"></i>
                                                <span>Export to Excel</span>
                                            </span>
                                        </a>

                                        @include('buttons::back')
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
@include('arreport-agingview::modal')

@endsection
