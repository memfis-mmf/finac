@extends('frontend.master')

@section('content')

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

                            @include('label::datalist')

                            <h3 class="m-portlet__head-text">
                                Project  Report
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body pb-5">
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <a href="">
                                    <div class="m-portlet">
                                        <div class="m-portlet__head m-portlet--skin-dark m-portlet--bordered-semi m--bg-brand" style="height:200px;">
                                            <div class="m-portlet__head-caption text-center">
                                                <div class="m-portlet__head-title">
                                                    <span class="m-portlet__head-icon" style="font-size:26px;">
                                                        <i class="flaticon-statistics text-white"></i>
                                                    </span>
                                                    <h3 class="m-portlet__head-text text-white text-center" style="font-size:26px;">
                                                        Profit & Loss Project
                                                    </h3>
                                                </div>			
                                            </div>
                                        </div>
                                        <div class="m-portlet__foot">
                                            <div class="row align-items-center">
                                                <div class="col-lg-12 m--valign-middle">
                                                    <div class="m-demo-icon">
                                                        <i class="flaticon-exclamation" style="font-size:19px;"></i>
                                                        <div class="m-demo-icon__class pl-2" style="font-size:14px;">
                                                            Shows Profit Loss of Selected Project						
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <a href="">
                                    <div class="m-portlet">
                                        <div class="m-portlet__head m-portlet--skin-dark m-portlet--bordered-semi m--bg-brand" style="height:200px;">
                                            <div class="m-portlet__head-caption text-center">
                                                <div class="m-portlet__head-title">
                                                    <span class="m-portlet__head-icon" style="font-size:26px;">
                                                        <i class="flaticon-statistics text-white"></i>
                                                    </span>
                                                    <h3 class="m-portlet__head-text text-white text-center" style="font-size:26px;">
                                                        Project List
                                                    </h3>
                                                </div>			
                                            </div>
                                        </div>
                                        <div class="m-portlet__foot">
                                            <div class="row align-items-center">
                                                <div class="col-lg-12 m--valign-middle">
                                                    <div class="m-demo-icon">
                                                        <i class="flaticon-exclamation" style="font-size:19px;"></i>
                                                        <div class="m-demo-icon__class pl-2" style="font-size:14px;">
                                                            Shows All Project List Report				
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
