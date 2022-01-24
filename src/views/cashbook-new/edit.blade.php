@extends('frontend.master')

@section('faCashbook', 'm-menu__item--active')
@section('content')
<div class="m-subheader hidden">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Cashbook
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
                            Cashbook
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
@include('cashbookview::coamodal')
@include('cashbooknewview::modal-coa')
<div class="m-content">
    <input type="hidden" class="form-control form-control-danger m-input" name="cashbook_uuid" value="{{Request::segment(2)}}">
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
                                Cashbook
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__body">
                        <form id="SupplierInvoiceGRNForm">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group row ">
                                    @if ($cashbook->cashbook_ref)
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <label class="form-control-label">
                                                Cashbook Reference
                                            </label>

                                            <select class="form-control m-input _select2" name="cashbook_ref" id="cashbook_ref" disabled>
                                                <option value=""></option>
                                                @for ($index_cashbook_ref=0; $index_cashbook_ref < count($cashbook_ref); $index_cashbook_ref++)
                                                    @php
                                                        $arr = $cashbook_ref[$index_cashbook_ref]
                                                    @endphp
                                                    <option value="{{$arr->transactionnumber}}" {{ ($arr->transactionnumber == $cashbook->cashbook_ref)? 'selected': '' }}>
                                                        {{$arr->transactionnumber}}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    @endif
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                            Cashbook Type @include('label::required')
                                        </label>

                                        <select class="form-control m-input _select2" name="cashbook_type" id="cashbook_types" disabled>
                                            <option value="bp" {{ (strpos($cashbook->transactionnumber, 'CBPJ') !== false)? 'selected': '' }}>Bank Payment</option>
                                            <option value="br" {{ (strpos($cashbook->transactionnumber, 'CBRJ') !== false)? 'selected': '' }}>Bank Receive</option>
                                            <option value="cp" {{ (strpos($cashbook->transactionnumber, 'CCPJ') !== false)? 'selected': '' }}>Cash Payment</option>
                                            <option value="cr" {{ (strpos($cashbook->transactionnumber, 'CCRJ') !== false)? 'selected': '' }}>Cash Receive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-control-label">
                                            Date Transaction @include('label::required')
                                        </label>

                                        @component('input::datepicker')
                                            @slot('id', 'date')
                                            @slot('text', 'Date')
                                            @slot('name', 'transactiondate')
                                            @slot('id_error', 'date')
                                            @slot('value', $cashbook->transactiondate->format('d-m-Y'))
                                        @endcomponent
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label class="form-control-label">
                                            Project
                                        </label>

                                        <select class="form-control m-input" name="id_project" id="project">
                                          @if (@$cashbook->project)
                                            <option value="{{$cashbook->project->id}}" selected>{{$cashbook->project->code}}</option>
                                          @else
                                            <option value="">-- Select --</option>
                                          @endif
                                        </select>
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <label class="form-control-label">
                                            Quotation Workshop
                                        </label>

                                        <select class="form-control m-input" name="quotation_workshop_id" id="quotation_workshop">
                                          @if (@$cashbook->quotation_workshop)
                                            <option value="{{$cashbook->quotation_workshop->id}}" selected>{{$cashbook->quotation_workshop->code}}</option>
                                          @else
                                            <option value="">-- Select --</option>
                                          @endif
                                        </select>
                                    </div>

                                    <div class="col-sm-6 col-md-6 col-lg-6 mt-2">
                                        <label class="form-control-label">
                                            Department
                                        </label>
                                        <select name="company_department" id="company_department" class="form-control _select2">
                                            <option value="">-- Select --</option>
                                            @for ($index_department = 0; $index_department < count($department); $index_department++)
                                                <option
                                                    value="{{$department[$index_department]->name}}"
                                                    {{($cashbook->company_department == $department[$index_department]->name)? 'selected' : ''}}
                                                >
                                                    {{$department[$index_department]->name}}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6 mt-2">
                                        <label class="form-control-label">
                                            Location
                                        </label>

                                        <select class="form-control _select2" name="location" style="width:100%">
                                            <option value=""></option>
                                            <option value="sidoarjo" {{(strtolower($cashbook->location) == 'sidoarjo')? 'selected': ''}}>Sidoarjo</option>
                                            <option value="surabaya" {{(strtolower($cashbook->location) == 'surabaya')? 'selected': ''}}>Surabaya</option>
                                            <option value="jakarta" {{(strtolower($cashbook->location) == 'jakarta')? 'selected': ''}}>Jakarta</option>
                                            <option value="biak" {{(strtolower($cashbook->location) == 'biak')? 'selected': ''}}>Biak</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6 mt-2">
                                        <label class="form-control-label">
                                            Payment To @include('label::required')
                                        </label>

                                        @component('input::text')
                                            @slot('id', 'payment_to')
                                            @slot('text', 'Payment To')
                                            @slot('name', 'personal')
                                            @slot('id_error', 'payment_to')
                                            @slot('value', $cashbook->personal)
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6 mt-2">
                                        <label class="form-control-label">
                                            Ref No @include('label::required')
                                        </label>

                                        @component('input::text')
                                            @slot('id', 'ref_no')
                                            @slot('text', 'Ref No')
                                            @slot('name', 'refno')
                                            @slot('id_error', 'ref_no')
                                            @slot('value', $cashbook->refno)
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6 mt-2">
                                        <label class="form-control-label">
                                            Exchange Rate @include('label::required')
                                        <span id="requi" class="requi" style="font-weight: bold;color:red">*</span>
                                        </label>
                                        @component('input::number')
                                            @slot('id', 'exchange')
                                            @slot('text', 'exchange')
                                            @slot('name', 'exchangerate')
                                            @slot('value', (int) $cashbook->exchangerate)
                                        @endcomponent
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <label class="form-control-label">
                                          Multi Currency
                                        </label>
                                        @component('input::checkbox')
                                            @slot('id', 'multy_currency')
                                            @slot('name', 'multy_currency')
                                            @slot('value', '1')
                                            @slot('disabled', 'disabled')
                                            @if ($cashbook->second_currency)
                                              @slot('checked', 'checked')
                                            @endif
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6 mt-2">

                                      <div class="form-group">
                                        <label class="form-control-label">
                                            Currency @include('label::required')
                                        </label>
                                        <select id="currency" name="currency" class="form-control m-select2" disabled>
                                            @foreach ($currency as $x)
                                                <option value="{{ $x->code }}"
                                                    @if ($x->code == $cashbook->currency) selected @endif>
                                                    {{ $x->full }}
                                                </option>
                                            @endforeach
                                        </select>
                                      </div>

                                      @if ($cashbook->second_currency)
                                        <div class="form-group">
                                          <label class="form-control-label">
                                              Currency To @include('label::required')
                                          </label>
                                          <select id="double-currency" name="second_currency" class="double-currency form-control m-select2" disabled>
                                              <option value="" class="d-none">-- Select --</option>
                                              @foreach ($currency as $x)
                                                  <option value="{{ $x->code }}"
                                                      @if ($x->code == $cashbook->second_currency) selected @endif>
                                                      {{ $x->full }}
                                                  </option>
                                              @endforeach
                                          </select>
                                        </div>
                                      @endif

                                    </div>
                                  </div>
                                    
                                  </div>
                                  
                                  <div class="row">
                                    <div class="col-sm-6 col-md-6 col-lg-6 mt-2">
                                        <label class="form-control-label">
                                            Account Code @include('label::required')
                                        </label>

                                        @component('input::inputrightbutton')
                                            @slot('id', 'coa')
                                            @slot('text', 'coa')
                                            @slot('name', 'accountcode')
                                            @slot('type', 'text')
                                            @slot('style', 'width:100%')
                                            @slot('data_target', '#coa_modal')
                                            @slot('value', $cashbook->coa->code)
                                        @endcomponent
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6 mt-2">
                                        <label class="form-control-label">
                                            Account Code Name
                                        </label>

                                        @component('input::inputreadonly')
                                        @slot('id', 'acd')
                                        @slot('text', 'acd')
                                        @slot('name', 'account_name')
                                        @slot('value', $cashbook->coa->name)
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group m-form__group row">
                                            <div class="col-sm-12 col-md-12 col-lg-12 footer">
                                                <div class="row align-items-center">
                                                    <div class="col-xl-8 order-2 order-xl-1">
                                                        <div class="form-group m-form__group row align-items-center">
                                                            <div class="col-md-4">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 order-1 order-xl-2 m--align-right">
                                                        <button
                                                            type="button"
                                                            id="button_cushbook_adjustment"
                                                            name="create"
                                                            value=""
                                                            class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-primary btn-md"
                                                            style="display:none"
                                                            target=""
                                                            data-toggle="modal"
                                                            data-target="#modal_cashbook_adjustment"
                                                        >

                                                            <span>
                                                                <i class="la la-plus-circle"></i>
                                                                <span>Adjustment</span>
                                                            </span>
                                                        </button>

                                                        <button
                                                            type="button"
                                                            id="button_cushbook_transaction"
                                                            name="create"
                                                            value=""
                                                            class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-primary btn-md"
                                                            style=""
                                                            target=""
                                                            data-toggle="modal"
                                                            data-target="#modal_cashbook_transaction"
                                                        >

                                                            <span>
                                                                <i class="la la-plus-circle"></i>
                                                                <span>Transaction</span>
                                                            </span>
                                                        </button>
                                                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="m-portlet m-portlet--mobile">
                                                    <div class="m-portlet__body">
                                                        <div class="coa_datatable" id="scrolling_both"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">

                                  <div class="col-md-6">
                                    <div class="form-group m-form__group row">
                                        <div class="col-sm-3 col-md-3 col-lg-3">
                                            <div>
                                                Total Debit
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                          <input type="text" class="form-control" disabled id="total_debit">
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <div class="col-sm-3 col-md-3 col-lg-3">
                                            <div>
                                                Total Credit
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                          <input type="text" class="form-control" disabled id="total_credit">
                                        </div>
                                    </div>
                                  </div>

                                </div>
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <label class="form-control-label">
                                            Remark
                                        </label>

                                        @component('input::textarea')
                                            @slot('id', 'remark')
                                            @slot('text', 'Remark')
                                            @slot('name', 'description')
                                            @slot('rows','5')
                                            @slot('value', $cashbook->description)
                                        @endcomponent
                                    </div>
                                </div>

                                {{-- Adjustment 1 --}}
                                {{-- <div class="form-group m-form__group row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <h2>Adjustment 1</h2>
                                        <div class="form-group m-form__group row">
                                            <div class="col-sm-12 col-md-12 col-lg-12 footer">
                                                <div class="row align-items-center">
                                                    <div class="col-xl-8 order-2 order-xl-1">
                                                        <div class="form-group m-form__group row align-items-center">
                                                            <div class="col-md-4">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 order-1 order-xl-2 m--align-right">
                                                        @component('buttons::create-new')
                                                            @slot('text', 'Account Code')
                                                            @slot('data_target', '#coa_modal')
                                                        @endcomponent
                                                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="m-portlet m-portlet--mobile">
                                                    <div class="m-portlet__body">
                                                        <div class="adjustment1_datatable" id="scrolling_both"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- Adjustment 2 --}}
                                {{-- <div class="form-group m-form__group row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <h2>Adjustment 2</h2>
                                        <div class="form-group m-form__group row">
                                            <div class="col-sm-12 col-md-12 col-lg-12 footer">
                                                <div class="row align-items-center">
                                                    <div class="col-xl-8 order-2 order-xl-1">
                                                        <div class="form-group m-form__group row align-items-center">
                                                            <div class="col-md-4">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 order-1 order-xl-2 m--align-right">
                                                        @component('buttons::create-new')
                                                            @slot('text', 'Account Code')
                                                            @slot('data_target', '#coa_modal')
                                                        @endcomponent
                                                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="m-portlet m-portlet--mobile">
                                                    <div class="m-portlet__body">
                                                        <div class="adjustment2_datatable" id="scrolling_both"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="form-group m-form__group row ">
                                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">
                                        <div class="action-buttons">
                                          @if (@$page_type != 'show')
                                            @component('buttons::submit')
                                                @slot('type', 'button')
                                                @slot('id','cashbook_save')
                                            @endcomponent

                                            @include('buttons::reset')

                                            @include('buttons::back')
                                          @endif
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
{{-- modal transaction cashbook --}}
<div class="modal fade" id="modal_cashbook_transaction" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitleModalJournal">Cashbook Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="CoaForm">
                    <input type="hidden" name="transactionnumber" value="{{$cashbook->transactionnumber}}">
                    <input type="hidden" class="form-control form-control-danger m-input" name="uuid" id="uuid">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="form-control-label">
                                    Account
                                </label>
                                @component('input::select2')
                                    @slot('id', '_accountcode')
                                    @slot('text', 'Account Code')
                                    @slot('name', 'code_a')
                                    @slot('id_error', 'accountcode')
                                @endcomponent
                            </div>
                        </div>
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="form-control-label">
                                    Amount @include('label::required')
                                </label>

                                @component('input::number')
                                    @slot('id', 'amount')
                                    @slot('text', 'amount')
                                    @slot('name', 'amount_a')
                                @endcomponent
                            </div>
                        </div>
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="form-control-label">
                                    Project
                                </label>

                                @component('input::select')
                                    @slot('id', 'id_project')
                                    @slot('text', 'id_project')
                                    @slot('name', 'id_project')
                                    @slot('class', 'project')
                                @endcomponent
                            </div>
                        </div>
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="form-control-label">
                                    Remark
                                </label>

                                @component('input::textarea')
                                    @slot('id', 'remark')
                                    @slot('text', 'remark')
                                    @slot('name', 'description_a')
                                    @slot('rows','5')
                                @endcomponent
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="flex">
                            <div class="action-buttons">
                                <div class="flex">
                                    <div class="action-buttons">
                                        @component('buttons::submit')
                                            @slot('id', 'create_cashbooka')
                                            @slot('type', 'button')
                                        @endcomponent

                                        @include('buttons::reset')

                                        @include('buttons::close')
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

{{-- modal adjustment cashbook --}}
<div class="modal fade" id="modal_cashbook_adjustment" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitleModalJournal">Cashbook Adjustment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="CoaForm">
                                        <input type="hidden" name="transactionnumber" value="{{$cashbook->transactionnumber}}">
                    <input type="hidden" class="form-control form-control-danger m-input" name="uuid" id="uuid">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="form-control-label">
                                  Account
                                </label>
                                @component('input::select2')
                                  @slot('id', '_accountcode_adj')
                                  @slot('text', 'Account Code')
                                  @slot('name', 'code_b')
                                  @slot('id_error', 'accountcode')
                                @endcomponent
                            </div>
                        </div>
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Debit @include('label::required')
                                </label>

                                @component('input::number')
                                    @slot('id', 'debit_b')
                                    @slot('text', 'debit_b')
                                    @slot('name', 'debit_b')
                                    @slot('value', 0)
                                @endcomponent
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Credit @include('label::required')
                                </label>

                                @component('input::number')
                                    @slot('id', 'credit_b')
                                    @slot('text', 'credit_b')
                                    @slot('name', 'credit_b')
                                    @slot('value', 0)
                                @endcomponent
                            </div>
                        </div>
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="form-control-label">
                                    Remark
                                </label>

                                @component('input::textarea')
                                    @slot('id', 'remark')
                                    @slot('text', 'remark')
                                    @slot('name', 'description_b')
                                    @slot('rows','5')
                                @endcomponent
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="flex">
                            <div class="action-buttons">
                                <div class="flex">
                                    <div class="action-buttons">
                                        @component('buttons::submit')
                                            @slot('id', 'create_cashbook_adjustment')
                                            @slot('type', 'button')
                                        @endcomponent

                                        @include('buttons::reset')

                                        @include('buttons::close')
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

{{-- modal adjustment edit cashbook --}}
<div class="modal fade" id="modal_cashbook_adjustment_edit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TitleModalJournal">Cashbook Adjustment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="CoaForm">
                    <input type="hidden" name="transactionnumber" value="{{$cashbook->transactionnumber}}">
                    <input type="hidden" class="form-control form-control-danger m-input" name="uuid" id="uuid">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Account Code
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="account_code_b"
                                    value=""
                                    readonly
                                >
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Account Name
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="account_name_b"
                                    value=""
                                    readonly
                                >
                            </div>
                        </div>
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Debit @include('label::required')
                                </label>

                                @component('input::number')
                                    @slot('id', 'debit_b')
                                    @slot('text', 'debit_b')
                                    @slot('name', 'debit_b')
                                    @slot('value', 0)
                                @endcomponent
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <label class="form-control-label">
                                    Credit @include('label::required')
                                </label>

                                @component('input::number')
                                    @slot('id', 'credit_b')
                                    @slot('text', 'credit_b')
                                    @slot('name', 'credit_b')
                                    @slot('value', 0)
                                @endcomponent
                            </div>
                        </div>
                        <div class="form-group m-form__group row ">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="form-control-label">
                                    Remark
                                </label>

                                @component('input::textarea')
                                    @slot('id', 'remark')
                                    @slot('text', 'remark')
                                    @slot('name', 'description_b')
                                    @slot('rows','5')
                                @endcomponent
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="flex">
                            <div class="action-buttons">
                                <div class="flex">
                                    <div class="action-buttons">
                                        @component('buttons::submit')
                                            @slot('id', 'update_cashbook_adjustment')
                                            @slot('type', 'button')
                                        @endcomponent

                                        @include('buttons::reset')

                                        @include('buttons::close')
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
<input hidden id="coaid">

@endsection

@push('footer-scripts')
    <script>
        $(document).ready(function() {
            let currentUrl = window.location.href;
            let _hash = currentUrl.split('#');
            if (_hash.length < 2) {
                window.location.href=currentUrl+"#faCashbook";
            } else {
                window.location.href=currentUrl;
            }
        });
    </script>
<script src="{{ asset('vendor/courier/frontend/functions/fill-combobox/coa.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/coamodal.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/currency.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/department.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/location.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/datepicker/date.js')}}"></script>

<script src="{{ asset('vendor/courier/frontend/functions/select2/cashbook-type.js')}}"></script>

<script src="{{ asset('vendor/courier/vendors/custom/datatables/datatables.bundle.js')}}"></script>

<script>
  let page_type = '{{ @$page_type ?? "" }}';
  let cashbook_type = '{{ substr($cashbook->transactionnumber, 2, 1) }}' // P: payment, R: receive;
</script>

<script src="{{ asset('vendor/courier/frontend/cashbook/edit.js')}}"></script>

<script>
  $(document).ready(function () {

    let _url = window.location.origin;

    $('#project').select2({
      ajax: {
        url: _url+'/journal/get-project-select2',
        dataType: 'json'
      },
    });

    $('#quotation_workshop').select2({
      ajax: {
        url: _url+'/journal/get-quotation_workshop-select2',
        dataType: 'json'
      },
    });
  });
</script>

@endpush
