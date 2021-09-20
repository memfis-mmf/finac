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
                                Aging Receivable
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                 <h1>AGING RECEIVABLE</h1>
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
                                <div class="col-sm-12 col-md-12 col-lg-12" style="overflow: auto">   
                                    <table class="table table-bordered">  
                                        <thead style="border-bottom:2px solid black;">     
                                            <tr>
                                                <td align="left" valign="top" style="padding-left:8px;"><b>Customer Name</b></td>
                                                <td align="center" valign="top"><b>Account</b></td>
                                                <td align="center" valign="top" colspan="2" style="color:red;"><i><b>1-6 Months</b></i></td>
                                                <td align="center" valign="top"  colspan="2" style="color:red;"><i><b>7-12 Months</b></i></td>
                                                <td align="center" valign="top"  colspan="2" style="color:red;"><i><b> 1 Year</b></i></td>
                                                <td align="center" valign="top"  colspan="2" style="color:red;"><i><b> 2 Year</b></i></td>
                                                <td align="center" valign="top"  colspan="2"><i><b>Total Balance</b></i></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          @foreach ($data as $customer_row)
                                            <tr>
                                              <td class="nowrap" align="left" valign="top" style="padding-left:8px;">{{ $customer_row->name }}</td>
                                              <td class="nowrap" align="center" valign="top">{{ $customer_row->coa_formated }}</td>
                                              <td class="nowrap" align="right" valign="top" >{{ $currency->symbol }} </td>
                                              <td class="nowrap" align="right" valign="top">{{ $class::currency_format($customer_row->invoice1_6) }}</td>
                                              <td class="nowrap" align="right" valign="top" >{{ $currency->symbol }} </td>
                                              <td class="nowrap" align="right" valign="top">{{ $class::currency_format($customer_row->invoice7_12) }}</td>
                                              <td class="nowrap" align="right" valign="top" > {{ $currency->symbol }} </td>
                                              <td class="nowrap" align="right" valign="top">{{ $class::currency_format($customer_row->invoice_1) }}</td>
                                              <td class="nowrap" align="right" valign="top" > {{ $currency->symbol }} </td>
                                              <td class="nowrap" align="right" valign="top">{{ $class::currency_format($customer_row->invoice_2) }}</td>
                                              <td class="nowrap" align="right" valign="top" >{{ $currency->symbol }} </td>
                                              <td class="nowrap" align="right" valign="top">{{ $class::currency_format($customer_row->balance) }}</td>
                                            </tr>
                                            @php
                                                $total1_6 += $customer_row->invoice1_6;
                                                $total7_12 += $customer_row->invoice7_12;
                                                $total_1 += $customer_row->invoice_1;
                                                $total_2 += $customer_row->invoice_2;
                                                $total_balance += $customer_row->balance;
                                            @endphp
                                          @endforeach
                                          <tr>
                                            <td colspan="11" style="height: 30px"></td>
                                          </tr>
                                          <tr>
                                              <td align="center" valign="top" colspan="2"><b>Total</b></td>
                                              <td align="right" valign="top"><b>{{ $currency->symbol }} </b></td>
                                              <td align="right" valign="right"><b>{{ $class::currency_format($total1_6) }}</b></td>
                                              <td align="right" valign="top"><b>{{ $currency->symbol }} </b></td>
                                              <td align="right" valign="right"><b>{{ $class::currency_format($total7_12) }}</b></td>
                                              <td align="right" valign="top"><b>{{ $currency->symbol }} </b></td>
                                              <td align="right" valign="right"><b>{{ $class::currency_format($total_1) }}</b></td>
                                              <td align="right" valign="top"><b> {{ $currency->symbol }} </b></td>
                                              <td align="right" valign="right"><b>{{ $class::currency_format($total_2) }}</b></td>
                                              <td align="right" valign="top"><b>{{ $currency->symbol }} </b></td>
                                              <td align="right" valign="right"><b>{{ $class::currency_format($total_balance) }}</b></td>
                                          </tr>
                                        </tbody>
                                    </table>
                                </div>
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

@endsection
