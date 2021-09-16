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
        <div class="col-md-4">
            <div class="m-portlet m-portlet--full-height ">
                <div class="m-portlet__body">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-badge m-badge--primary m-badge--wide" style="padding: 6px 10px 1px 10px;">
                                <b><h4>{{ $main_project->customer->name }}</h4></b>
                            </span>
                            <hr>
                            <h6 class="m-portlet__head-text">
                                Project Information : <br>
                                {{-- <span style="font-size:11px; color:#454545">
                                    Perform Loan hangar space for support replace drag here brace & inspection C-Check
                                </span> --}}
                            </h6>
                        </div>
                    </div>
                    <table class="mt-4" width="100%" cellpadding="4" style="font-size:12px">
                        <tr valign="top">
                            <td width="30%">Project No</td>
                            <td width="1%">:</td>
                            <td><b>{{ $main_project->code }}</b></td>
                        </tr>
                        <tr valign="top">
                            <td width="30%">Quotaion No</td>
                            <td width="1%">:</td>
                            <td><b>{{ $main_project->quotation->number }}</b></td>
                        </tr>
                        <tr valign="top">
                            <td width="30%">Work Order No</td>
                            <td width="1%">:</td>
                            <td><b>{{ $main_project->no_wo }}</b></td>
                        </tr>
                        <tr valign="top">
                            <td width="30%">A/C Type</td>
                            <td width="1%">:</td>
                            <td><b>{{ $main_project->aircraft->code }}</b></td>
                        </tr>
                        <tr valign="top">
                            <td width="30%">A/C Reg</td>
                            <td width="1%">:</td>
                            <td><b>{{ $main_project->aircraft_register }}</b></td>
                        </tr>
                        <tr valign="top">
                            <td width="30%">A/C SN</td>
                            <td width="1%">:</td>
                            <td><b>{{ $main_project->aircraft_sn }}</b></td>
                        </tr>
                        <tr valign="top">
                            <td width="30%">Status</td>
                            <td width="1%">:</td>
                            <td><b>{{ $main_project->status }}</b></td>
                        </tr>
                        {{-- <tr valign="top">
                            <td width="30%">Project Start</td>
                            <td width="1%">:</td>
                            <td><b>2020/03/01</b></td>
                        </tr>
                        <tr valign="top">
                            <td width="30%">Project End</td>
                            <td width="1%">:</td>
                            <td><b>2020/03/23</b></td>
                        </tr> --}}
                        <tr valign="top">
                            <td width="30%">Quotation Approval</td>
                            <td width="1%">:</td>
                            <td><b>{{ $main_project->quotation->approvals->first()->conductedBy->full_name }}</b></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col">
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
                            <div id="pie_chart" class="m-widget14__chart" style="height: 160px"></div>
                        </div>
                        <div class="col">
                            <div class="m-widget14__legends">
                                <div class="m-widget14__legend text-danger">
                                    <span style="font-size:16px">Total Net Profit : <br></span>
                                    <span class="font-weight-bold" style="font-size:18px;">IDR {{ number_format($total_revenue - $total_expense, 2, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-6 text-primary">
                            <div class="m-widget__legends">
                                <div class="m-widget__legend">
                                    <span class="m-widget__legend-bullet" style="background: rgb(113, 106, 202)"></span>
                                    <span class="m-widget__legend-text text-primary">{{ $total_revenue_percent }}%</span>
                                </div>
                            </div>
                            <p>Income Total : <br> <span class="font-weight-bold" style="font-size:16px">IDR {{ number_format($total_revenue, 2, ',', '.') }}</span></p> 
                        </div>
                        <div class="col-6 text-primary" style="border-left:1px solid black;">
                            <div class="m-widget__legends">
                                <div class="m-widget__legend">
                                    <span class="m-widget__legend-bullet m--bg-warning"></span>
                                    <span class="m-widget__legend-text text-primary">{{ $total_expense_percent }}%</span>
                                </div>
                            </div>
                            <p>Expense Total : <br> <span class="font-weight-bold" style="font-size:16px">IDR {{ number_format($total_expense, 2, ',', '.') }}</span></p> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
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
                    <div id="m_morris_3" style="height:290px;"></div>
                    <div class="row">
                        <div class="col-4">
                            <i class="fa fa-info-circle fa-4x text-danger"></i>
                            <span class="text-danger">All Amount in IDR</span>
                        </div>
                        <div class="col-8">
                            <span class="m-widget__legend-bullet" style="background: rgb(113, 106, 202)"></span>
                            <span class="m-widget__legend-text text-primary">Revenue</span>
                            <span class="m-widget__legend-bullet m--bg-warning ml-3"></span>
                            <span class="m-widget__legend-text text-primary">Expense</span>
                        </div>
                    </div>
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
                                                        <a href="{{ route('profit-loss-project') }}/?project_uuid={{ Request::get('project') }}" target="_blank" class="m-nav__link">
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
                        <table class="table table-bordered table-striped mb-0" style="font-size:12px">
                            <tbody>
                                {{-- REVENUE --}}
                                @foreach ($revenue as $revenue_row)
                                    <tr>
                                        <th scope="row" valign="top" width="55%">{{ $revenue_row->name }}</th>
                                        <td valign="top"  width="1%">:</td>
                                        <td valign="top" align="right">{{ number_format($revenue_row->value, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                <tr class="text-danger">
                                    <th scope="row" valign="top" width="55%">Total Revenue</th>
                                    <td valign="top"  width="1%">:</td>
                                    <td valign="top" align="right">{{ number_format($total_revenue, 2, ',', '.') }}</td>
                                </tr>
                                @foreach ($expense as $expense_row)
                                    <tr>
                                        <th scope="row" valign="top" width="55%">{!! $expense_row->name !!}</th>
                                        <td valign="top"  width="1%">:</td>
                                        <td valign="top" align="right">{{ number_format($expense_row->value, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                <tr class="text-warning">
                                    <th scope="row" valign="top" width="55%">Total Expense</th>
                                    <td valign="top"  width="1%">:</td>
                                    <td valign="top" align="right">{{ number_format($total_expense, 2, ',', '.') }}</td>
                                </tr>
                                <tr class="text-success" style="font-size:16px">
                                    <th scope="row" valign="top" width="55%">Net Profit</th>
                                    <td valign="top"  width="1%">:</td>
                                    <td valign="top" align="right">{{ number_format($total_revenue - $total_expense, 2, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <i class="fa fa-info-circle fa-4x text-danger"></i>
                    <span class="text-danger">All Amount in IDR</span>
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
                                                        <a href="{{ route('inventory-expense-details') }}/?project_uuid={{ Request::get('project') }}" target="_blank" class="m-nav__link">
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
                                @foreach ($main_project->items as $item_index => $item_row)
                                    <tr>
                                        <th vallign="top" scope="row">{{ $item_row->transaction_number }}</th>
                                        <td vallign="top">{{ $item_row->code }}</td>
                                        <td vallign="top">{{ $item_row->name }}</td>
                                        <td vallign="top" align="center">{{ $item_row->quantity }}</td>
                                        <td vallign="top" align="center">{{ $item_row->unit->name }}</td>
                                        <td vallign="top" align="right">{{ number_format($item_row->price, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <i class="fa fa-info-circle fa-4x text-danger"></i>
                    <span class="text-danger">All Amount in IDR</span>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group m-form__group row ">
        <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
            <div class="action-buttons">
              <a href="{{ route('project-report.profit-loss.view.additional', $request) }}" class="btn btn-primary btn-md add" style="" target="" data-uuid="">

                <span>
                    <i class="fa fa-search"></i>

                    <span>Additional Project</span>
                </span>
              </a>

                @component('buttons::submit')
                    @slot('type', 'button')
                    @slot('color', 'success')
                    @slot('icon', 'fa-redo')
                    @slot('text', 'Update')
                    @slot('id', 'update')
                @endcomponent

                <a href="{{ route('project-report.profit-loss.index') }}" class="btn btn-secondary btn-md" style="">
                    <span>
                        <i class="la la-undo"></i>
                    </span>

                    Back
                </a>
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
        rect:nth-child(odd) {
            fill: rgb(113, 106, 202);
        }
        rect:nth-child(even) {
            fill: #ffb822;
        }
    </style>
@endpush

@push('footer-scripts')
    <script src="{{ asset('vendor/courier/app/js/dashboard.js')}}"></script>
    <script>
    var MorrisCharts = {
        init: function() {
            _data = '{!! $bar_chart !!}';

            _data = _data.split('<>');

            data_morris_bar = [];

            for (var i in _data) {
                var obj = JSON.parse(_data[i]);
                data_morris_bar.push(obj);
            }

            new Morris.Bar({
                element: "m_morris_3",
                data: data_morris_bar,
                xkey: "y",
                ykeys: ["a", "b"],
                labels: ["Revenue", "Expense"]
            });

            new Chartist.Pie(
                "#pie_chart",
                {
                    series: [
                        {
                            value: '{{ $total_revenue }}',
                            className: "custom",
                            meta: { color: mApp.getColor("accent") }
                        },
                        {
                            value: '{{ $total_expense }}',
                            className: "custom",
                            meta: { color: mApp.getColor("warning") }
                        }
                    ],
                    labels: [1, 2]
                },
                { donut: !0, donutWidth: 17, showLabel: !1 })
              .on("draw", function(e) {
                if ("slice" === e.type) {
                    var t = e.element._node.getTotalLength();
                    e.element.attr({
                        "stroke-dasharray": t + "px " + t + "px"
                    });
                    var a = {
                        "stroke-dashoffset": {
                            id: "anim" + e.index,
                            dur: 1e3,
                            from: -t + "px",
                            to: "0px",
                            easing: Chartist.Svg.Easing.easeOutQuint,
                            fill: "freeze",
                            stroke: e.meta.color
                        }
                    };
                    0 !== e.index &&
                        (a["stroke-dashoffset"].begin =
                            "anim" + (e.index - 1) + ".end"),
                        e.element.attr({
                            "stroke-dashoffset": -t + "px",
                            stroke: e.meta.color
                        }),
                        e.element.animate(a, !1);
                }
            })
        }
    };
    jQuery(document).ready(function() {
        MorrisCharts.init();

        $(document).on('click', '#update', function () {
            location.reload();
        });
    });
    </script>
@endpush
