@extends('frontend.master')

@section('faReport', 'm-menu__item--active')
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
                                 <h4>Period : Period</h4>
                                </div>
                            </div>

                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <table width="100%" cellpadding="3">
                                        <tr>
                                          <td width="12%" valign="top">MMF Department</td>
                                          <td width="1%" valign="top">:</td>
                                          <td width="77%" valign="top"></td>
                                        </tr>
                                        <tr>
                                            <td>MMF Location</td>
                                            <td>:</td>
                                            <td style="text-transform: capitalize"></td>
                                        </tr>
                                        <tr>
                                            <td>Currency</td>
                                            <td>:</td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

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
                                      <table width="100%"  cellpadding="4" class="table-body" page-break-inside: auto; >  
                                          <thead style="border-bottom:2px solid black;">     
                                              <tr>
                                                  <td width="" align="left" valign="top" style="padding-left:8px;"><b>Transaction No.</b></td>
                                                  <td width="" align="center" valign="top"><b>Date</b></td>
                                                  <td width="" align="center" valign="top"><b>Ref No.</b></td>
                                                  <td width="" align="center" valign="top"><b>Exchange Rate</b></td>
                                                  <td width="" align="center" valign="top"><b>Description</b></td>
                                                  <td width="" align="center" valign="top"><b>Sub Total</b></td>
                                                  <td width="" align="center" valign="top"><b>Discount</b></td>
                                                  <td width="" align="center" valign="top"><b>VAT</b></td>
                                                  <td width="" align="center" valign="top"><b>Receivables Total</b></td>
                                                  <td width="" align="center" valign="top"><b>Paid Amount</b></td>
                                                  <td width="" align="center" valign="top"><b>PPH</b></td>
                                                  <td width="" align="center" valign="top"><b>Ending Balance</b></td>
                                                  <td width="" align="center" valign="top"><b>Ending Balance in IDR</b></td>
                                              </tr>
                                          </thead>
                                          <tbody>
                                            <tr style="font-size:8.4pt;" class="nowrap">
                                              <td width="" align="left" valign="top" style="padding-left:8px;">{{ 'transaction number' }}</td>
                                              <td width="" align="center" valign="top">{{ 'transaction date d/m/Y' }}</td>
                                              <td width="" align="left" valign="top">{{ 'transaction number' }}</td>
                                              <td width="" align="left" valign="top">{{ 'Exchange rate' }}</td>
                                              <td width="" align="left" valign="top">{{ 'description' }}</td>
                                              <td width="" align="right" valign="top">{{ 'symbol' }}</td>
                                              <td width="" align="right" valign="top">{{ 'subtotal' }}</td>
                                              <td width="" align="right" valign="top"></td>
                                              <td width="" align="right" valign="top"></td>
                                              <td width="" align="right" valign="top" >0</td>
                                              <td width="" align="right" valign="top"></td>
                                              <td width="" align="right" valign="top">0</td>
                                              <td width="" align="right" valign="top"></td>
                                              <td width="" align="right" valign="top"></td>
                                            </tr>
                                            {{-- Total IDR --}}
                                            <tr style="border-top:2px solid black; font-size:9pt;" >
                                                <td colspan="5"></td>
                                                <td align="left" valign="top" colspan="1"><b>Total </b></td>
                                                <td width=""align="right" valign="top" class="table-footer"><b></b></td>
                                                <td width="" align="right" valign="top" class="table-footer"><b></b></td>
                                                <td width="" align="right" valign="top" class="table-footer"><b></b></td>
                                                <td width="" align="right" valign="top" class="table-footer"><b></b></td>
                                                <td width="" align="right" valign="top" class="table-footer"><b></b></td>
                                                <td width="" align="right" valign="top" class="table-footer"><b></b></td>
                                                <td width="" align="right" valign="top" class="table-footer"><b></b></td>
                                                <td width="" align="right" valign="top"></td>
                                            </tr>
                                            
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                            @endforeach
                            {{-- end content --}}

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

                                      <a href="" target="_blank" class="btn btn-success btn-md text-light" style="cursor: pointer">
                                        <span>
                                          <i class="fa fa-file-excel"></i>
                                          <span>Export to Excel</span>
                                        </span>
                                      </a>

                                      <a href="{{route('fa-report.index')}}" class="btn btn-secondary btn-md" >
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
