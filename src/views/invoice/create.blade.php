@extends('frontend.master')

@section('content')
<style media="screen">
    .m-datatable__cell:last-of-type {
        vertical-align: top !important;
    }
</style>
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Invoice
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
                    <a href="{{ route('invoice.index') }}" class="m-nav__link">
                        <span class="m-nav__link-text">
                            Invoice
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

                            @include('frontend.common.label.create-new')

                            <h3 class="m-portlet__head-text">
                                Invoice
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <form id="itemform" name="itemform">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group m-form__group row">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group m-form__group row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <input hidden id="customerid">
                                                        <input hidden id="projectuuid">
                                                        <label class="form-control-label">
                                                            Ref Quotation No. @include('frontend.common.label.required')
                                                        </label>

                                                        @component('input::inputrightbutton')
                                                        @slot('text', 'Ref Quotation No')
                                                        @slot('id', 'refquono')
                                                        @slot('data_target', '#refquo_modal')
                                                        @slot('name', 'refquono')
                                                        @slot('id_error', 'refquono')
                                                        @endcomponent
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <fieldset class="border p-2">
                                                    <legend class="w-auto">Identifier Customer</legend>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="m-portlet__head">
                                                            <div class="m-portlet__head-tools">
                                                                <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                                                                    <li class="nav-item m-tabs__item">
                                                                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1" role="tab">
                                                                            <i class="la la-bell-o"></i> General
                                                                        </a>
                                                                    </li>
                                                                    <li class="nav-item m-tabs__item">
                                                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab">
                                                                            <i class="la la-bell-o"></i> Contact
                                                                        </a>
                                                                    </li>
                                                                    <li class="nav-item m-tabs__item">
                                                                        <a class="nav-link m-tabs__link " data-toggle="tab" href="#m_tabs_6_3" role="tab">
                                                                            <i class="la la-cog"></i> Address
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="m-portlet__body">
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="form-group m-form__group row">
                                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                                            <label class="form-control-label">
                                                                                Customer Name
                                                                            </label>

                                                                            @component('input::inputreadonly')
                                                                            @slot('text', 'XXX')
                                                                            @slot('id', 'name')
                                                                            @endcomponent
                                                                        </div>
                                                                        <br />
                                                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                                                            <br />
                                                                            <label class="form-control-label">
                                                                                Level
                                                                            </label>

                                                                            @component('input::inputreadonly')
                                                                            @slot('text', '')
                                                                            @slot('id', 'level')
                                                                            @slot('name', 'level')
                                                                            @endcomponent
                                                                        </div>
                                                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                                                            <br />
                                                                            <label class="form-control-label">
                                                                                Attention
                                                                            </label>

                                                                            @component('frontend.common.input.select2')
                                                                            @slot('text', 'Bp. Romdani')
                                                                            @slot('id', 'attention')
                                                                            @slot('name', 'attention')
                                                                            @endcomponent
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="form-group m-form__group row">
                                                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                                                            <label class="form-control-label">
                                                                                Phone
                                                                            </label>

                                                                            @component('frontend.common.input.select2')
                                                                            @slot('text', '+62xxxxxxx / 07777777')
                                                                            @slot('id', 'phone')
                                                                            @slot('name', 'phone')
                                                                            @endcomponent

                                                                        </div>
                                                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                                                            <label class="form-control-label">
                                                                                Fax
                                                                            </label>

                                                                            @component('frontend.common.input.select2')
                                                                            @slot('text', '+62xxxxxxx / 07777777')
                                                                            @slot('id', 'fax')
                                                                            @slot('name', 'fax')
                                                                            @endcomponent
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group m-form__group row">
                                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                                            <label class="form-control-label">
                                                                                Email
                                                                            </label>

                                                                            @component('frontend.common.input.select2')
                                                                            @slot('text', '+62xxxxxxx / 07777777')
                                                                            @slot('id', 'email')
                                                                            @slot('name', 'email')
                                                                            @endcomponent

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="form-group m-form__group row">
                                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                                            <label class="form-control-label">
                                                                                Address
                                                                            </label>

                                                                            @component('input::inputreadonly')
                                                                            @slot('text', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi, nulla odio consequuntur obcaecati eos error recusandae minima eveniet dolor sed tempora! Ut quidem illum accusantium expedita nulla eos reprehenderit officiis?')
                                                                            @slot('id', 'address')
                                                                            @slot('name', 'address')
                                                                            @endcomponent
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group m-form__group row">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group m-form__group row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <label class="form-control-label">
                                                            Date @include('frontend.common.label.required')
                                                        </label>

                                                        {{-- @component('input::inputreadonly')
                                                        @slot('id', 'date')
                                                        @slot('text', 'Date')
                                                        @slot('name', 'date')
                                                        @slot('value', $today)
                                                        @slot('id_error','requested_at')
                                                        @endcomponent --}}

                                                        @component('input::datepicker')
                                                          @slot('id', 'date')
                                                          @slot('text', 'Date')
                                                          @slot('name', 'date')
                                                          @slot('id_error', 'date')
                                                          @slot('value', $today)
                                                          @slot('id_error','requested_at')
                                                        @endcomponent
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group m-form__group row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <label class="form-control-label">
                                                            Currency @include('frontend.common.label.required')
                                                        </label>

                                                        @component('input::select')
                                                        @slot('id', 'currency')
                                                        @slot('text', 'Currency')
                                                        @slot('name', 'currency')
                                                        @slot('id_error', 'currency')
                                                        @endcomponent
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <br />
                                                        <label class="form-control-label">
                                                            Exchange Rate <span id="requi" class="requi" style="font-weight: bold;color:red">

                                                                *

                                                            </span>
                                                        </label>

                                                        {{-- @component('input::numberreadonly') --}}
                                                        @component('frontend.common.input.input')
                                                        @slot('id', 'exchange_rate1111')
                                                        @slot('text', 'exchange_rate1111')
                                                        @slot('name', 'exchange_rate1111')
                                                        @endcomponent
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <br />
                                                        <label class="form-control-label">
                                                            President Director
                                                        </label>

                                                        @component('frontend.common.input.input')
                                                        @slot('id', 'presdir')
                                                        @slot('name', 'presdir')
                                                        @slot('value', 'Rowin H. Mangkoesoebroto')
                                                        @endcomponent
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <br />
                                                        <label class="form-control-label">
                                                            Location
                                                        </label>

                                                        <select class="_select2 form-control" name="location" style="width:100%">
                                                            <option value=""></option>
                                                            <option value="sidoarjo">Sidoarjo</option>
                                                            <option value="surabaya">Surabaya</option>
                                                            <option value="jakarta">Jakarta</option>
                                                            <option value="biak">Biak</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <br />
                                                        <label class="form-control-label">
                                                            Company and Department
                                                        </label>

                                                        <select class="_select2 form-control" name="company_department" style="width:100%">
                                                            <option value=""></option>
                                                            @for ($a=0; $a < count($company); $a++)
                                                                @php
                                                                    $x = $company[$a]
                                                                @endphp
                                                                <option value="{{$x->name}}">{{$x->name}}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Bank Name Information @include('frontend.common.label.required')
                                        </label>

                                        @component('input::select2')
                                        @slot('id', 'bankinfo1')
                                        @slot('name', 'bankinfo')
                                        @slot('class', 'bankinfo')
                                        @slot('text', 'Bank Name Information')
                                        @slot('id_error', 'bankinfo')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div hidden id="bai_header">
                                            <label class="form-control-label">
                                                Bank Account Information
                                            </label>

                                            @component('input::inputreadonly')
                                            @slot('id', 'bai')
                                            @slot('name', 'bai')
                                            @slot('text', 'Bank Account Information')
                                            @slot('id_error', 'bankaccount')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        @component('input::select2')
                                        @slot('id', 'bankinfo2')
                                        @slot('name', 'bankinfo2')
                                        @slot('class', 'bankinfo')
                                        @slot('text', 'Bank Name Information')
                                        @slot('id_error', 'bankinfo')
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div hidden id="bai_header">
                                            @component('input::inputreadonly')
                                            @slot('id', 'bai')
                                            @slot('name', 'bai')
                                            @slot('text', 'Bank Account Information')
                                            @slot('id_error', 'bankaccount')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <div id="actheader" class="col-sm-12 col-md-12 col-lg-12 footer">
                                        <div class="flex">
                                            <div class="action-buttons">
                                                @component('frontend.common.buttons.submit')
                                                @slot('type','button')
                                                @slot('id', 'add-invocheck')
                                                @slot('class', 'add-invocheck')
                                                @endcomponent

                                                @include('frontend.common.buttons.reset')

                                                @include('frontend.common.buttons.back')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <br />
                                <div hidden id="hiddennext">
                                    <div class="form-group m-form__group row">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <br />
                                            <br />
                                            <fieldset class="border p-2">
                                                <legend class="w-auto">Profit Center :</legend>
                                                <div class="row">
                                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            <label style="margin-top:13px" class="form-control-label">
                                                                Manhours
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            <label style="margin-top:35px" class="form-control-label">
                                                                Material
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            <label style="margin-top:15px" class="form-control-label">
                                                                <br />
                                                                Facility
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            <label style="margin-top:15px" class="form-control-label">
                                                                <br />
                                                                Discount
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            <label style="margin-top:15px" class="form-control-label">
                                                                <br />
                                                                PPN
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            <label style="margin-top:34px" class="form-control-label">
                                                                Other
                                                            </label>
                                                        </div>

                                                    </div>
                                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputrightbutton')
                                                            @slot('id', 'coa')
                                                            @slot('text', 'coa')
                                                            @slot('class', 'manhours')
                                                            @slot('dataid','manhours')
                                                            @slot('name', 'coa')
                                                            @slot('type', 'text')
                                                            @slot('style', 'width:100%')
                                                            @slot('data_target', '#coa_modal')
                                                            @slot('value', $coa_default->manhours->code)
                                                            @endcomponent
                                                        </div>
                                                        <br />
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputrightbutton')
                                                            @slot('id', 'coa')
                                                            @slot('text', 'coa')
                                                            @slot('class', 'material')
                                                            @slot('name', 'coa')
                                                            @slot('dataid','material')
                                                            @slot('type', 'text')
                                                            @slot('style', 'width:100%')
                                                            @slot('data_target', '#coa_modal')
                                                            @slot('value', $coa_default->material->code)
                                                            @endcomponent
                                                        </div>
                                                        <br />
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputrightbutton')
                                                            @slot('id', 'coa')
                                                            @slot('text', 'coa')
                                                            @slot('name', 'coa')
                                                            @slot('type', 'text')
                                                            @slot('class', 'facility')
                                                            @slot('dataid','facility')
                                                            @slot('style', 'width:100%')
                                                            @slot('data_target', '#coa_modal')
                                                            @slot('value', $coa_default->facility->code)
                                                            @endcomponent
                                                        </div>
                                                        <br />
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputrightbutton')
                                                            @slot('id', 'coa')
                                                            @slot('text', 'coa')
                                                            @slot('name', 'coa')
                                                            @slot('class', 'discount')
                                                            @slot('dataid','discount')
                                                            @slot('type', 'text')
                                                            @slot('style', 'width:100%')
                                                            @slot('data_target', '#coa_modal')
                                                            @slot('value', $coa_default->discount->code)
                                                            @endcomponent
                                                        </div>
                                                        <br />
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputrightbutton')
                                                            @slot('id', 'coa')
                                                            @slot('text', 'coa')
                                                            @slot('name', 'coa')
                                                            @slot('class', 'ppn')
                                                            @slot('dataid','ppn')
                                                            @slot('type', 'text')
                                                            @slot('style', 'width:100%')
                                                            @slot('data_target', '#coa_modal')
                                                            @slot('value', $coa_default->ppn->code)
                                                            @endcomponent
                                                        </div>
                                                        <br />
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputrightbutton')
                                                            @slot('id', 'coa')
                                                            @slot('text', 'coa')
                                                            @slot('name', 'coa')
                                                            @slot('class', 'others')
                                                            @slot('dataid','others')
                                                            @slot('type', 'text')
                                                            @slot('style', 'width:100%')
                                                            @slot('data_target', '#coa_modal')
                                                            @slot('value', $coa_default->other->code)
                                                            @endcomponent
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <div style="margin-top:1px" class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputreadonly')
                                                            @slot('id', 'manhours_name')
                                                            @slot('name', 'manhours_name')
                                                            @slot('value', $coa_default->manhours->name)
                                                            @slot('id_error', 'manhours_name')
                                                            @endcomponent
                                                        </div>
                                                        <div style="margin-top:22px" class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputreadonly')
                                                            @slot('id', 'material_name')
                                                            @slot('name', 'material_name')
                                                            @slot('value', $coa_default->material->name)
                                                            @slot('id_error', 'material_name')
                                                            @endcomponent
                                                        </div>
                                                        <div style="margin-top:20px" class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputreadonly')
                                                            @slot('id', 'facility_name')
                                                            @slot('name', 'facility_name')
                                                            @slot('value', $coa_default->facility->name)
                                                            @slot('id_error', 'facility_name')
                                                            @endcomponent
                                                        </div>
                                                        <div style="margin-top:20px" class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputreadonly')
                                                            @slot('id', 'discount_name')
                                                            @slot('name', 'discount_name')
                                                            @slot('value', $coa_default->discount->name)
                                                            @slot('id_error', 'discount_name')
                                                            @endcomponent
                                                        </div>
                                                        <div style="margin-top:20px" class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputreadonly')
                                                            @slot('id', 'ppn_name')
                                                            @slot('name', 'ppn_name')
                                                            @slot('value', $coa_default->ppn->name)
                                                            @slot('id_error', 'ppn_name')
                                                            @endcomponent
                                                        </div>
                                                        <div style="margin-top:20px" class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputreadonly')
                                                            @slot('id', 'other_name')
                                                            @slot('name', 'other_name')
                                                            @slot('value', $coa_default->other->name)
                                                            @slot('id_error', 'other_name')
                                                            @endcomponent
                                                        </div>
                                                    </div>


                                                </div>
                                                <fieldset class="border p-2">
                                                    <legend class="w-auto">Scheduled Payment :</legend>

                                                    <table id="scheduled_payments_datatables" class="table table-striped table-bordered" width="80%">
                                                        <tfoot>
                                                            <th></th>
                                                            <th></th>
                                                            <th colspan="2"></th>
                                                        </tfoot>
                                                    </table>
                                                </fieldset>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <br />
                                    <br />
                                    <center>
                                        <h3 id="subjectquo">Subject</h3>
                                    </center>
                                    <br />
                                    <div class="summary_datatable" id="scrolling_both"></div>
                                    <br>
                                    <hr>

                                    <div class="form-group m-form__group row">
                                        <div class="col-sm-12">
                                            <div class="form-group m-form__group row">
                                                {{-- <div class="col-sm-3 col-md-3 col-lg-3">
                                                    <div class="m--align-left" style="padding-top:15px">
                                                        PPH
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 col-md-2 col-lg-2">
                                                    @component('input::input')
                                                    @slot('id', 'pph')
                                                    @slot('class', 'pph')
                                                    @slot('text', '')
                                                    @slot('value', '')
                                                    @endcomponent
                                                </div>
                                                %
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    @component('input::inputreadonly')
                                                    @slot('id', 'percent')
                                                    @slot('class', 'percent')
                                                    @slot('text', '')
                                                    @slot('value', '')
                                                    @endcomponent
                                                </div>
                                                <div class="col-sm-1 col-md-1 col-lg-1">
                                                </div>
                                                <div class="col-sm-1 col-md-1 col-lg-1">
                                                </div> --}}
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-12 col-md-12">
                                                    <div class="m--align-left" style="padding-top:15px">
                                                        Remark
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12">
                                                    @component('frontend.common.input.summernote')
                                                    @slot('id', 'desc')
                                                    @slot('class', 'desc')
                                                    @slot('text', '')
                                                    @endcomponent
                                                </div>
                                                <div class="col-sm-1 col-md-1 col-lg-1">
                                                </div>
                                                <div class="col-sm-1 col-md-1 col-lg-1">
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-12 col-md-12">
                                                    <div class="m--align-left" style="padding-top:15px">
                                                        Term and Condition
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12">
                                                    @component('frontend.common.input.summernote')
                                                    @slot('id', 'term_and_condition')
                                                    @slot('class', 'term_and_condition')
                                                    @slot('text', '')
                                                    @endcomponent
                                                </div>
                                                <div class="col-sm-1 col-md-1 col-lg-1">
                                                </div>
                                                <div class="col-sm-1 col-md-1 col-lg-1">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="sub_total_val" id="sub_total_val" value="">
                                        <input type="hidden" name="total_discount_val" id="total_discount_val" value="">
                                        <input type="hidden" name="grand_total_val" id="grand_total_val" value="">
                                        <input type="hidden" name="grand_totalrp_val" id="grand_totalrp_val" value="">
                                        <input type="hidden" name="other_price_val" id="other_price_val" value="0">
                                        <input type="hidden" name="htcrr_price_val" id="htcrr_price_val" value="">
                                        <div class="col-sm-6 offset-sm-6">
                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-3 col-md-3 col-lg-3">
                                                    <div>
                                                        Sub Total
                                                    </div>
                                                </div>
                                                <div class="col-sm-9 col-md-9 col-lg-9">
                                                    @component('input::inputreadonly')
                                                    @slot('id', 'sub_total')
                                                    @slot('class', 'sub_total')
                                                    @slot('text', '')
                                                    @slot('value', '')
                                                    @endcomponent
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-3 col-md-3 col-lg-3">
                                                    <div>
                                                        Total Discount
                                                    </div>
                                                </div>
                                                <div class="col-sm-9 col-md-9 col-lg-9">
                                                    @component('input::inputreadonly')
                                                    @slot('id', 'total_discount')
                                                    @slot('class', 'total_discount')
                                                    @slot('text', '0')
                                                    @slot('value', '0')
                                                    @endcomponent
                                                </div>

                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-3 col-md-3 col-lg-3">
                                                    <div>
                                                        Total
                                                    </div>
                                                </div>
                                                <div class="col-sm-9 col-md-9 col-lg-9">
                                                    @component('input::inputreadonly')
                                                    @slot('id', 'total')
                                                    @slot('class', 'total')
                                                    @slot('text', '0')
                                                    @slot('value', '0')
                                                    @endcomponent
                                                </div>

                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-3 col-md-3 col-lg-3">
                                                    <div>
                                                        VAT 10%
                                                    </div>
                                                </div>
                                                <div class="col-sm-9 col-md-9 col-lg-9">
                                                    {{-- @component('input::inputreadonly')
                                                    @slot('id', 'tax')
                                                    @slot('class', 'tax')
                                                    @slot('text', '')
                                                    @slot('value', '')
                                                    @endcomponent --}}
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text tax-symbol"></span>
                                                        </div>
                                                        <input type="text" id="tax" name="" class="form-control m-input tax" style="" value="" placeholder="" readonly="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-3 col-md-3 col-lg-3">
                                                    <div>
                                                        Other
                                                    </div>
                                                </div>
                                                <div class="col-sm-9 col-md-9 col-lg-9">
                                                    @component('input::inputreadonly')
                                                    @slot('id', 'other_price')
                                                    @slot('class', 'other_price')
                                                    @slot('text', '')
                                                    @slot('value', 'Rp 0,00')
                                                    @endcomponent
                                                </div>
                                            </div>

                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-3 col-md-3 col-lg-3">
                                                    <div>
                                                        Grand Total
                                                    </div>
                                                </div>
                                                <div class="col-sm-9 col-md-9 col-lg-9">
                                                    @component('input::inputreadonly')
                                                    @slot('id', 'grand_total')
                                                    @slot('class', 'grand_total')
                                                    @slot('text', '')
                                                    @slot('value', '')
                                                    @endcomponent
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-3 col-md-3 col-lg-3">
                                                    <div>
                                                        Grand Total Rupiah
                                                    </div>
                                                </div>
                                                <div class="col-sm-9 col-md-9 col-lg-9">
                                                    @component('input::inputreadonly')
                                                    @slot('id', 'grand_totalrp')
                                                    @slot('class', 'grand_totalrp')
                                                    @slot('text', '')
                                                    @slot('value', '')
                                                    @endcomponent
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row" style="display:none">
                                                <div style="color:red;" class="col-sm-3 col-md-3 col-lg-3">
                                                    <div>
                                                        Due Payment Amount
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    @component('input::inputreadonly')
                                                    @slot('id', 'due_payment')
                                                    @slot('class', 'due_payment')
                                                    @slot('text', '')
                                                    @slot('value', '')
                                                    @endcomponent
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="form-group m-form__group row">
                                                <div id="saveheader" class="col-sm-12 col-md-12 col-lg-12 footer">
                                                    <div class="flex">
                                                        <div class="action-buttons">
                                                            @component('frontend.common.buttons.submit')
                                                            @slot('type','button')
                                                            @slot('id', 'add-invoice')
                                                            @slot('class', 'add-invoice')
                                                            @endcomponent

                                                            @include('frontend.common.buttons.reset')

                                                            @include('frontend.common.buttons.back')
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
<input hidden id="profitcenttype111" class="test123456" value="">
@include('cashbookview::coamodal')
@include('invoiceview::refquomodal')
@include('invoiceview::coamodal1')
@endsection

@push('header-scripts')
<style>
    #map {
        height: 200px;
    }
