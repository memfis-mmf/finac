@extends('frontend.master')

@section('faReport', 'm-menu__item--active')
@section('content')
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
                                Outstanding Invoice
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                 <h1>OUTSTANDING INVOICE</h1>
                                 <h4>As of Date. 28 January 2020</h4>
                                </div>
                            </div>
                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <table width="100%" cellpadding="3">
                                        <tr>
                                            <td width="12%" valign="top">MMF Department</td>
                                            <td width="1%" valign="top">:</td>
                                            <td width="77%" valign="top">MMF Department</td>
                                        </tr>
                                        <tr>
                                            <td>MMF Location</td>
                                            <td>:</td>
                                            <td>Sidoarjo</td>
                                        </tr>
                                        <tr>
                                            <td>Currency</td>
                                            <td>:</td>
                                            <td>All</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12">   
                                    <table width="100%" cellpadding="3" class="table-head">
                                        <tr>
                                            <td width="12%" valign="top"><b>Customer Name</b></td>
                                            <td width="1%" valign="top"><b>:</b></td>
                                            <td width="77%" valign="top"><b>Sriwijaya Air, PT</b></td>
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
                                                <td width="9%"align="center" valign="top"  colspan="2"><b>Sub Total Invoice</b></td>
                                                <td width="13%"align="center" valign="top"  colspan="2"><b>VAT</b></td>
                                                <td width="13%"align="center" valign="top"  colspan="2"><b>Ending Balance</b></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for ($i = 0; $i <6; $i++)
                                                <tr>
                                                    <td width="19%" align="left" valign="top" style="padding-left:8px;">INVC-YYYY/MM/00001</td>
                                                    <td width="8%"align="center" valign="top">10/01/2020</td>
                                                    <td width="8%"align="center" valign="top">17/01/2020</td>
                                                    <td width="17%"align="left" valign="top">QPRO-YYYY/MM/00001</td>
                                                    <td width="4%"align="center" valign="top">USD</td>
                                                    <td width="1%" align="right" valign="top">Rp.</td>
                                                    <td width="5%"align="left" valign="top">14.000</td>
                                                    <td width="1%" align="right" valign="top">$</td>
                                                    <td width="8%"align="right" valign="top" >89.000,00</td>
                                                    <td width="1%" align="right" valign="top">Rp.</td>
                                                    <td width="12%"align="right" valign="top">1.142.680.000,00</td>
                                                    <td width="1%" align="right" valign="top">Rp.</td>
                                                    <td width="12%"align="right" valign="top">114.268.000,00</td>
                                                </tr>
                                            @endfor
                                            {{-- Total IDR --}}
                                            <tr style="border-top:2px solid black;" >
                                                <td colspan="5"></td>
                                                <td align="left" valign="top" colspan="2"><b>Total IDR</b></td>
                                                <td width="1%" align="right" valign="top" class="table-footer"><b>Rp.</b></td>
                                                <td width="12%"align="right" valign="top" class="table-footer"><b>1.142.680.000,00</b></td>
                                                <td width="1%" align="right" valign="top" class="table-footer"><b>Rp.</b></td>
                                                <td width="12%" align="right" valign="top" class="table-footer"><b>114.268.000,00</b></td>
                                                <td width="1%" align="right" valign="top" class="table-footer"><b>Rp.</b></td>
                                                <td width="12%"align="right" valign="top" class="table-footer"><b>114.268.000,00</b></td>
                                            </tr>
                                            {{-- Total USD --}}
                                            <tr>
                                                <td colspan="5"></td>
                                                <td align="left" valign="top" colspan="2"><b>Total USD</b></td>
                                                <td width="1%" align="right" valign="top"><b>$</b></td>
                                                <td width="12%"align="right" valign="top"><b>1.142.680.000,00</b></td>
                                                <td width="1%" align="right" valign="top"><b>$.</b></td>
                                                <td width="12%" align="right" valign="top"><b>114.268.000,00</b></td>
                                                <td width="1%" align="right" valign="top"><b>$.</b></td>
                                                <td width="12%"align="right" valign="top"><b>114.268.000,00</b></td>
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
