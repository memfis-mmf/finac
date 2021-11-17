<table>
    {{-- <tr>
      <td> Account Code</td>
      <td>:</td>
      <td> {{$items['data'][0]->AccountCode}} - <span> {{$items['data'][0]->Name}}</span> </td>
    </tr> --}}
    <tr>
      <td>Period </td>
      <td>:</td>
      <td>{{$beginDate.' - '.$endingDate}}</td>
    </tr>
</table>

<table class="table table-striped table-bordered table-hover">
  <thead>
    <tr>
      <th>No</th>
      <td>Account Code</td>
      <td>Account Name</td>
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
    @php
        $number = 0
    @endphp
    @foreach ($data as $items)
        @if (! isset($items['data'][0]->AccountCode))
        @php
            continue;
        @endphp
        @endif
        @foreach ($items['data'] as $index => $item)
        @php
            $number++;
        @endphp
        <tr>
            <td>{{ $number }}</td>
            <td>{{$items['data'][0]->AccountCode}}</td>
            <td>{{$items['data'][0]->Name}}</td>
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
        {{-- @foreach ($items['total']['foreign'] as $total_foreign_index => $total_foreign_row)
        <tr>
            <td colspan="6">Total {{ strtoupper($total_foreign_row['currency']->code) }}</td>
            <td colspan="2">{{ $total_foreign_row['currency']->symbol }} {{ $controller->currency_format($total_foreign_row['amount']) }}</td>
            <td>Rp {{ $controller->currency_format($items['total']['local']['Total Debit']) }}</td>
            <td>Rp {{ $controller->currency_format($items['total']['local']['Total Credit']) }} </td>
            <td>Rp {{ $controller->currency_format($items['total']['local']['Total Ending Balance']) }}</td>
        </tr>
        @endforeach --}}
    @endforeach
  </tbody>
</table>
