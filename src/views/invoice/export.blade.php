<table>
  <tr>
    <th style="background: #ffb822"><b>date invoice</b></th>
    <th style="background: #ffb822"><b>invoice no</b></th>
    <th style="background: #ffb822"><b>ref QN no</b></th>
    <th style="background: #ffb822"><b>Subject</b></th>
    <th style="background: #ffb822"><b>currency</b></th>
    <th style="background: #ffb822"><b>exchange rate</b></th>
    <th style="background: #ffb822"><b>sub total</b></th>
    <th style="background: #ffb822"><b>disc total</b></th>
    <th style="background: #ffb822"><b>total before tax</b></th>
    <th style="background: #ffb822"><b>vat type</b></th>
    <th style="background: #ffb822"><b>VAT 10%</b></th>
    <th style="background: #ffb822"><b>Other Cost Total</b></th>
    <th style="background: #ffb822"><b>Grand Total</b></th>
    <th style="background: #ffb822"><b>Grand Total IDR</b></th>
    <th style="background: #ffb822"><b>status</b></th>
    <th style="background: #ffb822"><b>Created By</b></th>
    <th style="background: #ffb822"><b>Approved By</b></th>
  </tr>
  @foreach ($invoice as $invoice_row)
    <tr>
      <td>{{ $invoice_row->transactiondate->format('d-m-Y') }}</td>
      <td>{{ $invoice_row->transactionnumber }}</td>
      <td>{{ $invoice_row->quotations->number ?? '-' }}</td>
      <td>{{ $invoice_row->quotations->title }}</td>
      <td>{{ strtoupper($invoice_row->currencies->code) }}</td>
      <td>{{ $controller->currency_format($invoice_row->exchangerate, 2) }}</td>
      <td>{{ $controller->currency_format($invoice_row->subtotal, 2) }}</td>
      <td>{{ $controller->currency_format($invoice_row->discountvalue, 2) }}</td>
      <td>{{ $controller->currency_format($invoice_row->total, 2) }}</td>
      <td>{{ $invoice_row->quotations->taxes[0]->TaxPaymentMethod->code ?? '-' }}</td>
      <td>{{ $controller->currency_format($invoice_row->ppnvalue, 2) }}</td>
      <td>{{ $controller->currency_format($invoice_row->other_price, 2) }}</td>
      <td>{{ $controller->currency_format($invoice_row->grandtotalforeign, 2) }}</td>
      <td>{{ $controller->currency_format($invoice_row->grandtotal, 2) }}</td>
      <td>{{ $invoice_row->status }}</td>
      <td>{{ $invoice_row->created_by }}</td>
      <td>{{ $invoice_row->approved_by }}</td>
    </tr>
  @endforeach
</table>   
