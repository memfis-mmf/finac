@foreach ($data as $items)
<table>
  <tr>
    <td> Account Code</td>
    <td>:</td>
    <td> {{$items['data'][0]->AccountCode}} - <span> {{$items['data'][0]->Name}}</span> </td>
  </tr>
  <tr>
    <td>Period </td>
    <td>:</td>
    <td>{{$beginDate.' - '.$endingDate}}</td>
  </tr>
</table><br>

<table class="table table-striped table-bordered table-hover">
  <thead>
    <tr>
      <th>No</th>
      <th>Date</th>
      <th>Transaction No.</th>
      <th>Ref. No.</th>
      <th>Description</th>
      <th>Currency</th>
      <th>Foreign Total</th>
      <th>Rate</th>
      <th>Debit</th>
      <th>Credit</th>
      <th>Ending Balance</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($items['data'] as $index => $item)
    <tr>
      <td>{{ $index + 1 }}</td>
      <td>{{ $carbon::parse($item->TransactionDate)->format('d/m/Y') }}</td>
      <td>{!!$item->voucher_linked!!}</td>
      <td>{{$item->RefNo}}</td>
      <td>{{$item->Description}}</td>
      <td>{{ strtoupper($item->currency->code) }}</td>
      <td>
        {{ "{$item->currency->symbol} {$controller->currency_format((($item->Debit != 0)? $item->Debit: $item->Credit) / $item->rate, 2)}" }}
      </td>
      <td>Rp {{ $controller->currency_format($item->rate, 2) }}</td>
      <td>Rp {{number_format($item->Debit, 2, ',', '.')}}</td>
      <td>Rp {{number_format($item->Credit, 2, ',', '.')}}</td>
      <td>Rp {{number_format($item->endingBalance, 2, ',', '.')}}</td>
    </tr>
    @endforeach
    @foreach ($items['total']['foreign'] as $total_foreign_index => $total_foreign_row)
      <tr>
        <td colspan="6">Total {{ strtoupper($total_foreign_row['currency']->code) }}</td>
        <td colspan="2">{{ $total_foreign_row['currency']->symbol }} {{ $controller->currency_format($total_foreign_row['amount']) }}</td>
        <td>Rp {{ $controller->currency_format($items['total']['local']['Total Debit']) }}</td>
        <td>Rp {{ $controller->currency_format($items['total']['local']['Total Credit']) }} </td>
        <td>Rp {{ $controller->currency_format($items['total']['local']['Total Ending Balance']) }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

{{-- <table class="table" style="border: none">
  @foreach ($items['total']['local'] as $total_local_index => $total_local_row)
    <tr>
      <td style="width: 1px; white-space: nowrap">Total {{ $total_local_index }}</td>
      <td style="width: 1px">:</td>
      <td style="width: 1px;">Rp </td>
      <td style="text-align: right">{{ $controller->currency_format($total_local_row) }}</td>
    </tr>   
  @endforeach
  @foreach ($items['total']['foreign'] as $total_foreign_index => $total_foreign_row)
    <tr>
      <td style="width: 1px; white-space: nowrap">Total {{ strtoupper($total_foreign_row['currency']->code) }}</td>
      <td style="width: 1px">:</td>
      <td style="width: 1px;">{{ $total_foreign_row['currency']->symbol }}</td>
      <td style="text-align: right">{{ $controller->currency_format($total_foreign_row['amount']) }}</td>
    </tr>   
  @endforeach

</table> --}}
<table></table>
<table></table>

@endforeach