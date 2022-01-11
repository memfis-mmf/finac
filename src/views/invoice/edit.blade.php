@extends('frontend.master')

@section('faAR', 'm-menu__item--active m-menu__item--open')
@section('faARInv', 'm-menu__item--active')
@section('content')
<style>
  .m-datatable__cell:last-of-type {
      vertical-align: top !important;
  }

  table td, table th {
    text-align: center !important;
  }

  table td:last-child {
    text-align: right !important;
  }

  .note-editable {
    padding-top: 20px !important;
  }

  /* table tbody tr:last-child span{
    color: transparent !important;
  } */
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

                            @include('frontend.common.label.edit')

                            <h3 class="m-portlet__head-text">
                                Invoice
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body pt-1">
                        <form id="itemform" name="itemform" action="{{route('invoice.update', Request::segment(2))}}" method='post'>
													@csrf
                            <div class="m-portlet__body mb-0 px-2 pb-0">
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group m-form__group row mb-0">
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
                                                        @slot('value', @$quotation->number)
                                                        @endcomponent
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <fieldset class="border m-0 px-3 py-2">
                                                    <legend class="w-auto m-0">Identifier Customer</legend>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="m-portlet__head">
                                                            <div class="m-portlet__head-tools">
                                                                <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                                                                    <li class="nav-item m-tabs__item">
                                                                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1" role="tab">
                                                                            <i class="far fa-address-card"></i> General
                                                                        </a>
                                                                    </li>
                                                                    <li class="nav-item m-tabs__item">
                                                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab">
                                                                            <i class="la la-phone-square"></i> Contact
                                                                        </a>
                                                                    </li>
                                                                    <li class="nav-item m-tabs__item">
                                                                        <a class="nav-link m-tabs__link " data-toggle="tab" href="#m_tabs_6_3" role="tab">
                                                                            <i class="far fa-map"></i> Address
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="m-portlet__body m-0 px-2 py-2">
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
                                                                        <div class="col-sm-6 col-md-6">
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
                                                                        <div class="col-sm-6 col-md-6">
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
                                                                        <div class="col-sm-6 col-md-6">
                                                                            <label class="form-control-label">
                                                                                Phone
                                                                            </label>

                                                                            @component('frontend.common.input.select2')
                                                                            @slot('text', '+62xxxxxxx / 07777777')
                                                                            @slot('id', 'phone')
                                                                            @slot('name', 'phone')
                                                                            @endcomponent

                                                                        </div>
                                                                        <div class="col-sm-6 col-md-6">
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
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group m-form__group row mb-0">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group m-form__group row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                                        <label class="form-control-label">
                                                            Date @include('frontend.common.label.required')
                                                        </label>

                                                        @component('input::datepicker')
                                                          @slot('id', 'date')
                                                          @slot('text', 'Date')
                                                          @slot('name', 'date')
                                                          @slot('id_error', 'date')
                                                          @slot('value', $carbon::parse($invoice->transactiondate)->format('d-m-Y'))
                                                          @slot('id_error','requested_at')
                                                        @endcomponent
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group m-form__group row">
                                                        <div class="col-sm-6 col-md-6 col-lg-6 mb-2">
                                                            <label class="form-control-label">
                                                                Currency @include('frontend.common.label.required')
                                                            </label>

                                                            @component('input::inputreadonly')
                                                            @slot('id', '_currency')
                                                            @slot('text', 'Currency')
                                                            @slot('name', 'currency')
                                                            @slot('id_error', '_currency')
                                                            @slot('value', $currencycode->name)
                                                            @endcomponent
                                                        </div>
                                                        <div class="col-sm-6 col-md-6 col-lg-6 mb-2">
                                                            <label class="form-control-label">
                                                                Exchange Rate <span id="requi" class="requi" style="font-weight: bold;color:red">
                                                                    *
                                                                </span>
                                                            </label>

                                                            @component('input::numberreadonly')
                                                            @slot('id', '_exchange_rate1111')
                                                            @slot('text', '_exchange_rate1111')
                                                            @slot('name', 'exchangerate')
                                                            @slot('value', (float) $invoice->exchangerate)
                                                            @endcomponent
                                                        </div>
                                                    {{-- <div class="col-sm-12 col-md-12 col-lg-12 mb-2">

                                                    </div> --}}
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                                                        <label class="form-control-label">
                                                            Director
                                                        </label>
                                                        @component('frontend.common.input.input')
                                                        @slot('id', 'presdir')
                                                        @slot('name', 'presdir')
                                                        @slot('value', $invoice->presdir)
                                                        @endcomponent
                                                    </div>
                                                </div>
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-sm-5 col-md-5 col-lg-5 mb-2">
                                                            <label class="form-control-label">
                                                                Location
                                                            </label>
                                                            <select class="_select2 form-control" name="location" style="width:100%">
                                                                <option value=""></option>
                                                                <option value="sidoarjo" {{(strtolower($invoice->location) == 'sidoarjo')? 'selected': ''}}>Sidoarjo</option>
                                                                <option value="surabaya" {{(strtolower($invoice->location) == 'surabaya')? 'selected': ''}}>Surabaya</option>
                                                                <option value="jakarta" {{(strtolower($invoice->location) == 'jakarta')? 'selected': ''}}>Jakarta</option>
                                                                <option value="biak" {{(strtolower($invoice->location) == 'biak')? 'selected': ''}}>Biak</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-7 col-md-7 col-lg-7 mb-2">
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
                                    <div class="col-12 mb-4">
                                      <label class="form-control-label">
                                          Cash Advance
                                      </label>
                                      <select class="form-control cash_advance_id" name="cash_advance_id" id="cash_advance_id" style="width:100%">
                                        @if ($invoice->cash_advance_id)
                                          <option value="{{ $invoice->cash_advance_id }}" selected>{{ $invoice->cash_advance->transaction_number }}</option>
                                        @else
                                          <option value=""></option>
                                        @endif
                                      </select>
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <div class="col-sm-6 col-md-6 px-4">
                                        <label class="form-control-label">
                                            Bank Name Information @include('frontend.common.label.required')
                                        </label>
										<select class="form-control bankinfo" name="_bankinfo" id="" style="width:100%">
                                            <option value="">-- Select --</option>
												@for ($a=0; $a < count($banks); $a++)
												@php
													$x = $banks[$a];
												@endphp
    										<option value="{{$x->uuid}}" {{($x->id == $invoice->id_bank)? 'selected': ''}}>{{$x->full}}</option>
												@endfor
										</select>
                                    </div>
                                    <div class="col-sm-6 col-md-6 px-4">
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

                                <div class="form-group m-form__group row">
                                    <div class="col-sm-6 col-md-6 px-4">
                                        <select class="form-control bankinfo" name="_bankinfo2" id="" style="width:100%">
                                            <option value="">--Select--</option>
												@for ($a=0; $a < count($banks); $a++)
												@php
												$x = $banks[$a];
                                            @endphp

									    	<option value="{{$x->uuid}}" {{($x->id == $invoice->id_bank2)? 'selected': ''}}>{{$x->full}}</option>
												@endfor
										</select>
                                    </div>
                                    <div class="col-sm-6 col-md-6 px-4">
                                        <div {{(!$invoice->id_bank2)? 'hidden': ''}} id="bai_header">
                                            @component('input::inputreadonly')
                                            @slot('id', 'bai')
                                            @slot('name', 'bai')
                                            @slot('value', @$bankget2->name)
                                            @slot('text', 'Bank Account Information')
                                            @slot('id_error', 'bankaccount')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-6 col-md-6 px-4">
                                        <select class="form-control bankinfo" name="_bankinfo3" id="" style="width:100%">
                                            <option value="">--Select--</option>
												@for ($a=0; $a < count($banks); $a++)
												@php
												$x = $banks[$a];
                                            @endphp
								    		<option value="{{$x->uuid}}" {{($x->id == $invoice->id_bank3)? 'selected': ''}}>{{$x->full}}</option>
												@endfor
										</select>
                                    </div>
                                    <div class="col-sm-6 col-md-6 px-4">
                                        <div {{(!$invoice->id_bank3)? 'hidden': ''}} id="bai_header">
                                            @component('input::inputreadonly')
                                            @slot('id', 'bai')
                                            @slot('name', 'bai')
                                            @slot('value', @$bankget3->name)
                                            @slot('text', 'Bank Account Information')
                                            @slot('id_error', 'bankaccount')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                @if(@$quotation->number=="quotationsales")
                                    <div id="quotation-sales">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="m-portlet__head">
                                                <div class="m-portlet__head-tools">
                                                    <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                                                        <li class="nav-item m-tabs__item">
                                                            <a class="nav-link m-tabs__link active" data-toggle="tab" id="m_tab_6_1_1" href="#m_tabs_6_1_1" role="tab">
                                                                <i class="la la-cog"></i> Item List
                                                            </a>
                                                        </li>
                                                        <li class="nav-item m-tabs__item">
                                                            <a class="nav-link m-tabs__link" data-toggle="tab" id="m_tab_6_2_2" href="#m_tabs_6_2_2" role="tab">
                                                                <i class="la la-briefcase"></i> Additional Info
                                                            </a>
                                                        </li>
                                                        <li class="nav-item m-tabs__item">
                                                            <a class="nav-link m-tabs__link" data-toggle="tab" id="m_tab_6_3_3" href="#m_tabs_6_3_3" role="tab">
                                                                <i class="la la-briefcase"></i> Account/Profit Center
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-portlet__body">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="m_tabs_6_1_1" role="tabpanel">
                                                    @include('invoice-itemlistview::edit')
                                                </div>
                                                <div class="tab-pane" id="m_tabs_6_2_2" role="tabpanel">
                                                    @include('invoice-additionalview::edit')
                                                </div>
                                                <div class="tab-pane" id="m_tabs_6_3_3" role="tabpanel">
                                                    @include('invoice-apcview::edit')
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group m-form__group row">
                                                    <div id="saveheader" class="col-sm-12 col-md-12 col-lg-12 footer">
                                                        <div class="flex">
                                                            <div class="action-buttons">
                                                                @component('buttons::submit')
                                                                    @slot('text', 'Print')
                                                                    @slot('icon', 'fa-print')
                                                                    @slot('color', 'primary')
                                                                @endcomponent

                                                                @component('frontend.common.buttons.submit')
                                                                    @slot('type','button')
                                                                    @slot('id', 'edit-invoice-sales')
                                                                    @slot('class', 'edit-invoice-sales')
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
                                @else
                                    <div id="hiddennext">
                                    <div class="form-group m-form__group row">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <fieldset class="border p-2">
                                                    <legend class="w-auto">Profit Center :</legend>
                                                    <div class="row">
                                                        <div class="col-sm-1 col-md-1">
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
                                                        <div class="col-sm-3 col-md-3">
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

                                                        <div class="col-sm-8 col-md-8">
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
                                                            <div style="margin-top:22px" class="col-sm-12 col-md-12 col-lg-12">
                                                                @component('input::inputreadonly')
                                                                @slot('id', 'facility_name')
                                                                @slot('name', 'facility_name')
                                                                @slot('value', "{$facility->name}")
                                                                @slot('text', '')
                                                                @slot('id_error', 'facility_name')
                                                                @endcomponent
                                                            </div>
                                                            <div style="margin-top:23px" class="col-sm-12 col-md-12 col-lg-12">
                                                                @component('input::inputreadonly')
                                                                @slot('id', 'discount_name')
                                                                @slot('name', 'discount_name')
                                                                @slot('value', $discount->name)
                                                                @slot('text', '')
                                                                @slot('id_error', 'discount_name')
                                                                @endcomponent
                                                            </div>
                                                            <div style="margin-top:23px" class="col-sm-12 col-md-12 col-lg-12">
                                                                @component('input::inputreadonly')
                                                                @slot('id', 'ppn_name')
                                                                @slot('name', 'ppn_name')
                                                                @slot('value', $ppn->name)
                                                                @slot('text', '')
                                                                @slot('id_error', 'ppn_name')
                                                                @endcomponent
                                                            </div>
                                                            <div style="margin-top:23px" class="col-sm-12 col-md-12 col-lg-12">
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
                                                    {{-- <fieldset class="border p-2">
                                                        <legend class="w-auto">Scheduled Payment :</legend>

                                                        <table id="scheduled_payments_datatables" class="table table-striped table-bordered" width="80%">
                                                            <tfoot>
                                                                <th></th>
                                                                <th></th>
                                                                <th colspan="2"></th>
                                                            </tfoot>
                                                        </table>
                                                    </fieldset> --}}
                                            </div>
                                        </div>
                                        <center>
                                            <h4 id="subjectquo">Quotation Subject</h4>
                                        </center>
                                        {{-- <table class="table table-striped table-bordered table-hover table-checkable wpck-table mt-5">
                                        <thead>
                                            <th>No</th>
                                            <th>Workpackage Detail</th>
                                            <th>Total</th>
                                        </thead>
                                        </table> --}}
                                        <br />
                                        <div class="summary_datatable" id="scrolling_both"></div>
                                        <br>
                                        <hr>

                                        <div class="form-group m-form__group row">
                                            <div class="col-sm-12">
                                                {{-- <div class="form-group m-form__group row">
                                                    <div class="col-sm-3 col-md-3">
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
                                                    <div class="col-sm-6 col-md-6">
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
                                                </div> --}}

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
                                                      @slot('name', 'description')
                                                      @slot('text', '')
                                                      @slot('value', $invoice->description)
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
                                                      @slot('name', 'term_and_condition')
                                                      @slot('text', '')
                                                      @slot('value', $invoice->term_and_condition)
                                                      @endcomponent
                                                    </div>
                                                    <div class="col-sm-1 col-md-1 col-lg-1">
                                                    </div>
                                                    <div class="col-sm-1 col-md-1 col-lg-1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7 offset-md-7">
                                                <div class="form-group m-form__group row">
                                                    <div class="col-sm-3 col-md-3">
                                                        <div>
                                                            Subtotal
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 pr-5">
                                                        @component('input::inputreadonly')
                                                        @slot('id', 'sub_total')
                                                        @slot('class', 'sub_total text-right')
                                                        @slot('text', '')
                                                        @slot('value', $invoice->currencies->symbol.' '.number_format($invoice->subtotal, 2))
                                                        @endcomponent
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <div class="col-sm-3 col-md-3">
                                                        <div>
                                                            Discount Total
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 pr-5">
                                                        @component('input::inputreadonly')
                                                        @slot('id', 'total_discount')
                                                        @slot('class', 'total_discount text-right')
                                                        @slot('text', '0')
                                                        @slot('value', 	$invoice->currencies->symbol.' '.number_format(abs($invoice->discountvalue) * -1, 2))
                                                        @endcomponent
                                                    </div>

                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <div class="col-sm-3 col-md-3">
                                                        <div>
                                                            Total Before Tax
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 pr-5">
                                                        @component('input::inputreadonly')
                                                        @slot('id', 'total')
                                                        @slot('class', 'total text-right')
                                                        @slot('text', '0')
                                                        @slot('value', 	$invoice->currencies->symbol.' '.number_format($invoice->total, 2))
                                                        @endcomponent
                                                    </div>

                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <div class="col-sm-3 col-md-3">
                                                        <div>
                                                            Vat 10% ({{$invoice->quotations->taxes[0]->TaxPaymentMethod->code}})
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 pr-5">
                                                        @component('input::inputreadonly')
                                                        @slot('id', 'tax')
                                                        @slot('class', 'tax text-right')
                                                        @slot('text', '')
                                                        @slot('value', 	$invoice->currencies->symbol.' '.number_format($invoice->ppnvalue, 2))
                                                        @endcomponent
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <div class="col-sm-3 col-md-3">
                                                        <div>
                                                          Other Cost Total
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 pr-5">
                                                        @component('input::inputreadonly')
                                                        @slot('id', 'other_price')
                                                        @slot('class', 'other_price text-right')
                                                        @slot('text', '')
                                                        @slot('value', 	$invoice->currencies->symbol.' '.number_format($invoice->other_price, 2))
                                                        @endcomponent
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row">
                                                    <div class="col-sm-3 col-md-3">
                                                        <div>
                                                            Grand Total
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 pr-5">
                                                        @component('input::inputreadonly')
                                                        @slot('id', 'grandtotal')
                                                        @slot('class', 'grandtotal text-right')
                                                        @slot('text', '')
                                                        @slot('value', 	$invoice->currencies->symbol.' '.number_format($invoice->grandtotalforeign, 2))
                                                        @endcomponent
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <div class="col-sm-3 col-md-3">
                                                        <div>
                                                            Grand Total in IDR
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6 pr-5">
                                                        @component('input::inputreadonly')
                                                        @slot('id', 'grandtotalrp')
                                                        @slot('class', 'grandtotalrp text-right')
                                                        @slot('text', '')
                                                        @slot('value', 	'Rp.  '.number_format($invoice->grandtotal, 2))
                                                        @endcomponent
                                                    </div>
                                                </div>

                                                <div class="form-group m-form__group row" style="display:none">
                                                    <div style="color:red;" class="col-sm-3 col-md-3">
                                                        <div>
                                                            Due Payment Amount
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 col-md-6">
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
                                                              @if (@$page_type != 'show')
                                                                @component('frontend.common.buttons.submit')
                                                                @slot('type','submit')
                                                                @slot('id', 'edit-invoice')
                                                                @slot('class', 'edit-invoice')
                                                                @endcomponent

                                                                @include('frontend.common.buttons.reset')
                                                              @endif

                                                              @include('frontend.common.buttons.back')
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
<script>
  $(document).ready(function() {
    let currentUrl = window.location.href;
    let _hash = currentUrl.split('#');
    if (_hash.length < 2) {
      window.location.href=currentUrl+"#faAR";
    }

  });

  if ('{{ @$page_type }}' == 'show') {
    $('input').attr('disabled', 'disabled');
    $('select').attr('disabled', 'disabled');
    $('textarea').attr('disabled', 'disabled');
    $('button').attr('disabled', 'disabled');
    summernote_field = $('.summernote');

    $.each(summernote_field, function( index, value ) {
      $('.summernote').eq(index).summernote('disable');
    });
  }
