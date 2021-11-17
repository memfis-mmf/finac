@extends('frontend.master')

@section('faGL', 'm-menu__item--active')
@section('content')
<style>
  .dataTables_paginate a {
    padding: 0 10px;
  }

  .dataTables_info {
    margin-top: -10px;
    margin-left: 10px;
  }

  .dataTables_length {
    margin-top: -30px;
    visibility: hidden;
  }

  .dataTables_length select {
    visibility: visible;
  }

  table {
    min-width: 100%;
  }

  table td {
    white-space: nowrap !important;
  }
</style>

<input type="hidden" name="_beginDate" value="{{$beginDate}}">
<input type="hidden" name="_endingDate" value="{{$endingDate}}">
<input type="hidden" name="_coa" value="{{$coa}}">

<div class="m-subheader hidden">
  <div class="d-flex align-items-center">
    <div class="mr-auto">
      <h3 class="m-subheader__title m-subheader__title--separator">
        General Ledger
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
              General Ledger
            </span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
{{-- <div class="text-center p-5 text-white" style="background:#5f6b5e;">
    <h1>PT. MERPATI MAINTENANCE FACILITY</h1>
    <h5>GENERAL LEDGER</h5>
    <h4><b>11/11/11 - 11/11/20</b></h4>
</div>  --}}
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

              @include('label::show')

              <h3 class="m-portlet__head-text">
                General Ledger
              </h3>
            </div>
          </div>
        </div>
        <div class="m-portlet m-portlet--mobile">
          <div class="m-portlet__body">
            <div class="form-group m-form__group row ">
              @foreach ($data as $items)
                @if (! isset($items['data'][0]->AccountCode))
                  @php
                    continue;
                  @endphp
                @endif
                <h5 class="col-sm-12 col-md-12 col-lg-12">
                  <table width="100%">
                    <tr>
                      <td width="10%"> Account Code</td>
                      <td width="1%">:</td>
                      <td width="89%"> {{$items['data'][0]->AccountCode}} - <span> {{$items['data'][0]->Name}}</span> </td>
                    </tr>
                    <tr>
                      <td width="10%">Period </td>
                      <td width="1%">:</td>
                      <td width="89%">{{$beginDate.' - '.$endingDate}}</td>
                    </tr>
                  </table><br>
                </h5>

                <div class="col-sm-12 col-md-12 col-lg-12" style="overflow-x: auto">
                  {{-- <div class="general_ledger_datatable" id="scrolling_both"></div> --}}
                  <table class="table table-striped table-bordered table-hover" id="table-general-ledger">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th>Transaction No.</th>
                        <th>Ref. No.</th>
                        <th>Description</th>
                        <th>Currency</th>
                        <th>Amount Total</th>
                        <th>Rate</th>
                        <th>Debit (IDR)</th>
                        <th>Credit (IDR)</th>
                        <th>Ending Balance (IDR)</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($items['data'] as $index => $item)
                      <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $carbon::parse($item->TransactionDate)->format('d/m/Y') }}</td>
                        <td>{!!$item->voucher_linked!!}</td>
                        <td>{{$item->RefNo}}</td>
                        <td>{{$item->description_formated}}</td>
                        <td>{{ strtoupper($item->currency->code) }}</td>
                        <td style="text-align: right">
                          {{ "{$controller->currency_format((($item->Debit != 0)? $item->Debit: $item->Credit) / $item->rate, 2)}" }}
                        </td>
                        <td>{!! $controller->fa_format('Rp', $controller->currency_format($item->rate, 2)) !!}</td>
                        <td>{!! $controller->fa_format('Rp', $controller->currency_format($item->Debit, 2)) !!}</td>
                        <td>{!! $controller->fa_format('Rp', $controller->currency_format($item->Credit, 2)) !!}</td>
                        <td>{!! $controller->fa_format('Rp', $controller->currency_format($item->endingBalance, 2)) !!}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="col-md-4 col-12 mb-5">
                  <table class="table" style="border: none">
                    @foreach ($items['total']['local'] as $total_local_index => $total_local_row)
                      <tr>
                        <td style="width: 1px; white-space: nowrap">{{ $total_local_index }}</td>
                        <td style="width: 1px">:</td>
                        <td style="width: 1px; background: #f4f5f8">Rp </td>
                        <td class="text-right" style="background: #f4f5f8">{{ $controller->currency_format($total_local_row) }}</td>
                      </tr>
                    @endforeach
                    @foreach ($items['total']['foreign'] as $total_foreign_index => $total_foreign_row)
                      <tr>
                        <td style="width: 1px; white-space: nowrap">{{ strtoupper($total_foreign_row['currency']->code) }}</td>
                        <td style="width: 1px">:</td>
                        <td style="width: 1px; background: #f4f5f8">{{ $total_foreign_row['currency']->symbol }}</td>
                        <td class="text-right" style="background: #f4f5f8">{{ $controller->currency_format($total_foreign_row['amount']) }}</td>
                      </tr>
                    @endforeach

                  </table>
                </div>
              @endforeach
            </div>
            <div class="form-group m-form__group row ">

              <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end">

                <div class="action-buttons">
                  {{-- <a href="{{route('general_ledger.print')}}?data={{Request::get('data')}}&date={{Request::get('date')}}"
                    class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-info btn-md">
                    <span> Finance ga btuh print outnya
                      <i class="la la-print"></i>
                      <span>Print</span>
                    </span>
                  </a> --}}
                  <a href="{{route('general_ledger.export')}}?data={{Request::get('data')}}&date={{Request::get('date')}}"
                    class="btn m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air btn-success btn-md">
                    <span>
                      <i class="far fa-file-excel"></i>
                      <span>Export to Excel</span>
                    </span>
                  </a>
                  @include('buttons::back')
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('footer-scripts')
<script src="{{ asset('assets/metronic/vendors/custom/datatables/datatables.bundle.js') }}"></script>
<script>
  $(document).ready(function() {
    let currentUrl = window.location.href;
    let _hash = currentUrl.split('#');
    if (_hash.length < 2) {
        window.location.href=currentUrl+"#faGL";
    } else {
        window.location.href=currentUrl;
    }

    $('#table-general-ledger').DataTable({
      dom: '<"top"f>rt<"bottom">pil',
      scrollX: true,
    });

    $(".dataTables_length select").addClass("form-control m-input");
    $(".dataTables_filter").addClass("pull-left");
    $(".paging_simple_numbers").addClass("pull-left");
    $(".dataTables_length").addClass("pull-right");
    $(".dataTables_info").addClass("pull-right");
    $(".dataTables_info").addClass("margin-info");
    $(".paging_simple_numbers").addClass("padding-datatable");
  });
</script>
<script src="{{ asset('vendor/courier/frontend/general-ledger/show.js')}}"></script>
@endpush
