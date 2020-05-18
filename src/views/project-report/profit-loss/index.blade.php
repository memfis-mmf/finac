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
        <div class="col-lg-12">
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>

                            @component('label::create-new')
                                @slot('text','Report')
                            @endcomponent

                            <h3 class="m-portlet__head-text">
                                Profit & Loss Project
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <form id="MasterAssetForm">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Project @include('label::required')
                                        </label>

                                        @component('input::select')
                                            @slot('id', 'project')
                                            @slot('text', 'Project')
                                            @slot('name', 'project')
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <fieldset class="border p-3">
                                            <legend class="w-auto font-weight-bold text-primary">Enter COGS Value</legend>
                                            <div class="form-group m-form__group row ">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <label class="form-control-label">
                                                        Manhour COGS @include('label::required')
                                                    </label>
        
                                                    @component('input::number')
                                                        @slot('id', 'manhour')
                                                        @slot('text', 'Manhour COGS')
                                                        @slot('name', 'manhour')
                                                        @slot('id_error', 'manhour')
                                                        @slot('input_append','Per Manhour')
                                                    @endcomponent
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <label class="form-control-label">
                                                        Hangar Space COGS @include('label::required')
                                                    </label>
        
                                                    @component('input::number')
                                                        @slot('id', 'hangar_space')
                                                        @slot('text', 'Hangar Space COGS')
                                                        @slot('name', 'hangar_space')
                                                        @slot('id_error', 'hangar_space')
                                                    @endcomponent
                                                </div>
                                            </div>  
                                            <div class="form-group m-form__group row ">
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <label class="form-control-label">
                                                        Parking Area COGS @include('label::required')
                                                    </label>
        
                                                    @component('input::number')
                                                        @slot('id', 'parking_area')
                                                        @slot('text', 'Parking Area COGS')
                                                        @slot('name', 'parking_area')
                                                        @slot('id_error', 'parking_area')
                                                    @endcomponent
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <label class="form-control-label">
                                                        Other Expense @include('label::required')
                                                    </label>
        
                                                    @component('input::number')
                                                        @slot('id', 'other_expense')
                                                        @slot('text', 'Other Expense')
                                                        @slot('name', 'other_expense')
                                                        @slot('id_error', 'other_expense')
                                                    @endcomponent
                                                </div>
                                            </div>  
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                                        <div class="action-buttons">
                                            @component('buttons::submit')
                                                @slot('type', 'button')
                                                @slot('color', 'primary')
                                                @slot('icon', 'fa-search')
                                                @slot('text', 'View Profit & Loss')
                                                @slot('id','view_report')
                                            @endcomponent
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
@endpush