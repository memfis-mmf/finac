@extends('frontend.master')

@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                View Profit & Loss
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
                            View Profit & Loss
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

                            <h3 class="m-portlet__head-text">
                                Detail Profit & Loss
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h3>Date Period 12/12/12 - 12/12/20</h3>
                                </div>
                            </div>
                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <table width="100%" cellpadding="8">
                                        <tr style="background:#5f6b5e; color:white;font-weight: bold;">
                                            <td width="60%">Account Name</td>
                                            <td width="20%" align="center">Accumulated</td>
                                            <td width="20%" align="center">Periods</td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:3px solid black">
                                            <td width="60%"><h3>Revenue</h3></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="60%"><h4>Operating Revenue</h4></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">MMF - Heavy Maintenance Revenue</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">MMF - Workshop Revenue</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">MMF - Rental Hangar Revenue</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">MMF - Other Revenue</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">MMF - Workshop Jakarta</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="60%"><h4>Sales Discount</h4></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Sales Discount</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:3px solid black">
                                            <td width="60%"><h3>Non Operating Revenue (Expense)</h3></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="60%"><h4>Non Operating Revenue</h4></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Interest Income</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Exchange Rate Gap Income</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Other Income</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="background:#add8f7;font-weight: bold;">
                                            <td width="60%"><h5>Total Revenue</h5></td>
                                            <td width="20%" align="center">Amount</td>
                                            <td width="20%" align="center">Amount</td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:3px solid black">
                                            <td width="60%"><h3>Cost Of Gold</h3></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="60%"><h4>Production Expenses</h4></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Depreciation Expense</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Insurance Expanses</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Fuel Expenses</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Overhaul Expenses</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="60%"><h4>Maintenance & Repair Expenses</h4></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Maintenance & Repair Expenses</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Maintenance & Repair Expenses Jakarta</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Joint Operation & Third Party Expense</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="60%"><h4>Direct Labor</h4></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Salary - Technicians</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Allowance & Overtime - Technicians</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Duty Trip Expense - Technicians</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Training Expense</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="60%"><h4>Distribution Cost</h4></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Expedition, Freight & Inclaring</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Landing Fees & Route Charges</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Ground Handling</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:3px solid black">
                                            <td width="60%"><h3>Operating Expenses</h3></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="60%"><h4>Sales Cost</h4></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Commision</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Promotion</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Salary - Sales</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Allowances & Overtime - Sales</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Duty Trip Expense - Sales</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Training Expenses - Sales</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="60%"><h4>Organization Expense</h4></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Allowances & Overtime - Administration</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Salary - Administration</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Duty Trip Expense - Administration</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Training & Recruitment Exp. - Administration</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="60%"><h4>General Expense</h4></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%"><b>Maintenance & Repair Expense</b></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Maintenance & Repair Vehicle</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Maintenance & Repair Building</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Maintenance & Repair Equipment</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Rental Expenses</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="60%"><h4>Office Cost</h4></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Electricity, Water, Gas, Telephone</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Supplies Expenses</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Office Operation</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Outsourcing Expenses</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Research & Development Expenses</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Office Operation Jakarta</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Public Relation Expenses</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Tax Expenses</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="60%"><h4>Depreciation & Amortization Expense</h4></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Depreciation Expenses</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Amortization Expenses</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="60%"><h4>Other Expense</h4></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Removing Receivable Expanses</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:3px solid black">
                                            <td width="60%"><h3>Non Operating Expenses</h3></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="60%"><h4>Non Operating Expenses MMF</h4></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Bank & Non Bank Expenses</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Exchange Rate Gap Income</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Pinalty & Tax Expenses</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Others Expenses</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="background:#add8f7;font-weight: bold;">
                                            <td width="60%"><h5>Total Revenue</h5></td>
                                            <td width="20%" align="center">Amount</td>
                                            <td width="20%" align="center">Amount</td>
                                        </tr>
                                    </table>

                                    <div class="form-group m-form__group row mt-5">
                                        <div class="col-sm-7 col-md-7 col-lg-7">
                                            <h4 class="text-right">Calculated Return</h4>
                                        </div>
                                        <div class="col-sm-5 col-md-5 col-lg-5">
                                            <table width="100%">
                                                <tr>
                                                    <td align="center" width="50%">
                                                        <h4>Amount</h4>
                                                    </td>
                                                    <td align="center" width="50%">
                                                        <h4>Amount</h4>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                                    <div class="action-buttons">
                                        @component('buttons::submit')
                                            @slot('type', 'button')
                                            @slot('id','printview')
                                            @slot('text','Print')
                                            @slot('icon','fa-print')
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

@endsection

@push('footer-scripts')

@endpush
