@php
  use Illuminate\Support\Carbon;
@endphp
<table>
  <tr>
    <td width="12%" valign="top">MMF Department</td>
    <td width="1%" valign="top">:</td>
    <td width="77%" valign="top">{{ $department ?? '-' }}</td>
  </tr>
  <tr>
    <td>MMF Location</td>
    <td>:</td>
    <td style="text-transform: capitalize">{{ $request->location ?? '-' }}</td>
  </tr>
  <tr>
    <td>Currency</td>
    <td>:</td>
    <td>{{ $currency ?? 'All' }}</td>
  </tr>
</table>

{{-- content --}}
@foreach ($vendor as $vendor_row)
@php
  $subtotal_total = 0;
  $discount_total = 0;
  $vat_total = 0;
  $invoice_total = 0;
  $paid_amount_total = 0;
  $ending_balance_total = 0;
  $ending_balance_idr_total = 0;
@endphp
<table>
  <tr>
    <td width="12%" valign="top"><b>Supplier Name</b></td>
    <td width="1%" valign="top"><b>:</b></td>
    <td width="77%" valign="top"><b>{{ $vendor_row->name }}</b></td>
  </tr>
</table>

<table>
  <thead style="border-bottom:2px solid black;">
    <tr>
      <td width="" align="left" valign="top" style="padding-left:8px;"><b>Transaction No.</b></td>
      <td width="" align="center" valign="top"><b>Date</b></td>
      <td width="" align="center" valign="top"><b>Ref No.</b></td>
      <td width="" align="center" valign="top"><b>Exchange Rate</b></td>
      {{-- <td width="" align="center" valign="top"><b>Description</b></td> --}}
      {{-- <td width="" align="center" valign="top"><b>Subtotal</b></td> --}}
      <td width="" align="center" valign="top"><b>Discount</b></td>
      <td width="" align="center" valign="top"><b>VAT</b></td>
      <td width="" align="center" valign="top"><b>Payables Total</b></td>
      <td width="" align="center" valign="top"><b>Paid Amount</b></td>
      {{-- <td width="" align="center" valign="top"><b>PPH</b></td> --}}
      <td width="" align="center" valign="top"><b>Ending Balance</b></td>
      <td width="" align="center" valign="top"><b>Ending Balance in IDR</b></td>
    </tr>
  </thead>
  <tbody>
    @foreach ($vendor_row->supplier_invoice as $invoice_row)
    <tr style="font-size:8.4pt;" class="nowrap">
      <td width="" align="left" valign="top" style="padding-left:8px;">{{ $invoice_row->transaction_number }}</td>
      <td width="" align="center" valign="top">{{ Carbon::parse($invoice_row->transaction_date)->format('d F Y') }}</td>
      <td width="" align="left" valign="top">{{ $invoice_row->quotations->number ?? '-' }}</td>
      <td width="" align="left" valign="top">Rp {{ number_format($invoice_row->exchange_rate, 2, ',', '.') }}</td>
      {{-- <td width="" align="left" valign="top">{!! $invoice_row->description !!}</td> --}}
      {{-- <td width="" align="right" valign="top">{{ $invoice_row->currencies->symbol.' '.number_format($invoice_row->subtotal, 2, ',', '.') }}</td> --}}
      <td width="" align="right" valign="top">{{ $invoice_row->currencies->symbol.' '.number_format($invoice_row->discount_value, 2, ',', '.') }}</td>
      <td width="" align="right" valign="top">{{ $invoice_row->currencies->symbol.' '.number_format($invoice_row->ppn_value, 2, ',', '.') }}</td>
      <td width="" align="right" valign="top">{{ $invoice_row->currencies->symbol.' '.number_format($invoice_row->grandtotal_foreign, 2, ',', '.')  }}</td>
      <td width="" align="right" valign="top">{{ $invoice_row->currencies->symbol.' '.number_format($invoice_row->ap_amount['debit'], 2, ',', '.') }}</td>
      {{-- <td width="" align="right" valign="top">{{ number_format(0, 2, ',', '.') }}</td> --}}
      <td width="" align="right" valign="top">{{ $invoice_row->currencies->symbol.' '.number_format($invoice_row->ending_balance['amount'], 2, ',', '.') }}</td>
      <td width="" align="right" valign="top">Rp {{ number_format($invoice_row->ending_balance['amount_idr'], 2, ',', '.')  }}</td>
    </tr>
    @php
      // $subtotal_total += $invoice_row->subtotal;
      $discount_total += $invoice_row->discount_value;
      $vat_total += $invoice_row->ppn_value;
      $invoice_total += $invoice_row->grandtotal_foreign;
      $paid_amount_total += $invoice_row->ap_amount['debit'];
      $ending_balance_total += $invoice_row->ending_balance['amount'];
      $ending_balance_idr_total += $invoice_row->ending_balance['amount_idr'];
    @endphp
    @endforeach
    @foreach ($vendor_row->total as $total_row)
    <tr class="nowrap" style="border-top:2px solid black; font-size:9pt;">
      <td colspan="3"></td>
      <td align="left" valign="top"><b>Total {{ strtoupper($total_row['currency']->code) }}</b></td>
      <td width="" align="right" valign="top" class="table-footer">
        <b>
          {{ $total_row['currency']->symbol.' '.$controller::currency_format($total_row['discount_total'], 2) }}
        </b>
      </td>
      <td width="" align="right" valign="top" class="table-footer">
        <b>
          {{ $total_row['currency']->symbol.' '.$controller::currency_format($total_row['vat_total'], 2) }}
        </b>
      </td>
      <td width="" align="right" valign="top" class="table-footer">
        <b>
          {{ $total_row['currency']->symbol.' '.$controller::currency_format($total_row['invoice_total'], 2) }}
        </b>
      </td>
      <td width="" align="right" valign="top" class="table-footer">
        <b>
          {{ $total_row['currency']->symbol.' '.$controller::currency_format($total_row['paid_amount_total'], 2) }}
        </b>
      </td>
      <td width="" align="right" valign="top" class="table-footer">
        <b>
          {{ $total_row['currency']->symbol.' '.$controller::currency_format($total_row['ending_balance_total'], 2) }}
        </b>
      </td>
      <td width="" align="right" valign="top" class="table-footer">
        <b>
          Rp {{ $controller::currency_format($total_row['ending_balance_total_idr'], 2) }}
        </b>
      </td>
    </tr>
    @endforeach

  </tbody>
</table>
@endforeach
{{-- end content --}}