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
                                    <h3>Date Period {{ date('d/m/y', strtotime($beginDate)) }} -
                                        {{ date('d/m/y', strtotime($endingDate)) }}</h3>
                                </div>
                            </div>
                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <table width="100%" cellpadding="8">
                                        <tr style="background:#5f6b5e; color:white;font-weight: bold;font-size:16px">
                                        <td width="25%">Account Code</td>
                                            <td width="55%">Account Name</td>
                                            <td width="10%" align="right">Accumulated</td>
                                            <td width="10%" align="right">Period</td>
                                        </tr>
                                        @for ($a=0; $a < count($data['pendapatan']); $a++) @php
                                            $x=$data['pendapatan'][$a]; @endphp <tr
                                            style="font-weight: bold; border-bottom:1px solid black; font-size:16px">
                                          
                                            <td width="25%">{{$x->name}}</td>
                                            <td width="55%"></td>
                                            <td width="10%" align="right">
                                                {{number_format($x->CurrentBalance, 0, 0, '.')}}</td>
                                            <td width="10%" align="right">
                                                {{number_format($x->EndingBalance, 0, 0, '.')}}</td>
                                            </tr>
                                            @for ($b=0; $b < count($x->child); $b++)
                                                @php
                                                $y = $x->child[$b];
                                                @endphp
                                                <tr>
                                                <td width="25%">{{$x->code}}</td>
                                                    <td width="55%">{{$y->name}}</td>
                                                    <td width="10%" align="right">
                                                        {{number_format($y->CurrentBalance, 0, 0, '.')}}</td>
                                                    <td width="10%" align="right">
                                                        {{number_format($y->EndingBalance, 0, 0, '.')}}</td>
                                                </tr>
                                                @endfor
                                                @endfor

                                                <tr>
                                                    <td colspan="4"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"></td>
                                                </tr>

                                                <tr style="background:#add8f7;font-weight: bold;font-size:16px">
                                                    <td width="25%">
                                                        Total Revenue
                                                    </td>
                                                    <td width="55%"></td>
                                                    <td width="10%" align="right">
                                                        {{number_format($pendapatan_accumulated, 0, 0, '.')}}</td>
                                                    <td width="10%" align="right">
                                                        {{number_format($pendapatan_period, 0, 0, '.')}}</td>
                                                </tr>

                                                <tr>
                                                    <td colspan="4"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4"></td>
                                                </tr>

                                                {{-- Biaya --}}
                                                @for ($a=0; $a < count($data['biaya']); $a++) @php
                                                    $x=$data['biaya'][$a]; @endphp <tr
                                                    style="font-weight: bold; border-bottom:1px solid black; font-size:16px">
                                                    <td width="25%">{{$x->name}}</td>
                                                    <td width="55%"></td>
                                                    <td width="10%" align="right">
                                                        {{number_format($x->CurrentBalance, 0, 0, '.')}}</td>
                                                    <td width="10%" align="right">
                                                        {{number_format($x->EndingBalance, 0, 0, '.')}}</td>
                                                    </tr>
                                                    @for ($b=0; $b < count($x->child); $b++)
                                                        @php
                                                        $y = $x->child[$b];
                                                        @endphp
                                                        <tr>
                                                        <td width="25%">{{$x->code}}</td>
                                                            <td width="55%">{{$y->name}}</td>
                                                            <td width="10%" align="right">
                                                                {{number_format($y->CurrentBalance, 0, 0, '.')}}</td>
                                                            <td width="10%" align="right">
                                                                {{number_format($y->EndingBalance, 0, 0, '.')}}</td>
                                                        </tr>
                                                        @endfor
                                                        @endfor
                                                        <tr>
                                                            <td colspan="4"></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4"></td>
                                                        </tr>
                                                        <tr
                                                            style="background:#add8f7;font-weight: bold; font-size:16px">
                                                            <td width="25%">
                                                                Total Expense
                                                            </td>
                                                            <td width="55%"></td>
                                                            <td width="10%" align="right">
                                                                {{number_format($biaya_accumulated, 0, 0, '.')}}</td>
                                                            <td width="10%" align="right">
                                                                {{number_format($biaya_period, 0, 0, '.')}}</td>
                                                        </tr>
                                                                                                            
                                    </table>

                                    <div class="form-group m-form__group row mt-5">
                                        <div class="col-sm-12 col-md-12 col-lg-12">

                                            <table width="100%" >
                                                <tr style="font-weight: bold; font-size:16px">
                                                <td width="25%">
                                                               
                                                            </td>
                                                            <td width="55%" align="center"> PROFIT & LOSS</td>
                                                            <td width="10%" align="right">
                                                                {{number_format($biaya_accumulated, 0, 0, '.')}}</td>
                                                            <td width="10%" align="right">
                                                                {{number_format($biaya_period, 0, 0, '.')}}</td>

                                                  
                                                </tr>
                                               
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                                    <div class="action-buttons">
                                        <a href="{{url('')}}/profit-loss/print-view-pl?daterange={{$daterange}}"
                                            class="btn btn-success btn-md add">
                                            <span>
                                                <i class="fa fa-print"></i>
                                                <span>Print</span>
                                            </span>
                                        </a>
                                        <a href="{{url('')}}/profit-loss/export-view-pl?daterange={{$daterange}}"
                                            class="btn btn-success btn-md add">
                                            <span>
                                                <i class="fa fa-file-download"></i>
                                                <span>Export to excel</span>
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

@endsection

@push('footer-scripts')

@endpush