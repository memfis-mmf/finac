@extends('frontend.master')

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
                                    <h3>Date Period 12/12/12 - 12/12/20</h3>
                                </div>
                            </div>
                            <div class="form-group m-form__group row ">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <table width="100%" cellpadding="8">
                                        <tr style="background:#5f6b5e; color:white;font-weight: bold;">
                                            <td width="18%">Account Code</td>
                                            <td width="52%" align="center">Account Name</td>
                                            <td width="30%" align="center">Total Balance</td>
                                        </tr>
                                        {{-- spasi --}}
                                        <tr>
                                            <td width="18%" colspan="3"></td>
                                        </tr>
                                        <tr>
                                            <td width="18%" colspan="3"></td>
                                        </tr>
                                        {{-- Activa --}}
                                        <tr style="color:blue;font-weight: bold;">
                                            <td width="18%" colspan="3"><h3>ACTIVA</h3></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="18%" colspan="3"><h3>Current Asset</h3></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">11110000</td>
                                            <td width="52%">Cash & Bank</td>
                                            <td width="30%"></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">11120000</td>
                                            <td width="52%">Deposit</td>
                                            <td width="30%"></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">11130000</td>
                                            <td width="52%">Temporary Investment</td>
                                            <td width="30%"></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">11140000</td>
                                            <td width="52%">Account Receivables</td>
                                            <td width="30%"></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">11150000</td>
                                            <td width="52%">Account Receivables Other</td>
                                            <td width="30%"></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">11160000</td>
                                            <td width="52%">Inventories</td>
                                            <td width="30%"></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">11170000</td>
                                            <td width="52%">Advance Payment</td>
                                            <td width="30%"></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">11180000</td>
                                            <td width="52%">Prepaid Tax</td>
                                            <td width="30%"></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">11190000</td>
                                            <td width="52%">Prepaid Expense</td>
                                            <td width="30%"></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">11200000</td>
                                            <td width="52%">Accurued Revenue</td>
                                            <td width="30%"></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">11210000</td>
                                            <td width="52%">Other Current Assets</td>
                                            <td width="30%"></td>
                                        </tr>
                                        <tr style="background:#cfcfcf;font-weight: bold;">
                                            <td width="18%"><h5>Total Current Asset</h5></td>
                                            <td width="52%" align="center"></td>
                                            <td width="30%" align="center">Amount</td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="18%" colspan="3"><h3>Current Asset</h3></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">12110000</td>
                                            <td width="52%">Fixed Asset</td>
                                            <td width="30%"></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">12120000</td>
                                            <td width="52%">Long Term Invesment</td>
                                            <td width="30%"></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">12130000</td>
                                            <td width="52%">Other Asset</td>
                                            <td width="30%"></td>
                                        </tr>
                                        <tr style="background:#cfcfcf;font-weight: bold;">
                                            <td width="18%"><h5>Total Non Current Asset</h5></td>
                                            <td width="52%" align="center"></td>
                                            <td width="30%" align="center">Amount</td>
                                        </tr>
                                        {{-- spasi --}}
                                        <tr>
                                            <td width="18%" colspan="3"></td>
                                        </tr>
                                        <tr>
                                            <td width="18%" colspan="3"></td>
                                        </tr>
                                        {{-- total Activa --}}
                                        <tr style="background:#add8f7;font-weight: bold;">
                                            <td width="18%"><h5>Total Activa</h5></td>
                                            <td width="52%" align="center"></td>
                                            <td width="30%" align="center">Amount</td>
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
                                            <td width="18%" colspan="3"><h3>PASIVA</h3></td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="18%" colspan="3"><h3>Liabilities</h3></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">21110000</td>
                                            <td width="52%">Current Liabilies</td>
                                            <td width="30%"></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">21120000</td>
                                            <td width="52%">Other Current Liabilities</td>
                                            <td width="30%"></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">21130000</td>
                                            <td width="52%">Long Term Liabilies</td>
                                            <td width="30%"></td>
                                        </tr>
                                        <tr style="background:#cfcfcf;font-weight: bold;">
                                            <td width="18%"><h5>Total Liabilities</h5></td>
                                            <td width="52%" align="center"></td>
                                            <td width="30%" align="center">Amount</td>
                                        </tr>
                                        <tr style="font-weight: bold; border-bottom:1px solid black">
                                            <td width="18%" colspan="3"><h3>Equities</h3></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">31110000</td>
                                            <td width="52%">Capital</td>
                                            <td width="30%"></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">31120000</td>
                                            <td width="52%">Retained Earning</td>
                                            <td width="30%"></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">31130000</td>
                                            <td width="52%">Profit and Loss</td>
                                            <td width="30%"></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">31140000</td>
                                            <td width="52%">Devident</td>
                                            <td width="30%"></td>
                                        </tr>
                                        <tr style="background:#cfcfcf;font-weight: bold;">
                                            <td width="18%"><h5>Total Equities</h5></td>
                                            <td width="52%" align="center"></td>
                                            <td width="30%" align="center">Amount</td>
                                        </tr>
                                        {{-- spasi --}}
                                        <tr>
                                            <td width="18%" colspan="3"></td>
                                        </tr>
                                        <tr>
                                            <td width="18%" colspan="3"></td>
                                        </tr>
                                        {{-- total Activa --}}
                                        <tr style="background:#add8f7;font-weight: bold;">
                                            <td width="18%"><h5>Total Pasiva</h5></td>
                                            <td width="52%" align="center"></td>
                                            <td width="30%" align="center">Amount</td>
                                        </tr>
                                    </table>
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
