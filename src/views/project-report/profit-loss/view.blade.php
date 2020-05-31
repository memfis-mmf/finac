@extends('frontend.master')

@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Profit & Loss Project
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
                            Profit & Loss Project
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="m-content">    
    <div class="row">
        <div class="col-xl-4">
            <div class="m-portlet m-portlet--full-height ">
                <div class="m-portlet__body">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-5">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                               Profit & Loss Statement
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
                            <li class="nav-item m-tabs__item">
                                @component('buttons::create-new')
                                    @slot('type', 'button')
                                    @slot('color', 'success')
                                    @slot('icon', 'rotate-left')
                                    @slot('text', 'Update')
                                    @slot('id','update')
                                @endcomponent
                            </li>
                            <li class="pl-4 mt-3 m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                                <a href="#" class="m-portlet__nav-link m-portlet__nav-link--icon m-portlet__nav-link--icon-xl m-dropdown__toggle">
                                    <i class="la la-ellipsis-h m--font-brand"></i>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav">
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                        <i class="m-nav__link-icon la la-file-excel-o"></i>
                                                        <span class="m-nav__link-text">Export to Excel</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                        <i class="m-nav__link-icon la la-print"></i>
                                                        <span class="m-nav__link-text">Print Document</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                        <i class="m-nav__link-icon la la-search"></i>
                                                        <span class="m-nav__link-text">View Details</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table class="table table-bordered table-striped mb-0" style="font-size:12px">
                            <tbody>
                                @for ($i = 0; $i < 5; $i++)
                                    <tr>
                                        <th scope="row" valign="top" width="55%">MMF - Maintenance Revenue</th>
                                        <td valign="top"  width="1%">:</td>
                                        <td valign="top" align="right">1.000.000.000.000</td>
                                    </tr>
                                @endfor
                                <tr class="text-danger">
                                    <th scope="row" valign="top" width="55%">Total Revenue</th>
                                    <td valign="top"  width="1%">:</td>
                                    <td valign="top" align="right">1.000.000.000.000</td>
                                </tr>
                                @for ($i = 0; $i < 3; $i++)
                                    <tr>
                                        <th scope="row" valign="top" width="55%">MMF - Maintenance Revenue</th>
                                        <td valign="top"  width="1%">:</td>
                                        <td valign="top" align="right">1.000.000.000.000</td>
                                    </tr>
                                @endfor
                                <tr class="text-warning">
                                    <th scope="row" valign="top" width="55%">Total Expense</th>
                                    <td valign="top"  width="1%">:</td>
                                    <td valign="top" align="right">1.000.000.000.000</td>
                                </tr>
                                <tr class="text-success" style="font-size:16px">
                                    <th scope="row" valign="top" width="55%">Net Profit</th>
                                    <td valign="top"  width="1%">:</td>
                                    <td valign="top" align="right">1.000.000.000.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <i class="fa fa-info-circle fa-4x text-danger"></i>
                    <span class="text-danger">All Amount Should be in IDR</span>
                </div>
            </div>
        </div>
        <div class="col-xl-7">
            <div class="m-portlet m-portlet--full-height ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Inventory Expense Details
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
                            <li class="nav-item m-tabs__item">
                                @component('buttons::create-new')
                                    @slot('type', 'button')
                                    @slot('color', 'success')
                                    @slot('icon', 'rotate-left')
                                    @slot('text', 'Update')
                                    @slot('id','update')
                                @endcomponent
                            </li>
                            <li class="pl-4 mt-3 m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                                <a href="#" class="m-portlet__nav-link m-portlet__nav-link--icon m-portlet__nav-link--icon-xl m-dropdown__toggle">
                                    <i class="la la-ellipsis-h m--font-brand"></i>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav">
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                        <i class="m-nav__link-icon la la-file-excel-o"></i>
                                                        <span class="m-nav__link-text">Export to Excel</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                        <i class="m-nav__link-icon la la-print"></i>
                                                        <span class="m-nav__link-text">Print Document</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table class="table table-bordered table-striped mb-0"  style="font-size:12px">
                            <thead class="bg-primary text-white text-center">
                                <tr>
                                    <th scope="col" width="25%">Inventory Out</th>
                                    <th scope="col" width="14%">Part Number</th>
                                    <th scope="col" width="30%" align="center">Item Name</th>
                                    <th scope="col" align="center">Qty</th>
                                    <th scope="col" align="center">Unit</th>
                                    <th scope="col" align="center">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < 20; $i++)
                                    <tr>
                                        <th vallign="top" scope="row">MTRQ-YYYY/MM/00001</th>
                                        <td vallign="top">61123123</td>
                                        <td vallign="top">3M RADIAL BRISTAL DISC 2-231</td>
                                        <td vallign="top" align="center">10</td>
                                        <td vallign="top" align="center">Each</td>
                                        <td vallign="top" align="right">500.000.000.000</td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                    <i class="fa fa-info-circle fa-4x text-danger"></i>
                    <span class="text-danger">All Amount Should be in IDR</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('header-scripts')
    <style>
        .my-custom-scrollbar {
            position: relative;
            height: 400px;
            overflow: auto;
        }
        .table-wrapper-scroll-y {
            display: block;
        }
    </style>
@endpush

@push('footer-scripts')
@endpush
