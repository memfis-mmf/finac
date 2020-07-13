@extends('frontend.master')

@section('faJournal', 'm-menu__item--active')
@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Journal
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
                            Journal
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
                                Journal
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
                                            Date  
                                        </label>

                                        @component('label::data-info')
                                            @slot('text', 'generated')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Journal Type  
                                        </label>
        
                                        @component('label::data-info')
                                            @slot('text', 'generated')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Currency  
                                        </label>

                                        @component('label::data-info')
                                            @slot('text', 'generated')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Exchange Rate 
                                        </label>
                                        @component('label::data-info')
                                            @slot('text', 'generated')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <label class="form-control-label">
                                            Ref Doc
                                        </label>

                                        @component('label::data-info')
                                            @slot('text', 'generated')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="m-portlet">
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-caption">
                                                    <div class="m-portlet__head-title">
                                                        <span class="m-portlet__head-icon m--hide">
                                                            <i class="la la-gear"></i>
                                                        </span>

                                                        @include('label::datalist')

                                                        <h3 class="m-portlet__head-text">
                                                            Account Code
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-portlet m-portlet--mobile">
                                                <div class="m-portlet__body">
                                                    <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                                                        <div class="row align-items-center">
                                                            <div class="col-xl-8 order-2 order-xl-1">
                                                                <div class="form-group m-form__group row align-items-center">
                                                                    <div class="col-md-4">
                                                                        <div class="m-input-icon m-input-icon--left">
                                                                            <input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch">
                                                                            <span class="m-input-icon__icon m-input-icon__icon--left">
                                                                                <span><i class="la la-search"></i></span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4 order-1 order-xl-2 m--align-right">

                                                                <div class="m-separator m-separator--dashed d-xl-none"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accountcode_datatable" id="scrolling_both"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                                        <div class="action-buttons">
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
    <script>
        $(document).ready(function() {
            let currentUrl = window.location.href;
            let _hash = currentUrl.split('#');
            if (_hash.length < 2) {
                window.location.href=currentUrl+"#faJournal";
            }
        });
    </script>
<script src="{{ asset('vendor/courier/frontend/journal/show.js')}}"></script>
@endpush