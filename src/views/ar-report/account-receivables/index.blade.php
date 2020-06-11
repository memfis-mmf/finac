@extends('frontend.master')

@section('content')
@php
  use Illuminate\Support\Carbon;
@endphp
<style>
  tr.nowrap td {
    white-space: nowrap;
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
                                 <h4>Period : {{Carbon::parse($date[0])->format('d F Y')}} - {{Carbon::parse($date[1])->format('d F Y')}}</h4>
                                </div>
                            </div>

                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <table width="100%" cellpadding="3">
                                        <tr>
                                            <td width="12%" valign="top">MMF Department</td>
                                            <td width="1%" valign="top">:</td>
                                          <td width="77%" valign="top">{{$department->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>MMF Location</td>
                                            <td>:</td>
                                            <td style="text-transform: capitalize">{{$location}}</td>
                                        </tr>
                                        <tr>
                                            <td>Currency</td>
                                            <td>:</td>
                                            <td>{{$currency}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @foreach ($data as $dataRow)
                              @php
                                $sum_subtotal = 0;
                                $sum_discount = 0;
                                $sum_vat = 0;
                                $sum_receivable_total = 0;
                                $sum_paid_amount = 0;
                                $sum_pph = 0;
                                $sum_ending_balance = 0;
                                $sum_ending_balance_idr = 0;

                                $invoice_currency = $dataRow[0]->currencies->code;
                              @endphp
                                
                              {{-- content --}}
                              <div class="form-group m-form__group row ">
                                  <div class="col-sm-12 col-md-12 col-lg-12">   
                                      <table width="100%" cellpadding="3" class="table-head">
                                          <tr>
                                              <td width="12%" valign="top"><b>Customer Name</b></td>
                                              <td width="1%" valign="top"><b>:</b></td>
                                              <td width="77%" valign="top"><b>{{$dataRow[0]->customer->name}}</b></td>
                                          </tr>
                                      </table>
                                      <table width="100%"  cellpadding="4" class="table-body" page-break-inside: auto; >  
                                          <thead style="border-bottom:2px solid black;">     
                                              <tr>
                                                  <td width="" align="left" valign="top" style="padding-left:8px;"><b>Transaction No.</b></td>
                                                  <td width="" align="center" valign="top"><b>Date</b></td>
                                                  <td width="" align="center" valign="top"><b>Ref No.</b></td>
                                                  @if ($invoice_currency != 'idr')
                                                    <td width="" align="center" valign="top" colspan="2"><b>Exchange Rate</b></td>
                                                  @endif
                                                  <td width="" align="center" valign="top"><b>Description</b></td>
                                                  <td width="" align="center" valign="top" colspan="2"><b>Sub Total</b></td>
                                                  <td width="" align="center" valign="top" colspan="2"><b>Discount</b></td>
                                                  <td width="" align="center" valign="top" colspan="2"><b>VAT</b></td>
                                                  <td width="" align="center" valign="top"  colspan="2"><b>Receivables Total</b></td>
                                                  <td width="" align="center" valign="top"  colspan="2"><b>Paid Amount</b></td>
                                                  <td width="" align="center" valign="top"  colspan="2"><b>PPH</b></td>
                                                  <td width="" align="center" valign="top"  colspan="2"><b>Ending Balance</b></td>
                                                  @if ($invoice_currency != 'idr')
                                                    <td width="" align="center" valign="top"  colspan="2"><b>Ending Balance in IDR</b></td>
                                                  @endif
                                              </tr>
                                          </thead>
                                          <tbody>
                                            @foreach ($dataRow as $item)
                                              <tr style="font-size:8.4pt;" class="nowrap">
                                                <td width="" align="left" valign="top" style="padding-left:8px;">{{$item->transactionnumber}}</td>
                                                <td width="" align="center" valign="top">{{Carbon::parse($item->transactiondate)->format('d/m/Y')}}</td>
                                                <td width="" align="left" valign="top">{{$item->quotations->number}}</td>
                                                @if ($invoice_currency != 'idr')
                                                  <td width="1%" align="right" valign="top">Rp</td>
                                                  <td width="" align="left" valign="top">{{number_format($item->ara[0]->ar->exchangerate)}}</td>
                                                @endif
                                                <td width="" align="left" valign="top">{{$item->description}}</td>
                                                <td width="" align="right" valign="top">{{$item->currencies->symbol}}</td>
                                                <td width="" align="right" valign="top">{{number_format($item->report_subtotal)}}</td>
                                                <td width="1%" align="right" valign="top">{{$item->currencies->symbol}}</td>
                                                <td width="" align="right" valign="top">{{number_format($item->report_discount)}}</td>
                                                <td width="1%" align="right" valign="top">{{$item->currencies->symbol}}</td>
                                                <td width="" align="right" valign="top">{{number_format($item->ppnvalue)}}</td>
                                                <td width="1%" align="right" valign="top">{{$item->currencies->symbol}}</td>
                                                <td width="" align="right" valign="top" >0</td>
                                                <td width="1%" align="right" valign="top">{{$item->currencies->symbol}}</td>
                                                <td width="" align="right" valign="top">{{number_format($item->report_paid_amount)}}</td>
                                                <td width="1%" align="right" valign="top">{{$item->currencies->symbol}}</td>
                                                <td width="" align="right" valign="top">0</td>
                                                <td width="1%" align="right" valign="top">{{$item->currencies->symbol}}</td>
                                                <td width="" align="right" valign="top">{{number_format($item->report_ending_balance)}}</td>
                                                @if ($invoice_currency != 'idr')
                                                  <td width="1%" align="right" valign="top">RP</td>
                                                  <td width="" align="right" valign="top">{{number_format($item->report_ending_balance * $item->ara[0]->ar->exchangerate)}}</td>
                                                @endif
                                              </tr>
                                              @php
                                                $sum_subtotal += $item->report_subtotal;
                                                $sum_discount += $item->report_discount;
                                                $sum_vat += $item->ppnvalue;
                                                $sum_receivable_total += 0;
                                                $sum_paid_amount += $item->report_paid_amount;
                                                $sum_pph += 0;
                                                $sum_ending_balance += $item->report_ending_balance;
                                                $sum_ending_balance_idr += ($sum_ending_balance * $item->ara[0]->ar->exchangerate)
                                              @endphp
                                            @endforeach
                                            {{-- Total IDR --}}
                                            <tr style="border-top:2px solid black; font-size:9pt;" >
                                                <td colspan="{{($invoice_currency != 'idr')? 5: 3}}"></td>
                                                <td align="left" valign="top" colspan="1"><b>Total {{strtoupper($invoice_currency)}}</b></td>
                                                <td width="1%" align="right" valign="top" class="table-footer"><b>{{$item->currencies->symbol}}</b></td>
                                                <td width=""align="right" valign="top" class="table-footer"><b>{{number_format($sum_subtotal)}}</b></td>
                                                <td width="1%" align="right" valign="top" class="table-footer"><b>{{$item->currencies->symbol}}</b></td>
                                                <td width="" align="right" valign="top" class="table-footer"><b>{{number_format($sum_discount)}}</b></td>
                                                <td width="1%" align="right" valign="top" class="table-footer"><b>{{$item->currencies->symbol}}</b></td>
                                                <td width="" align="right" valign="top" class="table-footer"><b>{{number_format($sum_vat)}}</b></td>
                                                <td width="1%" align="right" valign="top" class="table-footer"><b>{{$item->currencies->symbol}}</b></td>
                                                <td width="" align="right" valign="top" class="table-footer"><b>{{number_format($sum_receivable_total)}}</b></td>
                                                <td width="1%" align="right" valign="top" class="table-footer"><b>{{$item->currencies->symbol}}</b></td>
                                                <td width="" align="right" valign="top" class="table-footer"><b>{{number_format($sum_paid_amount)}}</b></td>
                                                <td width="1%" align="right" valign="top" class="table-footer"><b>{{$item->currencies->symbol}}</b></td>
                                                <td width="" align="right" valign="top" class="table-footer"><b>{{number_format($sum_pph)}}</b></td>
                                                <td width="1%" align="right" valign="top" class="table-footer"><b>{{$item->currencies->symbol}}</b></td>
                                                <td width="" align="right" valign="top" class="table-footer"><b>{{number_format($sum_ending_balance)}}</b></td>
                                                @if ($invoice_currency != 'idr')
                                                  <td width="1%" align="right" valign="top">RP</td>
                                                  <td width="" align="right" valign="top">{{number_format($sum_ending_balance_idr)}}</td>
                                                @endif
                                            </tr>
                                            
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                              {{-- end content --}}

                            @endforeach

                            <hr>
                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12 text-right">
                                    <div class="action-buttons">
                                      <button id="" type="button" name="submit" class="btn btn-primary btn-md add" data-target="#modal_account_rh" data-toggle="modal">
                                          <span>
                                              <i class="fa fa-filter"></i>
                                              <span>Change Filter</span>
                                          </span>
                                      </button>

                                      @component('buttons::submit')
                                      @slot('text', 'Print')
                                      @slot('icon', 'fa-print')
                                      @endcomponent

                                      <a href="{{$export}}" target="_blank" class="btn btn-success btn-md text-light" style="cursor: pointer">
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
@include('arreport-accountrhview::modal')
<input hidden id="coaid">

@endsection
