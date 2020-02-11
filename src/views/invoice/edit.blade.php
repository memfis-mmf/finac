@extends('frontend.master')

@section('content')
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

                            @include('frontend.common.label.edit')

                            <h3 class="m-portlet__head-text">
                                Invoice
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <form id="itemform" name="itemform" action="{{route('invoice.update', Request::segment(2))}}" method='post'>
													@csrf
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

                                                        @component('input::inputreadonly')
                                                        @slot('text', 'Ref Quotation No')
                                                        @slot('id', 'refquono')
                                                        @slot('data_target', '#refquo_modal')
                                                        @slot('name', 'refquono')
                                                        @slot('id_error', 'refquono')
                                                        @slot('value', "{$quotation->number}")
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

                                                        @component('input::inputreadonly')
                                                        @slot('id', 'date')
                                                        @slot('text', 'Date')
                                                        @slot('name', 'date')
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

                                                        @component('input::inputreadonly')
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

                                                        @component('input::numberreadonly')
                                                        @slot('id', 'exchange_rate1111')
                                                        @slot('text', 'exchange_rate1111')
                                                        @slot('name', 'exchangerate')
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
                                                        @slot('value', $invoice->presdir)
                                                        @endcomponent
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <br />
                                                        <label class="form-control-label">
																													Location
                                                        </label>

																												<select class="_select2 form-control" name="location" style="width:100%">
																													<option value=""></option>
																													<option value="sidoarjo" {{($invoice->location == 'sidoarjo')? 'selected': ''}}>Sidoarjo</option>
																													<option value="surabaya" {{($invoice->location == 'surabaya')? 'selected': ''}}>Surabaya</option>
																													<option value="jakarta" {{($invoice->location == 'jakarta')? 'selected': ''}}>Jakarta</option>
																													<option value="biak" {{($invoice->location == 'biak')? 'selected': ''}}>Biak</option>
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
																														<option value="{{$x->name}}" {{($invoice->company_department == $x->name)? 'selected': ''}}>{{$x->name}}</option>
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

																				<select class="form-control" name="_bankinfo" id="" style="width:100%">
																					@for ($a=0; $a < count($banks); $a++)
																						@php
																							$x = $banks[$a];
																						@endphp

																						<option value="{{$x->uuid}}" {{($x->id == $invoice->id_bank)? 'selected': ''}}>{{$x->full}}</option>
																					@endfor
																				</select>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div id="bai_header">
                                            <label class="form-control-label">
                                                Bank Account Information
                                            </label>

                                            @component('input::inputreadonly')
                                            @slot('id', 'bai')
                                            @slot('name', 'bai')
                                            @slot('value', "{$bankget->name}")
                                            @slot('text', 'Bank Account Information')
                                            @slot('id_error', 'bankaccount')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <br />
                                <div id="hiddennext">
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
                                                            @slot('name', 'manhours')
                                                            @slot('type', 'text')
                                                            @slot('value', "{$manhours->code}")
                                                            @slot('style', 'width:100%')
                                                            @slot('data_target', '#coa_modal')
                                                            @endcomponent
                                                        </div>
                                                        <br />
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputrightbutton')
                                                            @slot('id', 'coa')
                                                            @slot('text', 'coa')
                                                            @slot('class', 'material')
                                                            @slot('name', 'material')
                                                            @slot('dataid','material')
                                                            @slot('value', "{$material->code}")
                                                            @slot('type', 'text')
                                                            @slot('style', 'width:100%')
                                                            @slot('data_target', '#coa_modal')
                                                            @endcomponent
                                                        </div>
                                                        <br />
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputrightbutton')
                                                            @slot('id', 'coa')
                                                            @slot('text', 'coa')
                                                            @slot('name', 'facility')
                                                            @slot('type', 'text')
                                                            @slot('value', "{$facility->code}")
                                                            @slot('class', 'facility')
                                                            @slot('dataid','facility')
                                                            @slot('style', 'width:100%')
                                                            @slot('data_target', '#coa_modal')
                                                            @endcomponent
                                                        </div>
                                                        <br />
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputrightbutton')
                                                            @slot('id', 'coa')
                                                            @slot('text', 'coa')
                                                            @slot('name', 'discount')
                                                            @slot('class', 'discount')
                                                            @slot('dataid','discount')
                                                            @slot('type', 'text')
                                                            @slot('value', $discount->code)
                                                            @slot('style', 'width:100%')
                                                            @slot('data_target', '#coa_modal')
                                                            @endcomponent
                                                        </div>
                                                        <br />
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputrightbutton')
                                                            @slot('id', 'coa')
                                                            @slot('text', 'coa')
                                                            @slot('name', 'ppn')
                                                            @slot('class', 'ppn')
                                                            @slot('dataid','ppn')
                                                            @slot('type', 'text')
                                                            @slot('value', $ppn->code)
                                                            @slot('style', 'width:100%')
                                                            @slot('data_target', '#coa_modal')
                                                            @endcomponent
                                                        </div>
                                                        <br />
                                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputrightbutton')
                                                            @slot('id', 'coa')
                                                            @slot('text', 'coa')
                                                            @slot('name', 'other')
                                                            @slot('value', "{$others->code}")
                                                            @slot('class', 'others')
                                                            @slot('dataid','others')
                                                            @slot('type', 'text')
                                                            @slot('style', 'width:100%')
                                                            @slot('data_target', '#coa_modal')
                                                            @endcomponent
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                                        <div style="margin-top:1px" class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputreadonly')
                                                            @slot('id', 'manhours_name')
                                                            @slot('name', 'manhours_name')
                                                            @slot('value', "{$manhours->name}")
                                                            @slot('text', '')
                                                            @slot('id_error', 'manhours_name')
                                                            @endcomponent
                                                        </div>
                                                        <div style="margin-top:22px" class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputreadonly')
                                                            @slot('id', 'material_name')
                                                            @slot('name', 'material_name')
                                                            @slot('text', '')
                                                            @slot('value', "{$material->name}")
                                                            @slot('id_error', 'material_name')
                                                            @endcomponent
                                                        </div>
                                                        <div style="margin-top:20px" class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputreadonly')
                                                            @slot('id', 'facility_name')
                                                            @slot('name', 'facility_name')
                                                            @slot('value', "{$facility->name}")
                                                            @slot('text', '')
                                                            @slot('id_error', 'facility_name')
                                                            @endcomponent
                                                        </div>
                                                        <div style="margin-top:20px" class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputreadonly')
                                                            @slot('id', 'discount_name')
                                                            @slot('name', 'discount_name')
                                                            @slot('value', $discount->name)
                                                            @slot('text', '')
                                                            @slot('id_error', 'discount_name')
                                                            @endcomponent
                                                        </div>
                                                        <div style="margin-top:20px" class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputreadonly')
                                                            @slot('id', 'ppn_name')
                                                            @slot('name', 'ppn_name')
                                                            @slot('value', $ppn->name)
                                                            @slot('text', '')
                                                            @slot('id_error', 'ppn_name')
                                                            @endcomponent
                                                        </div>
                                                        <div style="margin-top:20px" class="col-sm-12 col-md-12 col-lg-12">
                                                            @component('input::inputreadonly')
                                                            @slot('id', 'other_name')
                                                            @slot('name', 'other_name')
                                                            @slot('value', "{$others->name}")
                                                            @slot('text', '')
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
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-3 col-md-3 col-lg-3">
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
                                                </div>
                                            </div>

                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-3 col-md-3 col-lg-3">
                                                    <div class="m--align-left" style="padding-top:15px">
                                                        Freemark
                                                    </div>
                                                </div>
                                                <div class="col-sm-9 col-md-9 col-lg-9">
                                                    @component('input::textarea')
                                                    @slot('id', 'desc')
                                                    @slot('class', 'desc')
                                                    @slot('text', '')
                                                    @slot('value', "{$invoice->description}")
                                                    @endcomponent
                                                </div>
                                                <div class="col-sm-1 col-md-1 col-lg-1">
                                                </div>
                                                <div class="col-sm-1 col-md-1 col-lg-1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-3 col-md-3 col-lg-3">
                                                    <div>
                                                        Sub Total
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    @component('input::inputreadonly')
                                                    @slot('id', 'sub_total')
                                                    @slot('class', 'sub_total')
                                                    @slot('text', '')
                                                    @slot('value', $invoice->currencies->symbol.' '.number_format($invoice->grandtotalforeign / 1.1, 0, 0, '.'))
                                                    @endcomponent
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-3 col-md-3 col-lg-3">
                                                    <div>
                                                        Total Discount
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    @component('input::inputreadonly')
                                                    @slot('id', 'total_discount')
                                                    @slot('class', 'total_discount')
                                                    @slot('text', '0')
                                                    @slot('value', 	$invoice->currencies->symbol.' '.number_format($invoice->discountvalue, 0, 0, '.'))
                                                    @endcomponent
                                                </div>

                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-3 col-md-3 col-lg-3">
                                                    <div>
                                                        Tax 10%
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    @component('input::inputreadonly')
                                                    @slot('id', 'tax')
                                                    @slot('class', 'tax')
                                                    @slot('text', '')
                                                    @slot('value', 	$invoice->currencies->symbol.' '.number_format($invoice->grandtotalforeign / 1.1 * 0.1, 0, 0, '.'))
                                                    @endcomponent
                                                </div>
                                            </div>

                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-3 col-md-3 col-lg-3">
                                                    <div>
                                                        Grand Total
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    @component('input::inputreadonly')
                                                    @slot('id', 'grandtotal')
                                                    @slot('class', 'grandtotal')
                                                    @slot('text', '')
                                                    @slot('value', 	$invoice->currencies->symbol.' '.number_format($invoice->grandtotalforeign, 0, 0, '.'))
                                                    @endcomponent
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <div class="col-sm-3 col-md-3 col-lg-3">
                                                    <div>
                                                        Grand Total Rupiah
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    @component('input::inputreadonly')
                                                    @slot('id', 'grandtotalrp')
                                                    @slot('class', 'grandtotalrp')
                                                    @slot('text', '')
                                                    @slot('value', 	'Rp '.number_format($invoice->grandtotal, 0, 0, '.'))
                                                    @endcomponent
                                                </div>
                                            </div>

                                            <div class="form-group m-form__group row">
                                                <div style="color:red;" class="col-sm-3 col-md-3 col-lg-3">
                                                    <div>
                                                        Due Payment Amount
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6" style="display:none">
                                                    @component('input::inputreadonly')
                                                    @slot('id', 'due_payment')
                                                    @slot('class', 'due_payment')
                                                    @slot('text', '')
                                                    @slot('value', "{$invoice->schedule_payment}")
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
                                                            @slot('type','submit')
                                                            @slot('id', 'edit-invoice')
                                                            @slot('class', 'edit-invoice')
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
    let currencyCode = "{{$currencycode->code}}";
    var others_data = "";
    var customers = "";
    var attention = "";
    let atten_array = [];
    let invoice_uuid = "{{$invoice->uuid}}";
    var currency = "";
    var uuidquo = "";
    var tipetax = "";
    let bank_uuid = "{{$bankaccountget->uuid}}";
    var tax = 0;
    var subtotal = 0;
    let quotation_uuid = "{{$quotation->uuid}}";
    let other_total = 0;
    let schedule_payment = "";
    let grandtotal1 = 0;
    let convertidr = 0;
    let dataSchedule = "{{$quotation->scheduled_payment_amount}}";
    let dataScheduleClear = JSON.parse(dataSchedule.replace(/&quot;/g, '"'));
    let locale = 'id';
    let IDRformatter = new Intl.NumberFormat(locale, {
        style: 'currency',
        currency: 'idr',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    let ForeignFormatter = new Intl.NumberFormat(locale, {
        style: 'currency',
        currency: currencyCode,
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    var profitcenttype = "";
    let dataSet = "";
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
<!--<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/currencyfa.js') }}"></script>-->
<script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>
<script>
    $(document).ready(function() {
        console.log("jalan");
        let currencyCode = "{{$currencycode->code}}";
        var others_data = "";
        var customers = "";
        var attention = "";
        let atten_array = [];
        var currency = "";
        var uuidquo = "";
        var tipetax = "";
        let bank_uuid = "{{$bankaccountget->uuid}}";
        var tax = 0;
        var subtotal = 0;
        let quotation_uuid = "{{$quotation->uuid}}";
        let other_total = 0;
        let dataSchedule = "{{$quotation->scheduled_payment_amount}}";
        let dataScheduleClear = JSON.parse(dataSchedule.replace(/&quot;/g, '"'));
        let grandtotal1 = 0;
        let convertidr = 0;





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

        //console.log(quotation_uuid);
        $.ajax({
            url: '/invoice/quotation/datatables/modal/' + quotation_uuid + '/detail',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                //console.log(data.attention);
                customers = JSON.parse(data.customer);
                atten_inv = JSON.parse(data.attention);
                //console.log(atten_inv);
                attention = JSON.parse(customers.attention);
                //console.log(attention);
                currency = data.currency;
                var levels = customers.levels[0];
                $.each(attention, function(i, attention) {
                    console.log(atten_array);
                    atten_array[i] = attention.name;
                });
                //$('#attention').empty();
                $('select[name="attention"]').append(
                    "<option value=" + atten_inv.name + "> " + atten_inv.name + "</option>"
                );
                $('select[name="phone"]').append(
                    "<option value=" + atten_inv.phone + "> " + atten_inv.phone + "</option>"
                );
                $('select[name="fax"]').append(
                    "<option value=" + atten_inv.fax + "> " + atten_inv.fax + "</option>"
                );
                $('select[name="email"]').append(
                    "<option value=" + atten_inv.email + "> " + atten_inv.email + "</option>"
                );
                $("#name").val(customers.name);
                $("#level").val(levels.name);
                $("#refquono").val(data.number);
                $("#currency").val(currency.name);
                $("#address").val(customers.addresses[0].address);
                $("h3#subjectquo").html("Subject : " + data.title);
                currencyCode = currency.code;
                if (currency.code != "idr") {
                    $("#exchange_rate1111").attr("readonly", false);
                }

                $("#exchange_rate1111").val(data.exchange_rate);
                $.each(atten_array, function(key, value) {
                    $('select[name="attention"]').append(
                        '<option value="' + key + '">' + value + '</option>'
                    );
                });
                //$("#refquono").data("uuid", code);
                //console.log(code);
                //$('#refquo_modal').modal('hide');
            }
        });
    });
</script>

<script src="{{ asset('js/frontend/functions/select2/ref.js') }}"></script>
<script src="{{ asset('js/frontend/functions/select2/phone.js') }}"></script>
<script src="{{ asset('js/frontend/functions/select2/email.js') }}"></script>
<script src="{{ asset('js/frontend/functions/select2/fax.js') }}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/select2/bank.js') }}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/bank.js') }}"></script>
<!--<script src="{{ asset('js/frontend/functions/select2/address.js') }}"></script>-->
<script src="{{ asset('vendor/courier/frontend/functions/select2/city.js') }}"></script>
<script src="{{ asset('vendor/courier/frontend/functions/select2/country.js') }}"></script>
<script src="{{ asset('js/frontend/functions/select2/attn.js') }}"></script>

<script src="{{ asset('js/frontend/quotation/form-reset.js') }}"></script>
<!--<script src="{{ asset('js/frontend/functions/datepicker/date.js')}}"></script>-->
<!--<script src="{{ asset('js/frontend/quotation/workpackage.js') }}"></script>-->
<script src="{{ asset('js/frontend/quotation/create.js') }}"></script>
<!--<script src="{{ asset('js/frontend/quotation/repeater.js') }}"></script>-->
<!--<script src="{{ asset('js/custom.js') }}"></script>-->
<script src="{{ asset('vendor/courier/frontend/invoice/coamodal-invoice.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/invoice/tableshow.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/invoice/refquomodal-invoice.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('._select2').select2({
	    placeholder: "Select",
		});
	})
