<table>
  <tr>
    <th><b>Date Invoice</b></th>
    <th><b>Invoice No</b></th>
    <th><b>Ref QN No</b></th>
    <th><b>Subject</b></th>
    <th><b>Currency</b></th>
    <th><b>Exchange rate</b></th>
    <th><b>Sub Total</b></th>
    <th><b>Disc Total</b></th>
    <th><b>Total Before Tax</b></th>
    <th><b>Vat Type</b></th>
    <th><b>VAT</b></th>
    <th><b>Other Cost Total</b></th>
    <th><b>Grand Total</b></th>
    <th><b>Grand Total IDR</b></th>
    <th><b>Status</b></th>
    <th><b>Created By</b></th>
    <th><b>Approved By</b></th>
  </tr>
  @foreach ($invoice as $invoice_row)
    <tr>
      <td>{{ $invoice_row->transactiondate->format('d-m-Y') }}</td>
      <td>{{ $invoice_row->transactionnumber }}</td>
      <td>{{ $invoice_row->quotations->number ?? '-' }}</td>
      <td>{{ $invoice_row->quotations->title ?? '-' }}</td>
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
