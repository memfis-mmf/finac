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
                                        <div class="m-dropdown__header m--align-center" style="background: url(../assets/metronic/app/media/img/bg/bg-4.jpg); background-size: cover;">
                                            <div class="m-card-user m-card-user--skin-dark" style="height: 150px;padding-left: 20px;">                            
                                                <div class="m-card-user__details">
                                                    <span class="m-card-user__name" style="font-size: 18pt;">
                                                        <b><h3 style="color: #fff;">Profit & Loss Project</h3></b>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>                
                                        <div class="m-portlet m-portlet--mobile">
                                            <div class="m-portlet__body">
                                                <i class="fa fa-info-circle fa-4x"></i>
                                                Shows Profit Loss of Selected Project	
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <a href="">
                                    <div class="m-portlet">                                
                                        <div class="m-dropdown__header m--align-center" style="background: url(../assets/metronic/app/media/img/bg/bg-4.jpg); background-size: cover;">
                                            <div class="m-card-user m-card-user--skin-dark" style="height: 150px;padding-left: 20px;">                            
                                                <div class="m-card-user__details">
                                                    <span class="m-card-user__name" style="font-size: 18pt;">
                                                        <b><h3 style="color: #fff;">Project List</h3></b>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>                
                                        <div class="m-portlet m-portlet--mobile">
                                            <div class="m-portlet__body">
                                                <i class="fa fa-info-circle fa-4x"></i>
                                                Shows All Project List Report				
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