</script>
<script>
    let scheduled_payments11 = {
        init: function() {

            let scheduled_payment_datatable = $('#scheduled_payments_datatables').DataTable({
                data: dataScheduleClear,
                columns: [{
                        title: "Work Progress(%)",
                        data: "work_progress",
                        "render": function(data, type, row, meta) {
                            return data + "%";
                        }
                    },
                    {
                        title: "Amount",
                        data: "amount",
                        "render": function(data, type, row, meta) {
                            return ForeignFormatter.format(data);
                        }
                    },
                    {
                        title: "Amount(%)",
                        data: "amount_percentage",
                        "render": function(data, type, row, meta) {
                            return data + "%";
                        }
                    },
                    {
                        title: "Description",
                        data: "description"
                    }
                ],
                searching: false,
                paging: false,
                info: false,
                footer: true,
                "footerCallback": function(row, data, start, end, display) {

                    var api = this.api();
                    api.columns('0', {
                        page: 'current'
                    }).every(function() {
                        var sum = this.data();
                        let arr_work_progress = sum.join();
                        let max = arr_work_progress.split(",");
                        Array.prototype.max = function() {
                            return Math.max.apply(null, this);
                        };
                        $(api.column(0).footer()).html("Work Progress : " + max.max() + "%");
                    });
                    api.columns('1', {
                        page: 'current'
                    }).every(function() {
                        var sum = this
                            .data()
                            .reduce(function(a, b) {
                                var x = parseFloat(a) || 0;
                                var y = parseFloat(b) || 0;
                                return x + y;
                            }, 0);
                        $(api.column(1).footer()).html("Total Amount : " + ForeignFormatter.format(sum));
                    });

                    api.columns('2', {
                        page: 'current'
                    }).every(function() {
                        var sum = this
                            .data()
                            .reduce(function(a, b) {
                                var x = parseFloat(a) || 0;
                                var y = parseFloat(b) || 0;
                                return x + y;
                            }, 0);
                        $(api.column(2).footer()).html("Total Amount : " + sum + "%");
                    });

                }

            });

            $('.add_scheduled_row').on('click', function() {
                $("#work_progress_scheduled-error").html('');
                $("#amount_scheduled-error").html('');
                $("#work_progress_scheduled").removeClass('is-invalid');
                $("#amount_scheduled").removeClass('is-invalid');
                let total = $('#grandtotal').attr('value');
                let work_progress_scheduled = $("#work_progress_scheduled").val();
                let amount_scheduled = $("#amount_scheduled").val();
                let description_scheduled = $("#description_scheduled").val();
                let amount_scheduled_percentage = (amount_scheduled / total) * 100;
                let sub_total = calculate_amount();
                let max = calculate_progress();
                let remaining = total - sub_total;
                if (work_progress_scheduled < max) {
                    $("#work_progress_scheduled-error").html('Work progess precentage cannot lower than ' + max + '%');
                    $("#work_progress_scheduled").addClass('is-invalid');
                } else if (work_progress_scheduled > 100) {
                    $("#work_progress_scheduled-error").html('Work progess precentage cannot exceed 100%');
                    $("#work_progress_scheduled").addClass('is-invalid');
                    return;
                } else if (parseInt(amount_scheduled) > parseInt(total)) {
                    $("#amount_scheduled-error").html('Amount inserted cannot exceed remaining ' + ForeignFormatter.format(remaining) + ' of total');
                    $("#amount_scheduled").addClass('is-invalid');
                    return;
                } else {
                    let newRow = [];
                    newRow["description"] = description_scheduled;
                    newRow["work_progress"] = work_progress_scheduled;
                    newRow["amount"] = amount_scheduled;
                    newRow["amount_percentage"] = amount_scheduled_percentage;
                    scheduled_payment_datatable
                        .row.add(newRow)
                        .draw();

                    $("#work_progress_scheduled").val(0);
                    $("#amount_scheduled").val(0);
                    $("#description_scheduled").val("");
                }
            });

            $('#scheduled_payments_datatables tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    scheduled_payment_datatable.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });

            $('.delete_row').on('click', function() {
                scheduled_payment_datatable.row('.selected').remove().draw(false);
            });

            // calculate amount
            function calculate_amount() {
                let scheduled_payment_datatable = $('#scheduled_payments_datatables').DataTable();
                let total = scheduled_payment_datatable.column(1).data().reduce(function(a, b) {
                    var x = parseFloat(a) || 0;
                    var y = parseFloat(b) || 0;
                    return x + y;
                }, 0);

                return total;
            }

            // calculate progress
            function calculate_progress() {
                let scheduled_payment_datatable = $('#scheduled_payments_datatables').DataTable();
                let arrays = scheduled_payment_datatable.column(0).data();
                let max = Math.max(arrays.join());
                return max;
            }
        }
    };

    jQuery(document).ready(function() {
      scheduled_payments11.init();
    });
</script>

@endpush
