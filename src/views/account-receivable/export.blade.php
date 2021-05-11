<table>
  <tr>
    <th style="background: #ffb822"><b>date transaction</b></th>
    <th style="background: #ffb822"><b>payment receive No</b></th>
    <th style="background: #ffb822"><b>customer name</b></th>
    <th style="background: #ffb822"><b>invoice no</b></th>
    <th style="background: #ffb822"><b>currency invoice</b></th>
    <th style="background: #ffb822"><b>exchange rate invoice</b></th>
    <th style="background: #ffb822"><b>currency AR</b></th>
    <th style="background: #ffb822"><b>exchange rate AR</b></th>
    <th style="background: #ffb822"><b>invoice total amount</b></th>
    <th style="background: #ffb822"><b>paid amount</b></th>
    <th style="background: #ffb822"><b>receive amount</b></th>
    <th style="background: #ffb822"><b>exchange rate gap</b></th>
    <th style="background: #ffb822"><b>account code </b></th>
    <th style="background: #ffb822"><b>debit</b></th>
    <th style="background: #ffb822"><b>credit</b></th>
    <th style="background: #ffb822"><b>description</b></th>
  </tr>
  @foreach ($invoice as $invoice_row)
    <tr>
      <th>{{ $carbon::parse($invoice_row->ar->transactiondate)->format('d-m-Y') }}</th>
      <th>{{ $invoice_row->ar->transactionnumber }}</th>
      <th>{{ $invoice_row->ar->customer->name }}</th>
      <th>{{ $invoice_row->transactionnumber }}</th>
      <th>{{ strtoupper($invoice_row->currencies->code) }}</th>
      <th>{{ $controller->currency_format($invoice_row->exchangerate, 2) }}</th>
      <th>{{ strtoupper($invoice_row->ar->currencies->code) }}</th>
      <th>{{ $controller->currency_format($invoice_row->ar->exchangerate, 2) }}</th>
      <th>{{ $controller->currency_format($invoice_row->grandtotalforeign, 2) }}</th>
      <th>{{ $controller->currency_format($invoice_row->report_paid_amount, 2) }}</th>
      <th>{{ $controller->currency_format($invoice_row->ara->sum('credit'), 2) }}</th>
      <th>{{ $controller->currency_format($invoice_row->ar->gap, 2) }}</th>
      <th>{{ $invoice_row->coas->name." ({$invoice_row->coas->code})" }}</th>
      <th>{{ $controller->currency_format($invoice_row->ara->sum('debit'), 2) }}</th>
      <th>{{ $controller->currency_format($invoice_row->ara->sum('credit'), 2) }}</th>
      <th>{{ $invoice_row->ar->description }}</th>
    </tr>
  @endforeach
</table>