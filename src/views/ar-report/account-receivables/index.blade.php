@extends('frontend.master')

@section('content')
@php
  use Illuminate\Support\Carbon;
@endphp
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
                                
                              {{-- content --}}
                              <div class="form-group m-form__group row ">
                                  <div class="col-sm-12 col-md-12 col-lg-12">   
                                      <table width="100%" cellpadding="3" class="table-head">
                                          <tr>
                                              <td width="12%" valign="top"><b>Customer Name</b></td>
                                              <td width="1%" valign="top"><b>:</b></td>
                                              <td width="77%" valign="top"><b>{{$dataRow->customerName}}</b></td>
                                          </tr>
                                      </table>
                                      <table width="100%"  cellpadding="4" class="table-body" page-break-inside: auto; >  
                                          <thead style="border-bottom:2px solid black;">     
                                              <tr>
                                                  <td width="14%" align="left" valign="top" style="padding-left:8px;"><b>Transaction No.</b></td>
                                                  <td width="5%" align="center" valign="top"><b>Date</b></td>
                                                  <td width="14%" align="center" valign="top"><b>Ref No.</b></td>
                                                  <td width="13%" align="center" valign="top"><b>Description</b></td>
                                                  <td width="" align="center" valign="top" colspan="2"><b>Sub Total</b></td>
                                                  <td width="" align="center" valign="top" colspan="2"><b>VAT</b></td>
                                                  <td width="" align="center" valign="top" colspan="2"><b>Discount</b></td>
                                                  <td width="" align="center" valign="top"  colspan="2"><b>Receivables Total</b></td>
                                                  <td width="" align="center" valign="top"  colspan="2"><b>Paid Amount</b></td>
                                                  <td width="" align="center" valign="top"  colspan="2"><b>PPH</b></td>
                                                  <td width="" align="center" valign="top"  colspan="2"><b>Ending Balance</b></td>
                                              </tr>
                                          </thead>
                                          <tbody >
                                              <tr style="font-size:8.4pt;">
                                                  <td width="14%" align="left" valign="top" style="padding-left:8px;">{{$dataRow->transactionnumber}}</td>
                                                  <td width="5%" align="center" valign="top">{{Carbon::parse($dataRow->transactiondate)->format('d/m/Y')}}</td>
                                                  <td width="14%" align="left" valign="top">{{$dataRow->quotationNumber}}</td>
                                                  <td width="13%" align="left" valign="top">{{$dataRow->description}}</td>
                                                  <td width="1%" align="right" valign="top">{{$symbol}}</td>
                                                  <td width="" align="right" valign="top">{{number_format($dataRow->totalInvoice)}}</td>
                                                  <td width="1%" align="right" valign="top">{{$symbol}}</td>
                                                  <td width="" align="right" valign="top">{{number_format($dataRow->vat)}}</td>
                                                  <td width="1%" align="right" valign="top">{{$symbol}}</td>
                                                  <td width="" align="right" valign="top">{{number_format($dataRow->discount)}}</td>
                                                  <td width="1%" align="right" valign="top">{{$symbol}}</td>
                                                  <td width="" align="right" valign="top" >0</td>
                                                  <td width="1%" align="right" valign="top">{{$symbol}}</td>
                                                  <td width="" align="right" valign="top">{{number_format($dataRow->paidAmount)}}</td>
                                                  <td width="1%" align="right" valign="top">{{$symbol}}</td>
                                                  <td width="" align="right" valign="top">0</td>
                                                  <td width="1%" align="right" valign="top">{{$symbol}}</td>
                                                  <td width="" align="right" valign="top">{{number_format($dataRow->endingBalance)}}</td>
                                              </tr>
                                              {{-- Total IDR --}}
                                              <tr style="border-top:2px solid black; font-size:9pt;" >
                                                  <td colspan="3"></td>
                                                  <td align="left" valign="top" colspan="1"><b>Total IDR</b></td>
                                                  <td width="1%" align="right" valign="top" class="table-footer"><b>$</b></td>
                                                  <td width=""align="right" valign="top" class="table-footer"><b>94.882,00</b></td>
                                                  <td width="1%" align="right" valign="top" class="table-footer"><b>{{$symbol}}</b></td>
                                                  <td width="" align="right" valign="top" class="table-footer"><b>1.142.680.000,00</b></td>
                                                  <td width="1%" align="right" valign="top" class="table-footer"><b>{{$symbol}}</b></td>
                                                  <td width="" align="right" valign="top" class="table-footer"><b>1.142.680.000,00</b></td>
                                                  <td width="1%" align="right" valign="top" class="table-footer"><b>{{$symbol}}</b></td>
                                                  <td width="" align="right" valign="top" class="table-footer"><b>1.142.680.000,00</b></td>
                                                  <td width="1%" align="right" valign="top" class="table-footer"><b>{{$symbol}}</b></td>
                                                  <td width="" align="right" valign="top" class="table-footer"><b>1.142.680.000,00</b></td>
                                                  <td width="1%" align="right" valign="top" class="table-footer"><b>{{$symbol}}</b></td>
                                                  <td width="" align="right" valign="top" class="table-footer"><b>1.142.680.000,00</b></td>
                                                  <td width="1%" align="right" valign="top" class="table-footer"><b>{{$symbol}}</b></td>
                                                  <td width="" align="right" valign="top" class="table-footer"><b>1.142.680.000,00</b></td>
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
                                        @component('buttons::submit')
                                        @slot('text', 'Change Filter')
                                        @slot('color', 'primary')
                                        @slot('icon', 'fa-filter')
                                        @endcomponent

                                        @component('buttons::submit')
                                        @slot('text', 'Print')
                                        @slot('icon', 'fa-print')
                                        @endcomponent

                                        @component('buttons::submit')
                                        @slot('text', 'Export to Excel')
                                        @slot('icon', 'fa-file-excel')
                                        @endcomponent

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

@endsection
