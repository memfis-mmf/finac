@extends('frontend.master')

@section('faBS', 'm-menu__item--active')
@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Balance Sheet
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
                            Balance Sheet
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
                                Balance Sheet
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <h5>
                                        Date Period
                                        {{date('d/m/y', strtotime($beginDate))}} -
                                        {{date('d/m/y', strtotime($endingDate))}}
                                    </h5>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <table width="100%" cellpadding="8">
                                        <tr class="pb-0" style="background:#5f6b5e; color:white;font-weight: bold;">
                                            <td width="18%" align="left">Account Code</td>
                                            <td width="52%" align="left">Account Name</td>
                                            <td width="30%" align="center">Total Balance</td>
                                        </tr>
                                        {{-- spasi --}}
                                        <tr>
                                            <td width="18%" colspan="3"></td>
                                        </tr>
                                        {{-- Activa --}}
                                        <tr style="color:blue;font-weight: bold;">
                                            <td class="pt-0" width="18%" colspan="3"><h5>ACTIVA</h5></td>
                                        </tr>
                                        @for ($index_activa=0; $index_activa < count($data['activa']); $index_activa++)
                                            @php
                                                $arr = $data['activa'][$index_activa];
                                            @endphp
                                            <tr style="font-weight: bold; border-bottom:1px solid black">
                                                <td class="pt-0 pb-0" width="18%" colspan="3"><h5>{{$arr->name}}</h5></td>
                                            </tr>
                                            @for ($index_child=0; $index_child < count($arr->child); $index_child++)
                                                @php
                                                    $arr2 = $arr->child[$index_child];
                                                @endphp
                                                <tr>
                                                    <td width="18%">{{$arr2->code}}</td>
                                                    <td width="52%">{{$arr2->name}}</td>
                                                    <td width="30%" align="right">{{number_format($arr2->CurrentBalance, '0', '0', '.')}}</td>
                                                </tr>
                                                @endfor
                                                <tr style="background:#cfcfcf;font-weight: bold;">
                                                    <td width="38%">Total {{$arr->name}}</td>
                                                    <td width="32%" align="center"></td>
                                                    <td class="pb-1" width="30%" align="right">{{number_format($arr->total, '0', '0', '.')}}</td>
                                                </tr>
                                                <tr>
                                                    <td width="18%" colspan="3"></td>
                                                </tr>
                                            @endfor
                                            {{-- spasi --}}
                                            <tr>
                                                <td width="18%" colspan="3"></td>
                                            </tr>
                                            <tr>
                                                <td width="18%" colspan="3"></td>
                                            </tr>
                                            {{-- total Activa --}}
                                            <tr style="background:#add8f7;font-weight: bold;">
                                                <td class="pb-1" width="18%"><h5>Total Assets</h5></td>
                                                <td width="52%" align="center"></td>
                                                <td class="text-right pb-2" width="30%" align="right">{{number_format($totalActiva, 0, ',', '.')}}</td>
                                            </tr>

                                            {{-- spasi --}}
                                            <tr>
                                                <td width="18%" colspan="3"></td>
                                            </tr>
                                            <tr>
                                                <td width="18%" colspan="3"></td>
                                            </tr>

                                            {{-- Pasiva --}}
                                            <tr style="color:blue;font-weight: bold;">
                                                <td class="pt-0" width="18%" colspan="3"><h5>PASIVA & EQUITY</h5></td>
                                            </tr>
                                            @for ($index_activa=0; $index_activa < count($data['pasiva']); $index_activa++)
                                                @php
                                                    $arr = $data['pasiva'][$index_activa];
                                                @endphp
                                                <tr style="font-weight: bold; border-bottom:1px solid black">
                                                    <td class="pt-0 pb-0" width="18%" colspan="3"><h5>{{$arr->name}}</h5></td>
                                                </tr>
                                                @for ($index_child=0; $index_child < count($arr->child); $index_child++)
                                                    @php
                                                        $arr2 = $arr->child[$index_child];
                                                    @endphp
                                                    <tr>
                                                        <td width="18%">{{$arr2->code}}</td>
                                                        <td width="52%">{{$arr2->name}}</td>
                                                        <td width="30%" align="right">{{number_format($arr2->CurrentBalance, '0', '0', '.')}}</td>
                                                    </tr>
                                            @endfor
                                            <tr style="background:#cfcfcf;font-weight: bold;">
                                                <td class="pb-1" width="18%">Total {{$arr->name}}</td>
                                                <td width="52%" align="center"></td>
                                                <td class="pb-2" width="30%" align="right">{{number_format($arr->total, '0', '0', '.')}}</td>
                                            </tr>
                                            <tr>
                                                <td width="18%" colspan="3"></td>
                                            </tr>
                                        @endfor
                                        {{-- spasi --}}
                                        <tr>
                                            <td width="18%" colspan="3"></td>
                                        </tr>
                                        <tr>
                                            <td width="18%" colspan="3"></td>
                                        </tr>
                                        {{-- total Activa --}}
                                        <tr style="background:#add8f7;font-weight: bold;">
                                            <td class="pb-1" width="18%"><h5>Total Liabilities & Equity</h5></td>
                                            <td width="52%" align="center"></td>
                                            <td class="pb-2" width="30%" align="right">{{number_format($totalPasiva, 0, ',', '.')}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                                    <div class="action-buttons">
                                        <a href="{{route('balancesheet.export').'?daterange='.Request::get('daterange')}}" class="btn btn-success">
                                            <span>
                                                <i class="export far fa-file-excel ml-2"></i>
                                                <span class="ml-1">Export to excel</span>
                                            </span>
                                        </a>
                                        <a href="{{route('balancesheet.print').'?daterange='.Request::get('daterange')}}" class="btn btn-info">
                                            <span>
                                                <i class="la la-print"></i>
                                                <span>Print</span>
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
    <script>
        $(document).ready(function() {
            let currentUrl = window.location.href;
            let _hash = currentUrl.split('#');
            if (_hash.length < 2) {
                window.location.href=currentUrl+"#faBS";
            } else {
                window.location.href=currentUrl;
            }
        });
    </script>

@endpush
