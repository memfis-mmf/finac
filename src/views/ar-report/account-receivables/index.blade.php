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
                Account Receivables History
              </h3>
            </div>
          </div>
        </div>
        <div class="m-portlet m-portlet--mobile">
          <div class="m-portlet__body">
            <div class="m-portlet__body">
              <div class="form-group m-form__group row ">
                <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                  <h1>ACCOUNT RECEIVABLES HISTORY</h1>
                  <h4>Period :
                    {{ Carbon::parse($date[0])->format('d F Y') .' - '. Carbon::parse($date[1])->format('d F Y')}}</h4>
                </div>
              </div>

              <div class="form-group m-form__group row ">
                <div class="col-sm-12 col-md-12 col-lg-12">
                  <table width="100%" cellpadding="3">
                    <tr>
                      <td width="12%" valign="top">MMF Department</td>
                      <td width="1%" valign="top">:</td>
                      <td width="77%" valign="top">{{ $department ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>MMF Location</td>
                      <td>:</td>
                      <td style="text-transform: capitalize">{{ $request->location ?? '-' }}</td>
                    </tr>
                    <tr>
                      <td>Currency</td>
                      <td>:</td>
                      <td>{{ $currency ?? 'All' }}</td>
                    </tr>
                  </table>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12" style="overflow: auto">
                  {{-- content --}}
                  @foreach ($customer as $customer_row)
                  <div class="form-group m-form__group row ">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <table width="100%" cellpadding="3" class="table-head">
                        <tr>
                          <td width="12%" valign="top"><b>Customer Name</b></td>
                          <td width="1%" valign="top"><b>:</b></td>
                          <td width="77%" valign="top"><b>{{ $customer_row->name }}</b></td>
                        </tr>
                      </table>
                      <table width="100%" cellpadding="4" class="table-body" page-break-inside: auto;>
                        <thead style="border-bottom:2px solid black;">
                          <tr>
                            <td width="" align="left" valign="top" style="padding-left:8px;"><b>Transaction No.</b></td>
                            <td width="" align="center" valign="top"><b>Date</b></td>
                            <td width="" align="center" valign="top"><b>Ref No.</b></td>
                            <td width="" align="center" valign="top"><b>Exchange Rate</b></td>
                            {{-- <td width="" align="center" valign="top"><b>Description</b></td> --}}
                            <td width="" align="center" valign="top"><b>Subtotal</b></td>
                            <td width="" align="center" valign="top"><b>Discount</b></td>
                            <td width="" align="center" valign="top"><b>VAT</b></td>
                            <td width="" align="center" valign="top"><b>Receivables Total</b></td>
                            <td width="" align="center" valign="top"><b>Paid Amount</b></td>
                            {{-- <td width="" align="center" valign="top"><b>PPH</b></td> --}}
                            <td width="" align="center" valign="top"><b>Ending Balance Curr</b></td>
                            <td width="" align="center" valign="top"><b>Ending Balance in IDR</b></td>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($customer_row->invoice as $invoice_row)
                          <tr style="font-size:8.4pt;" class="nowrap">
                            <td width="" align="left" valign="top" style="padding-left:8px;">{{ $invoice_row->transactionnumber }}</td>
                            <td width="" align="center" valign="top">{{ Carbon::parse($invoice_row->transactiondate)->format('d F Y') }}</td>
                            <td width="" align="left" valign="top">{{ $invoice_row->quotations->number ?? '-' }}</td>
                            <td width="" align="left" valign="top">Rp {{ number_format($invoice_row->exchangerate, 2, ',', '.') }}</td>
                            {{-- <td width="" align="left" valign="top">{!! $invoice_row->description !!}</td> --}}
                            <td width="" align="right" valign="top">{{ $invoice_row->currencies->symbol.' '.number_format($invoice_row->subtotal, 2, ',', '.') }}</td>
                            <td width="" align="right" valign="top">{{ $invoice_row->currencies->symbol.' '.number_format($invoice_row->discountvalue, 2, ',', '.') }}</td>
                            <td width="" align="right" valign="top">{{ $invoice_row->currencies->symbol.' '.number_format($invoice_row->ppnvalue, 2, ',', '.') }}</td>
                            <td width="" align="right" valign="top">{{ $invoice_row->currencies->symbol.' '.number_format($invoice_row->grandtotalforeign, 2, ',', '.')  }}</td>
                            <td width="" align="right" valign="top">{{ $invoice_row->currencies->symbol.' '.number_format($invoice_row->ar_amount['credit'], 2, ',', '.') }}</td>
                            {{-- <td width="" align="right" valign="top">{{ number_format(0, 2, ',', '.') }}</td> --}}
                            <td width="" align="right" valign="top">{{ $invoice_row->currencies->symbol.' '.number_format($invoice_row->ending_balance['amount'], 2, ',', '.') }}</td>
                            <td width="" align="right" valign="top">Rp {{ number_format($invoice_row->ending_balance['amount_idr'], 2, ',', '.')  }}</td>
                          </tr>
                          @endforeach
                          @foreach ($customer_row->total as $total_row)
                          <tr class="nowrap" style="border-top:2px solid black; font-size:9pt;">
                            <td colspan="4"></td>
                            <td align="left" valign="top"><b>Total {{ strtoupper($total_row['currency']->code) }}</b></td>
                            <td width="" align="right" valign="top" class="table-footer">
                              <b>
                                {{ $total_row['currency']->symbol.' '.$controller::currency_format($total_row['discount_total'], 2) }}
                              </b>
                            </td>
                            <td width="" align="right" valign="top" class="table-footer">
                              <b>
                                {{ $total_row['currency']->symbol.' '.$controller::currency_format($total_row['vat_total'], 2) }}
                              </b>
                            </td>
                            <td width="" align="right" valign="top" class="table-footer">
                              <b>
                                {{ $total_row['currency']->symbol.' '.$controller::currency_format($total_row['invoice_total'], 2) }}
                              </b>
                            </td>
                            <td width="" align="right" valign="top" class="table-footer">
                              <b>
                                {{ $total_row['currency']->symbol.' '.$controller::currency_format($total_row['paid_amount_total'], 2) }}
                              </b>
                            </td>
                            <td width="" align="right" valign="top" class="table-footer">
                              <b>
                                {{ $total_row['currency']->symbol.' '.$controller::currency_format($total_row['ending_balance_total'], 2) }}
                              </b>
                            </td>
                            <td width="" align="right" valign="top" class="table-footer">
                              <b>
                                Rp {{ $controller::currency_format($total_row['ending_balance_total_idr'], 2) }}
                              </b>
                            </td>
                          </tr>   
                          @endforeach

                        </tbody>
                      </table>
                    </div>
                  </div>
                  @endforeach
                  {{-- end content --}}
                </div>
              </div>

              <hr>
              <div class="form-group m-form__group row ">
                <div class="col-sm-12 col-md-12 col-lg-12 text-right">
                  <div class="action-buttons">
                    <button id="" type="button" name="submit" class="btn btn-primary btn-md add"
                      data-target="#modal_account_rh" data-toggle="modal">
                      <span>
                        <i class="fa fa-filter"></i>
                        <span>Change Filter</span>
                      </span>
                    </button>

                    <a href="{{ $print }}" target="_blank" class="btn btn-success btn-md text-light" style="cursor: pointer">
                      <span>
                        <i class="fa fa-print"></i>
                        <span>Print</span>
                      </span>
                    </a>

                    <a href="{{ $export }}" target="_blank" class="btn btn-success btn-md text-light" style="cursor: pointer">
                      <span>
                        <i class="fa fa-file-excel"></i>
                        <span>Export to Excel</span>
                      </span>
                    </a>

                    <a href="{{route('fa-report.index')}}" class="btn btn-secondary btn-md">
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
@include('arreport-accountrhview::modal')
<input hidden id="coaid">

@endsection