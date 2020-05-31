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
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h5 class="m-portlet__head-text">
                                Jaya Wijaya, PT
                            </h5>
                            <hr>
                            <h6 class="m-portlet__head-text">
                                Project Information : <br>
                                <span style="font-size:11px; color:#454545">
                                    Perform Loan hangar space for support replace drag here brace & inspection C-Check
                                </span>
                            </h6>
                        </div>
                    </div>
                    <table class="mt-4" width="100%" cellpadding="4" style="font-size:12px">
                        <tr valign="top">
                            <td width="30%">Project No</td>
                            <td width="1%">:</td>
                            <td><b>PROJ-2020/03/00001</b></td>
                        </tr>
                        <tr valign="top">
                            <td width="30%">Quotaion No</td>
                            <td width="1%">:</td>
                            <td><b>QPRO-2020/03/00001</b></td>
                        </tr>
                        <tr valign="top">
                            <td width="30%">Work Order No</td>
                            <td width="1%">:</td>
                            <td><b>12/TSP/I/20/B723-200</b></td>
                        </tr>
                        <tr valign="top">
                            <td width="30%">A/C Type</td>
                            <td width="1%">:</td>
                            <td><b>B737-500</b></td>
                        </tr>
                        <tr valign="top">
                            <td width="30%">A/C Reg</td>
                            <td width="1%">:</td>
                            <td><b>PK-CNY</b></td>
                        </tr>
                        <tr valign="top">
                            <td width="30%">A/C SN</td>
                            <td width="1%">:</td>
                            <td><b>544323</b></td>
                        </tr>
                        <tr valign="top">
                            <td width="30%">Status</td>
                            <td width="1%">:</td>
                            <td><b>Closed</b></td>
                        </tr>
                        <tr valign="top">
                            <td width="30%">Project Start</td>
                            <td width="1%">:</td>
                            <td><b>2020/03/01</b></td>
                        </tr>
                        <tr valign="top">
                            <td width="30%">Project End</td>
                            <td width="1%">:</td>
                            <td><b>2020/03/23</b></td>
                        </tr>
                        <tr valign="top">
                            <td width="30%">Quotation Approval</td>
                            <td width="1%">:</td>
                            <td><b>Elly Sugigi</b></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="m-portlet  m-portlet--full-height">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                               Profit & Loss Project Summary
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
                            <li class="nav-item m-tabs__item">
                                @component('buttons::create-new')
                                    @slot('type', 'button')
                                    @slot('size', 'sm')
                                    @slot('color', 'success')
                                    @slot('icon', 'rotate-left')
                                    @slot('text', 'Update')
                                    @slot('id','update')
                                @endcomponent
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="row  align-items-center mt-2">
                        <div class="col">
                            <div id="m_chart_profit_share" class="m-widget14__chart" style="height: 160px"></div>
                        </div>
                        <div class="col">
                            <div class="m-widget14__legends">
                                <div class="m-widget14__legend text-danger">
                                    <span style="font-size:16px">Total Net Profit : <br></span>
                                    <span class="font-weight-bold" style="font-size:18px;">IDR 190.363.323.231</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-6 text-primary">
                            <div class="m-widget__legends">
                                <div class="m-widget__legend">
                                    <span class="m-widget__legend-bullet m--bg-accent"></span>
                                    <span class="m-widget__legend-text text-primary">87%</span>
                                </div>
                            </div>
                            <p>Income Total : <br> <span class="font-weight-bold" style="font-size:16px">IDR 112.232.123.123</span></p> 
                        </div>
                        <div class="col-6 text-primary" style="border-left:1px solid black;">
                            <div class="m-widget__legends">
                                <div class="m-widget__legend">
                                    <span class="m-widget__legend-bullet m--bg-warning"></span>
                                    <span class="m-widget__legend-text text-primary">13%</span>
                                </div>
                            </div>
                            <p>Expense Total : <br> <span class="font-weight-bold" style="font-size:16px">IDR 90.232.123.123</span></p> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                               Profit & Loss Project Summary
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
                            <li class="nav-item m-tabs__item">
                                @component('buttons::create-new')
                                    @slot('type', 'button')
                                    @slot('size', 'sm')
                                    @slot('color', 'success')
                                    @slot('icon', 'rotate-left')
                                    @slot('text', 'Update')
                                    @slot('id','update')
                                @endcomponent
                            </li>
                        </ul>
                    </div>
                </div>
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
                                    @slot('size', 'sm')
                                    @slot('color', 'success')
                                    @slot('icon', 'rotate-left')
                                    @slot('text', 'Update')
                                    @slot('id','update')
                                @endcomponent
                            </li>
                            <li class="pl-4 mt-2 m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
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
            <div class="m-portlet m-portlet--full-height">
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
                                    @slot('size', 'sm')
                                    @slot('color', 'success')
                                    @slot('icon', 'rotate-left')
                                    @slot('text', 'Update')
                                    @slot('id','update')
                                @endcomponent
                            </li>
                            <li class="pl-4 mt-2 m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
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
        .m-widget__legend-bullet{
            width: 5.5rem;
            height: 0.45rem;
            display: inline-block;
            border-radius: 1.1rem;
            margin: 0 1rem 0.1rem 0;
        }
    </style>
@endpush

@push('footer-scripts')
    <script src="{{ asset('vendor/courier/app/js/dashboard.js')}}"></script>
@endpush
