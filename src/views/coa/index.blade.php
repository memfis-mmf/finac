@extends('frontend.master')

@section('content')
    
    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet">
                    <div class="m-portlet__head ribbon ribbon-top ribbon-ver">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon m--hide">
                                    <i class="la la-gear"></i>
                                </span>

                                @include('label::datalist')

                                <h3 class="m-portlet__head-text">
                                    COA (Chart Of Accounts)
                                </h3>
                            </div>
                        </div>
                        @component('frontend.common.buttons.read-help')
                            @slot('href', '/master-coa.pdf/help')
                        @endcomponent
                    </div>
                    <div class="m-portlet m-portlet--mobile">
                        <div class="m-portlet__body">
                            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                                <div class="row align-items-center">
                                    <div class="col-xl-8 order-2 order-xl-1">
                                        <div class="form-group m-form__group row align-items-center">
                                            <div class="col-md-4">
                                                <div class="m-input-icon m-input-icon--left">
                                                    <input type="text" class="form-control m-input" placeholder="Search..."
                                                        id="generalSearch">
                                                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                                        <span><i class="la la-search"></i></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <button class="btn m-btn--pill m-btn--air btn-success btn-sm">
                                                Export to Excel
                                            </button>
                                            <button class="btn m-btn--pill m-btn--air btn-outline-info btn-sm ml-3">
                                                Print
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                                        @component('buttons::create-new')
                                            @slot('text', 'Add COA')
                                            @slot('data_target', '#modal_coa')
                                        @endcomponent

                                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                                    </div>
                                </div>
                            </div>

                            @include('coaview::modal')

                            <div class="coa_datatable" id="scrolling_both"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-scripts')
    <script src="{{ asset('vendor/courier/frontend/functions/reset.js')}}"></script>
    <script src="{{ asset('vendor/courier/frontend/functions/select2/type.js')}}"></script>
    <script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/type.js')}}"></script>
    <script src="{{ asset('vendor/courier/frontend/functions/select2/description.js')}}"></script>
    <script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/description.js')}}"></script>
    


    <script src="{{ asset('vendor/courier/frontend/coa.js')}}"></script>
@endpush
