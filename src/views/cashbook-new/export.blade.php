@foreach ($cashbook as $cashbook_row)
<table>
  <tr>
    <th style="background: #ffb822"><b>Date Transaction</b></th>
    <th style="background: #ffb822"><b>Cashbook transaction no</b></th>
    <th style="background: #ffb822"><b>Payment/receive to</b></th>
    <th style="background: #ffb822"><b>ref no</b></th>
    <th style="background: #ffb822"><b>rate</b></th>
    <th style="background: #ffb822"><b>currency</b></th>
    <th style="background: #ffb822"><b>currency (multi curr)</b></th>
    <th style="background: #ffb822"><b>account code</b></th>
    <th style="background: #ffb822"><b>debit</b></th>
    <th style="background: #ffb822"><b>credit</b></th>
    <th style="background: #ffb822"><b>amount</b></th>
    <th style="background: #ffb822"><b>remark</b></th>
    <th style="background: #ffb822"><b>status</b></th>
    <th style="background: #ffb822"><b>created by</b></th>
    <th style="background: #ffb822"><b>approved by</b></th>
  </tr>
  @foreach ($cashbook_row->cashbook_a as $cashbook_a_row)
    <tr>
      <th>{{ $cashbook_row->transactiondate->format('d/m/Y') }}</th>
      <th>{{ $cashbook_row->transactionnumber }}</th>
      <th>{{ $cashbook_row->personal }}</th>
      <th>{{ $cashbook_row->refno }}</th>
      <th>{{ $controller->currency_format($cashbook_row->exchangerate, 2) }}</th>
      <th>{{ strtoupper($cashbook_row->currencies->code) }}</th>
      <th>{{ strtoupper($cashbook_row->second_currencies->code ?? '-') }}</th>
      <th>{{ $cashbook_a_row->coa->name." ({$cashbook_a_row->coa->code})" }}</th>
      <th>{{ $controller->currency_format($cashbook_a_row->debit, 2) }}</th>
      <th>{{ $controller->currency_format($cashbook_a_row->credit, 2) }}</th>
      <th>{{ $controller->currency_format($cashbook_a_row->totaltransaction, 2) }}</th>
      <th>{{ $cashbook_a_row->description }}</th>
      <th>{{ $cashbook_row->status }}</th>
      <th>{{ $cashbook_row->created_by }}</th>
      <th>{{ $cashbook_row->approved_by }}</th>
    </tr>   
  @endforeach
</table>   
@endforeach
