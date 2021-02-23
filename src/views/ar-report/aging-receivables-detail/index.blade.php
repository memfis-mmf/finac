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
                                 <h4>Period : 01 January 2018 - 28 January 2020</h4>
                                </div>
                            </div>
                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <table width="100%" cellpadding="3">
                                        <tr>
                                            <td class="nowrap" valign="top" width="1px">MMF Department</td>
                                            <td class="nowrap" valign="top" width="1px">:</td>
                                            <td  valign="top">MMF Department</td>
                                        </tr>
                                        <tr>
                                            <td>MMF Location</td>
                                            <td>:</td>
                                            <td>Sidoarjo</td>
                                        </tr>
                                        <tr>
                                            <td>Currency</td>
                                            <td>:</td>
                                            <td>IDR</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12" style="overflow: auto">   
                                    <table width="100%" cellpadding="4" class="table-body" page-break-inside: auto;>  
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
                                            @for ($i = 0; $i < 50; $i++)
                                                <tr>
                                                    <td class="nowrap" align="left" valign="top" style="padding-left:8px;">Sriwijaya Air</td>
                                                    <td class="nowrap" align="center" valign="top">Testing Account (111423)</td>
                                                    <td class="nowrap" align="right" valign="top" >Rp </td>
                                                    <td class="nowrap" align="right" valign="top">1.232.232,00</td>
                                                    <td class="nowrap" align="right" valign="top" >Rp </td>
                                                    <td class="nowrap" align="right" valign="top">1.232.232,00</td>
                                                    <td class="nowrap" align="right" valign="top" > Rp </td>
                                                    <td class="nowrap" align="right" valign="top"> 1.232.232,00</td>
                                                    <td class="nowrap" align="right" valign="top" > Rp </td>
                                                    <td class="nowrap" align="right" valign="top"> 1.232.232,00</td>
                                                    <td class="nowrap" align="right" valign="top" >Rp </td>
                                                    <td class="nowrap" align="right" valign="top">1.232.232,00</td>
                                                </tr>
                                            @endfor

                                            <tr>
                                                <td align="center" valign="top" colspan="2"><b>Total</b></td>
                                                <td align="right" valign="top"><b>Rp </b></td>
                                                <td align="right" valign="right"><b>1.232.232.000,00</b></td>
                                                <td align="right" valign="top"><b>Rp </b></td>
                                                <td align="right" valign="right"><b>1.232.232.000,00</b></td>
                                                <td align="right" valign="top"><b>Rp </b></td>
                                                <td align="right" valign="right"><b>1.232.232.000,00</b></td>
                                                <td align="right" valign="top"><b> Rp </b></td>
                                                <td align="right" valign="right"><b>1.232.232.000,00</b></td>
                                                <td align="right" valign="top"><b>Rp </b></td>
                                                <td align="right" valign="right"><b>1.232.232.000,00</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
