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
      <th>Project Number</th>
      <th>Purchase Order Number</th>
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
            $total_foreign += (($item->Debit != 0)? $item->Debit: $item->Credit) / $item->rate;
            $total_debit += $item->Debit;
            $total_credit += $item->Credit;
            $total_ending_balance += $item->endingBalance;
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
            <td>{{$item->project_number}}</td>
            <td>{{$item->po_number}}</td>
        </tr>
        @endforeach
    @endforeach
      <tr>
        <td>{{ $number }}</td>
        <td></td>
        <td>Total</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>{{ $total_foreign }}</td>
        <td></td>
        <td>{{ $total_debit }}</td>
        <td>{{ $total_credit }}</td>
        <td>{{ $total_ending_balance }}</td>
        <td></td>
        <td></td>
      </tr>
  </tbody>
</table>
