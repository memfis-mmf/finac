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
                                View Profit & Loss
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
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="60%"><h3>Revenue</h3></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Operating Revenue</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Sales Discount</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="60%"><h3>Non Operating Revenue (Expense)</h3></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Non Operating Revenue</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="background:#add8f7;font-weight: bold;">
                                            <td width="60%"><h5>Total Revenue</h5></td>
                                            <td width="20%" align="center">Amount</td>
                                            <td width="20%" align="center">Amount</td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="60%"><h3>Cost Of Gold</h3></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Production Expenses</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Maintenance & Repair Expense</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Direct Labor</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Distribution Cost</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="60%"><h3>Operating Expense</h3></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Sales Cost</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Organization Expense</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">General Expenses</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Office Cost</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Depreciation & Amortization Expense</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Other Expense</td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="60%"><h3>Non Operating Expenses</h3></td>
                                            <td width="20%" align="center"></td>
                                            <td width="20%" align="center"></td>
                                        </tr>
                                        <tr>
                                            <td width="60%">Non Operating Expenses MMF</td>
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
