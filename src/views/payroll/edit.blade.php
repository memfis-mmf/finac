@extends('frontend.master')

@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Payroll
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
                            Payroll
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

                            @include('label::edit')

                            <h3 class="m-portlet__head-text">
                                Payroll
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <form id="JournalForm">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Period @include('label::required')
                                        </label>

                                        @component('input::datepicker')
                                            @slot('id', 'daterange_payroll')
                                            @slot('name', 'daterange_payroll')
                                            @slot('id_error', 'daterange_payroll')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label font-weight-bold">
                                            Employee to be Processed :
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group m-form__group row ">
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                @component('input::radio')
                                                    @slot('id', 'all_employee')
                                                    @slot('name', 'employee')
                                                    @slot('text', 'All Employee')
                                                    @slot('checked','checked')
                                                @endcomponent
                                            </div>
                                            <div class="col-sm-1 col-md-1 col-lg-1">

                                                @component('input::radio')
                                                    @slot('id', 'employee_choose')
                                                    @slot('name', 'employee')
                                                @endcomponent
                                                
                                            </div>
                                            <div class="col-sm-5 col-md-5 col-lg-5">
                                                @component('input::select2')
                                                    @slot('id', 'employee')
                                                    @slot('text', 'employee')
                                                    @slot('name', 'employee')
                                                    @slot('id_error', 'employee')
                                                    @slot('disabled','disabled')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="action-buttons">
                                                @component('buttons::submit')
                                                    @slot('type', 'button')
                                                    @slot('text','Generated')
                                                    @slot('icon','fa-forward')
                                                    @slot('color','primary')
                                                    @slot('id','payrollgenerate')
                                                @endcomponent
                                        </div>
                                    </div>
                                </div>
                                {{-- datatables --}}
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="m-portlet m-portlet--mobile">
                                            <div class="m-portlet__body">
                                                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                                                    <div class="row align-items-center">
                                                        <div class="col-xl-6 order-2 order-xl-1">
                                                            <div class="form-group m-form__group row align-items-center">
                                                                <div class="col-md-6">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 order-1 order-xl-2 m--align-right">
                                                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="payroll_datatable" id="scrolling_both"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                                        <div class="action-buttons">
                                            {{-- @component('buttons::submit')
                                                @slot('type', 'button')
                                                @slot('text','Process')
                                                @slot('icon','fa-sync-alt')
                                                @slot('id','payrollprocess')
                                            @endcomponent --}}

                                            <a href="{{url('payroll/process')}}" class="btn m-btn m-btn--custom btn-success btn-md"><span>
                                                <i class="fa fa-sync-alt"></i>
                                                <span>Process</span>
                                            </span></a>
                                            @include('buttons::back')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('footer-scripts')
<script src="{{ asset('vendor/courier/frontend/payroll/edit.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/daterange/payroll.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/select2/employee.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/employee.js')}}"></script>

<script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>
@endpush
