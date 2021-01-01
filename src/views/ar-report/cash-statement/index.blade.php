@extends('frontend.master')

@section('faReport', 'm-menu__item--active')
@section('content')
@php
  use Illuminate\Support\Carbon;
@endphp
<style>
  tr.nowrap td, 
  td.nowrap {
    white-space: nowrap;
  }

  thead td {
    white-space: nowrap !important;
  }
</style>
<div class="m-subheader hidden">
  <div class="d-flex align-items-center">
    <div class="mr-auto">
      <h3 class="m-subheader__title m-subheader__title--separator">
        Cash Statement
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
                Cash Statement
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
              @slot('text', 'Report')
              @endcomponent

              <h3 class="m-portlet__head-text">
                Cash Statement
              </h3>
            </div>
          </div>
        </div>
        <div class="m-portlet m-portlet--mobile">
          <div class="m-portlet__body">
            <div class="m-portlet__body">
              <div class="form-group m-form__group row ">
                <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                  <h1>CASH STATEMENT</h1>
                  <h4>Period :
                    01 January 2020 - 31 January 2020</h4>
                </div>
              </div>

              <div class="form-group m-form__group row ">
                <div class="col-sm-12 col-md-12 col-lg-12">
                  <table width="100%" cellpadding="3">
                    <tr>
                      <td width="12%" valign="top">Account Code</td>
                      <td width="1%" valign="top">:</td>
                      <td width="77%" valign="top"></td>
                    </tr>
                    <tr>
                      <td>Account Name</td>
                      <td>:</td>
                      <td style="text-transform: capitalize"></td>
                    </tr>
                    <tr>
                      <td>Currency</td>
                      <td>:</td>
                      <td></td>
                    </tr>
                  </table>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12" style="overflow: auto">
                  {{-- content --}}
                  <div class="form-group m-form__group row ">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <table width="100%" cellpadding="4" class="table-body" page-break-inside: auto;>
                        <thead style="border-bottom:2px solid black;">
                          <tr>
                            <td width="" align="left" valign="top" style="padding-left:8px;"><b>Date</b></td>
                            <td width="40%" align="center" valign="top"><b>Description</b></td>
                            <td width="" align="right" valign="top"><b>Debit</b></td>
                            <td width="" align="right" valign="top"><b>Credit</b></td>
                            <td width="" align="right" valign="top"><b>Balance</b></td>
                          </tr>
                        </thead>
                        <tbody>
                            <tr valign="top">
                                <td>ambil dari tanggal transaksi</td>
                                <td>ambil dari transaksi remark/description</td>
                                <td align="right">Rp. 999.999.999.999</td>
                                <td align="right">Rp. 999.999.999.999</td>
                                <td align="right">Rp. 999.999.999.999</td>
                            </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  {{-- end content --}}
                </div>
              </div>

              <hr>
              <div class="form-group m-form__group row ">
                <div class="col-sm-12 col-md-12 col-lg-12 text-right">
                  <div class="action-buttons">
                    <button id="" type="button" name="submit" class="btn btn-primary btn-md add"
                      data-target="#modal_cash_statement" data-toggle="modal">
                      <span>
                        <i class="fa fa-filter"></i>
                        <span>Change Filter</span>
                      </span>
                    </button>

                    @component('buttons::submit')
                    @slot('text', 'Print')
                    @slot('icon', 'fa-print')
                    @endcomponent

                    <a href="" target="_blank" class="btn btn-success btn-md text-light" style="cursor: pointer">
                      <span>
                        <i class="fa fa-file-excel"></i>
                        <span>Export to Excel</span>
                      </span>
                    </a>

                    <a href="{{route('fa-report.index')}}" class="btn btn-secondary btn-md">
                      <span>
                        <i class="la la-undo"></i>
                      </span>
                      Back
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('arreport-cashstatementview::modal')
<input hidden id="coaid">

@endsection