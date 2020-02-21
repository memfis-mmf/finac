@extends('frontend.master')

@section('content')
<input type="hidden" name="_beginDate" value="{{$beginDate}}">
<input type="hidden" name="_endingDate" value="{{$endingDate}}">
<input type="hidden" name="_coa" value="{{$coa}}">

<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                General Ledger
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
                            General Ledger
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
{{-- <div class="text-center p-5 text-white" style="background:#5f6b5e;">
    <h1>PT. MERPATI MAINTENANCE FACILITY</h1>
    <h5>GENERAL LEDGER</h5>
    <h4><b>11/11/11 - 11/11/20</b></h4>
</div>  --}}
@include('cashbookview::coamodal')
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

                            @include('label::show')

                            <h3 class="m-portlet__head-text">
                                General Ledger
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row ">
                            <h5 class="col-sm-12 col-md-12 col-lg-12">
                                <table width="100%" >
                                    <tr>
                                        <td width="10%"> Account Code</td>
                                        <td width="1%">:</td>
                                        <td width="89%"> 61115005 - <span> Duty Trip Expense (Hotel) International</span> </td>
                                    </tr>
                                    <tr>
                                        <td width="10%">Period </td>
                                        <td width="1%">:</td>
                                        <td width="89%"> 2020-02-01 </td>
                                    </tr>
                                </table><br>
                            </h5>
                            
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="general_ledger_datatable" id="scrolling_both"></div>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>

                        </div>
                        <div class="form-group m-form__group row ">

                            <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">

                                <div class="action-buttons">
                                    @component('buttons::submit')
                                    @slot('type', 'button')
                                    @slot('text','Print')
                                    @slot('id','print')
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

@endsection

@push('footer-scripts')
<script src="{{ asset('vendor/courier/frontend/general-ledger/show.js')}}"></script>
@endpush