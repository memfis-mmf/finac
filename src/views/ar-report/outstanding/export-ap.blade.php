@php
  use Illuminate\Support\Carbon;
@endphp
@foreach ($vendor as $vendor_row)
<table cellpadding="3" class="table-head">
  <tr>
    <td><b>Supplier Name</b></td>
    <td><b>:</b></td>
    <td><b>{{ $vendor_row->name }}</b></td>
  </tr>
</table>
<table cellpadding="4" class="table-body">
  <tr>
    <td><b>Invoice No.</b></td>
    <td><b>Date</b></td>
    <td><b>Due Date</b></td>
    <td><b>Ref No.</b></td>
    <td><b>Currency</b></td>
    <td colspan="2"><b>Rate</b></td>
    <td colspan="2"><b>Total Invoice</b></td>
    {{-- <td colspan="2"><b>VAT</b></td> --}}
    <td colspan="2"><b>Outstanding Balance</b></td>
  </tr>
  @foreach ($vendor_row->supplier_invoice as $supplier_invoice_row)
  <tr>
    <td style="padding-left:8px;">{{ $supplier_invoice_row->transaction_number }}</td>
    <td>{{ Carbon::parse($supplier_invoice_row->transaction_date)->format('d F Y') }}</td>
    <td>{{ $supplier_invoice_row->due_date }}</td>
    <td>{{ $supplier_invoice_row->quotations->number ?? '-' }}</td>
    <td>{{ $supplier_invoice_row->currencies->code }}</td>
    <td>Rp </td>
    <td>{{ $supplier_invoice_row->exchange_rate }}</td>
    <td>{{ $supplier_invoice_row->currencies->symbol }}</td>
    <td>{{ $supplier_invoice_row->grandtotal_foreign }}</td>
    {{-- <td>{{ $supplier_invoice_row->currencies->symbol }}</td>
    <td>{{ $supplier_invoice_row->ppnvalue }}</td> --}}
    <td>{{ $supplier_invoice_row->currencies->symbol }}</td>
    <td>{{ $supplier_invoice_row->ending_balance['amount'] }}</td>
  </tr>
  @endforeach
  @foreach ($vendor_row->sum_total as $sum_total_index => $sum_total_row)
  <tr style="border-top:2px solid black;">
    <td colspan="5"></td>
    <td colspan="2"><b>Total {{ strtoupper($sum_total_index) }}</b></td>
    <td class="table-footer"><b>{{ $sum_total_row['symbol'] }}</b></td>
    <td class="table-footer">
      {{ $sum_total_row['grandtotal_foreign'] }}
    </td>
    <td class="table-footer"><b>{{ $sum_total_row['symbol'] }}</b></td>
    {{-- <td class="table-footer">
      <b>{{ $sum_total_row['ppnvalue'] }}</b></td>
    <td class="table-footer"><b>{{ $sum_total_row['symbol'] }}</b></td> --}}
    <td class="table-footer">
      {{ $sum_total_row['ending_value'] }}
    </td>
  </tr>
  @endforeach
</table>
@endforeach