</style>
<style>
    fieldset {
        margin-bottom: 30px;
    }

    .padding-datatable {
        padding: 0px
    }

    .margin-info {
        margin-left: 5px
    }
</style>
@endpush
@push('footer-scripts')

<script type="text/javascript">
    $("#type_website").on('change', function() {});
    let simpan = $('.tes').on('click', '.save', function() {
        var usertype = [];
        $("select[name=project]").each(function() {
            usertype.push($(this).val());
            // alert($(this).val());
        });
        var ajaxdata = {
            "UserType": usertype
        };

        console.log(JSON.stringify(ajaxdata));
    });
</script>
<script>
    function initMap() {
        var myLatLng = {
            lat: -7.265757,
            lng: 112.734146
        };

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: myLatLng
        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Hello World!'
        });
    }

    var n_invoice_count = 0;
    var customers = "";
    var attention = "";
    var atten_array = {};
    var currency = "";
    var uuidquo = "";
    var currencyCode = "";
    var tipetax = "";
    var tax = 0;
    let ForeignFormatter = "";

    var subtotal = 0;
    let other_total = 0;
    let schedule_payment = "";
    let grand_total1 = 0;
    let convertidr = 0;
    let dataSet = "";
    var profitcenttype = "";
    let manhour_price = 0;
    let facility_price = 0;
    let material_price = 0;
    let others_price = 0;