</script>

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
<script src="{{ asset('js/frontend/functions/datepicker/date.js')}}"></script>
<!--<script src="{{ asset('js/frontend/quotation/workpackage.js') }}"></script>-->
<script src="{{ asset('js/frontend/quotation/create.js') }}"></script>
<!--<script src="{{ asset('js/frontend/quotation/repeater.js') }}"></script>-->
<!--<script src="{{ asset('js/custom.js') }}"></script>-->
<script src="{{ asset('vendor/courier/frontend/invoice/coamodal-invoice.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/invoice/tableshow.js')}}"></script>
<script src="{{ asset('vendor/courier/frontend/invoice/refquomodal-invoice.js')}}"></script>
<script src="{{ asset('js/frontend/functions/summernote.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() {
    let _url = window.location.origin;
    let _exchange_rate = 1;

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

    $('.cash_advance_id').select2({
      placeholder: '-- Select --',
      ajax: {
        url: _url+'/invoice/select2-cash-advance?customer={{ $invoice->customer->id }}',
        dataType: 'json'
      },
    });

    // select2 handler
		$('._select2').select2({
	    placeholder: "Select",
    });

    let _currency = '{{$currencycode->code}}';

    let locale = 'id';
    let IDRformatter = new Intl.NumberFormat(locale, { style: 'currency', currency: 'idr', minimumFractionDigits: 2, maximumFractionDigits: 2 });
    let ForeignFormatter = new Intl.NumberFormat(locale, { style: 'currency', currency: _currency, minimumFractionDigits: 2, maximumFractionDigits: 2 });
    let IDRformatterTax = new Intl.NumberFormat(locale, { style: 'currency', currency: 'idr', minimumFractionDigits: 0, maximumFractionDigits: 0 });
    let ForeignFormatterTax = new Intl.NumberFormat(locale, { style: 'currency', currency: _currency, minimumFractionDigits: 0, maximumFractionDigits: 0 });
    let numberFormat = new Intl.NumberFormat('id', { maximumSignificantDigits: 3, maximumFractionDigits: 2, minimumFractionDigits: 2 });

    // summary datatable
    let total = 0;
    let total1 = 0;
    var discount = 0;
    var tax = 0;
    let quotation = '{{$quotation->uuid}}';

    let manhour_price = 0;
    let material_price = 0;
    let facility_price = 0;
    let discount_price = 0;
    let ppn_price = 0;
    let others_price = 0;
    let grand_total1 = 0;
    let convertidr = 0;
    let other_total = 0;
    let schedule_payment = '';
    let dataSet = '';
    let discount_amount = 0;
    let tax_amount = 0;
    let no = 1;

    let exchange_rate = '{{(int)$invoice->exchangerate}}';
    $('.summary_datatable').mDatatable({
      data: {
        type: 'remote',
        source: {
          read: {
            method: 'GET',
            url: '/invoice/quotation/table/modal/{{$quotation->uuid}}/detail',
            map: function (raw) {
              let dataSet = raw;
              let total = subtotal = 0;
              var discount = 0;

              if (typeof raw.data !== 'undefined') {
                dataSet = raw.data;
              }

              return dataSet;
            }
          }
        },
        pageSize: 10,
        serverPaging: !1,
        serverSorting: !1

      },
      responsive: true,

      sortable: true,

      pagination: true,

      toolbar: {

        items: {

          pagination: {

            pageSizeSelect: [10, 20, 30, 50, 100],
          },
        },
      },

      search: {
        input: $('#generalSearch'),
      },

      rows: {


      },
      columns: [
        {
          field: 'code',
          title: 'No',
          class:'text-center',
          width: '80px',
          template: function (t) {
            // if this is other, return null
            // if (t.priceother != null) {
            //   return '';
            // }

            // return t.code;
            return no++;
          }},
          {
          field: 'description',
          title: 'Detail',
          class:'text-left',
          width: '400px',

          template: function (t) {
            if (t.htcrrcount == null && t.priceother == null) {
              var template = "";
              var basic = "&nbsp;&nbsp;&nbsp;&nbsp;Basic TaskCard " + t.basic + " item(s)<br/>";
              var sip = "&nbsp;&nbsp;&nbsp;&nbsp;SIP TaskCard " + t.sip + " item(s)<br/>";
              var cpcp = "&nbsp;&nbsp;&nbsp;&nbsp;CPCP TaskCard " + t.cpcp + " item(s)<br/>";
              var adsb = "&nbsp;&nbsp;&nbsp;&nbsp;AD/SB TaskCard " + t.adsb + " item(s)<br/>";
              var cmrwl = "&nbsp;&nbsp;&nbsp;&nbsp;CMR/AWL TaskCard " + t.cmrawl + " item(s)<br/>";
              var eo = "&nbsp;&nbsp;&nbsp;&nbsp;EO TaskCard " + t.eo + " item(s)<br/>";
              var ea = "&nbsp;&nbsp;&nbsp;&nbsp;EA TaskCard " + t.ea + " item(s)<br/>";
              var si = "&nbsp;&nbsp;&nbsp;&nbsp;SI TaskCard " + t.si + " item(s)";
              if (t.basic != 0 && 'basic' in t) {
                template += basic;
              }
              if (t.sip != 0 && 'sip' in t) {
                template += sip;
              }
              if (t.cpcp != 0 && 'cpcp' in t) {
                template += cpcp;
              }
              if (t.adsb != 0 && 'adsb' in t) {
                template += adsb;
              }
              if (t.cmrawl != 0 && 'cmrawl' in t) {
                template += cmrwl;
              }
              if (t.eo != 0 && 'eo' in t) {
                template += eo;
              }
              if (t.ea != 0 && 'ea' in t) {
                template += ea;
              }
              if (t.si != 0 && 'si' in t) {
                template += si;
              }

              materialitem = '';
              if ('materialitem' in t) {
                materialitem = t.materialitem;
              }

              return (
                '<p class="text-left mb-0">'+ "<b>" + t.pivot.description + "</b></p>"
                + "Facility <br/>"
                + "Material Need " + materialitem + " item(s)<br/>"
                + "Total " + t.total_manhours_with_performance_factor + " Manhours<br/>"
                + template

              );
            } else if (t.htcrrcount != null) {
              return (
                "&nbsp;&nbsp;&nbsp;&nbsp;HardTime TaskCard " + t.htcrrcount + " item(s)"

              );

            } else if (t.priceother != null) {
              return '';
            }
        }},
        {
          field: 'total',
          title: 'Total Amount',
          sortable: 'asc',
          class: 'text-right',
          filterable: !1,
          template: function (t, e, i) {

            if (_currency == 'idr') {
              multiple = t.quotations[0].exchange_rate;
            }else{
              multiple = 1;
            }

            // jika htcrr kosong dan priceother kosong
            if (t.htcrrcount == null && t.priceother == null) {

              if (_currency == 'idr') {
                facility_price += t.facilities_price_amount * multiple;
                material_price += t.mat_tool_price * multiple;
                manhour_price += t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount * multiple;

                _result =
                  '<br>' +
                  IDRformatter.format(t.facilities_price_amount * multiple) + '<br>' +
                  IDRformatter.format(t.mat_tool_price * multiple) + '<br>' +
                  IDRformatter.format(t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount * multiple) + '<br>'
                ;
              } else {

                facility_price += t.facilities_price_amount;
                material_price += t.mat_tool_price;
                manhour_price += t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount;

                _result =
                  '<br>' +
                  ForeignFormatter.format(t.facilities_price_amount) + '<br>' +
                  ForeignFormatter.format(t.mat_tool_price) + '<br>' +
                  ForeignFormatter.format(t.total_manhours_with_performance_factor * t.pivot.manhour_rate_amount) + '<br>'
              }

            } else if (t.htcrrcount != null) {
              $("#htcrr_price_val").val(t.price);

              if (_currency == 'idr') {
                _result = IDRformatter.format(t.price * multiple) + "<br/>"
              } else {
                _result = ForeignFormatter.format(t.price) + "<br/>"
              }
            } else if (t.priceother != null) {
              let _price_other = parseFloat(t.priceother) * multiple;

              _result = "<br/>";
            }

            // hide last line datalist
            count_data = $('.summary_datatable tbody tr').length;

            if (count_data > 1) {
              $('.summary_datatable tbody tr').eq(count_data - 1).find('span').css('color', 'transparent');
            }

            return _result;

          }
        },
      ],
    });
	})
</script>
<script>
    let scheduled_payments11 = {
        init: function() {

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