</script>
<script src="{{ asset('js/frontend/functions/repeater-core.js') }}"></script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ $browser_key }}&callback=initMap"></script>

<script src="{{ asset('js/frontend/functions/select2/customer.js') }}"></script>
{{-- <script src="{{ asset('js/frontend/functions/fill-combobox/customer.js') }}"></script> --}}

<!--<script src="{{ asset('vendor/courier/frontend/functions/select2/currency.js') }}"></script>-->
{{-- <script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/currencyfa.js') }}"></script> --}}
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/currencyfa.js')}}"></script>
<script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>
<script>
        // remove dot separator in currency format
        function removeDot(val) {
            return val.split('.').join('');
        }

        function getSeparator() {
            let currency = $('#currency').val()

            if (currency == 'idr') {
                separator = 'Rp ';
            }

            if (currency == 'usd') {
                separator = 'US$';
            }

            return separator;
        }

        // make input becom integer by remove symbol and remove dot separator
        function makeInt(param) {
            let separator = getSeparator();
            let val = removeDot(param.split(separator)[1]);
            return parseInt(val);
        }

        function addCommas(nStr)
        {
                nStr += '';
                x = nStr.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                        x1 = x1.replace(rgx, '$1' + '.' + '$2');
                }
                return x1 + x2;
        }

    $(document).ready(function() {
            $('._select2').select2({
            placeholder: "Select",
            });

            $('body').on('input', '#tax', function() {

                let tax = parseInt(removeDot($(this).val()));

        let subtotal = parseInt($("#sub_total_val").val());
        let discount_amount = parseInt($("#total_discount_val").val());
        let other_total = parseInt($("#other_price_val").val());

                console.table({
            'subtotal' : subtotal,
            'discount_amount' : discount_amount,
            'other_total' : other_total,
                });

                let grandtotal = subtotal - discount_amount + tax + other_total;
                let grandtotalrp = (subtotal - discount_amount + tax + other_total) * $('#exchange_rate1111').val();

                $("#grand_total_val").val(
                    grandtotal
                );

                $("#grand_total").val(
                    `${getSeparator()}${addCommas(grandtotal)},00`
                );

                $("#grand_totalrp_val").val(
                    grandtotalrp
                );

                $("#grand_totalrp").val(
                    `Rp ${addCommas(grandtotalrp)},00`
                );

              // skip for arrow keys
              if(event.which >= 37 && event.which <= 40) return;

              // format number
              $(this).val(function(index, value) {
                return value
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
              });

            });

      var others_data = "";
      $(".checkprofit").on('click', function(event) {
          //console.log($(this).data('id'));
          window.profitcenttype = $(this).data('id');
          console.log(window.profitcenttype);
          $('#proritcenttype111').val(window.profitcenttype);
          $('.test123456').val(window.profitcenttype);
          console.log($('.test123456').val());
          console.log($('#proritcenttype111').val());
          //console.log(proritcent_type);
          //(... rest of your JS code)
      });
    });
</script>

<script src="{{ asset('js/frontend/functions/select2/ref.js') }}"></script>
<script src="{{ asset('js/frontend/functions/select2/phone.js') }}"></script>
<script src="{{ asset('js/frontend/functions/select2/email.js') }}"></script>
<script src="{{ asset('js/frontend/functions/select2/fax.js') }}"></script>
{{-- <script src="{{ asset('vendor/courier/frontend/functions/select2/bank.js') }}"></script> --}}
{{-- <script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/bank.js') }}"></script> --}}
<!--<script src="{{ asset('js/frontend/functions/select2/address.js') }}"></script>-->
<script src="{{ asset('vendor/courier/frontend/functions/select2/city.js') }}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/select2/country.js') }}"></script>
<script src="{{ asset('js/frontend/functions/select2/attn.js') }}"></script>

<script src="{{ asset('js/frontend/quotation/form-reset.js') }}"></script>
<script src="{{ asset('js/frontend/functions/datepicker/date.js')}}"></script>
<!--<script src="{{ asset('js/frontend/quotation/workpackage.js') }}"></script>-->
<script src="{{ asset('js/frontend/quotation/create.js') }}"></script>
<!--<script src="{{ asset('vendor/courier/frontend/invoice/scheduled-payment.js') }}"></script>-->
<!--<script src="{{ asset('js/custom.js') }}"></script>-->
<script src="{{ asset('vendor/courier/frontend/invoice/coamodal-invoice.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/invoice/tablelist.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/invoice/refquomodal-invoice.js')}}"></script>
<script src="{{ asset('js/frontend/functions/summernote.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {

        let _url = window.location.origin;

        $('body').on('change', '#currency', function() {
            let val = $(this).val();

            if (val == 'idr') {
                $('#exchange_rate1111').val(1);
                $('#exchange_rate1111').attr('disabled', 'disabled');
            }
        });

        $('.bankinfo').select2({
            ajax: {
                url: _url+'/bankfa-internal-select2',
                dataType: 'json'
            },
        });

        $('.bankinfo').on('change', function () {
            //console.log(this.value);
            let uuid = this.value
            let parent = $(this).parents('.form-group');
            let bai_header = parent.find('#bai_header');
            let bai = parent.find('#bai');

            $.ajax({
                url: '/bankfa/' + uuid,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    bai_header.removeAttr('hidden');
                    bai.val(data.name);
                }
            });
        });

    });
</script>

@endpush
