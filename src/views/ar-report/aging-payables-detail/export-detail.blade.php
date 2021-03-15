<table>
  <tr>
    <td>
      <h1>AGING RECEIVABLE DETAIL</h1>
    </td>
  </tr>
  <tr>
    <td>
      <h4>Date : {{ $date }}</h4>
    </td>
  </tr>
</table>
<table>
  <tr>
    <td class="nowrap" valign="top" width="1px">MMF Department</td>
    <td class="nowrap" valign="top" width="1px">:</td>
    <td valign="top">{{ $department }}</td>
  </tr>
  <tr>
    <td>MMF Location</td>
    <td>:</td>
    <td>{{ $location }}</td>
  </tr>
  <tr>
    <td>Currency</td>
    <td>:</td>
    <td>{{ strtoupper($currency->code) }}</td>
  </tr>
</table>

@foreach ($data as $vendor_row)
@php
  $total_amount_current = 0;
  $total_amount1_6 = 0;
  $total_amount7_12 = 0;
  $total_amount_1 = 0;
  $total_amount_2 = 0;
  $total_balance = 0;
@endphp
<table>
  <tr>
    <td>
      <h4>Customer Name : {{ $vendor_row->name }}</h4>
    </td>
  </tr>
</table>
  
<table>
  <thead style="border-bottom:2px solid black;">
    <tr>
      <td align="left" valign="top" style="padding-left:8px;"><b>Invoice Number</b></td>
      <td align="center" valign="top"><b>Due Date</b></td>
      <td align="center" valign="top" colspan="2" style="color:red;"><i><b>Current</b></i></td>
      <td align="center" valign="top" colspan="2" style="color:red;"><i><b>1-6 Months</b></i></td>
      <td align="center" valign="top" colspan="2" style="color:red;"><i><b>7-12 Months</b></i></td>
      <td align="center" valign="top" colspan="2" style="color:red;"><i><b> 1 Year</b></i></td>
      <td align="center" valign="top" colspan="2" style="color:red;"><i><b> 2 Year</b></i></td>
      <td align="center" valign="top" colspan="2"><i><b>Total Balance</b></i></td>
    </tr>
  </thead>
  <tbody>
    @foreach ($vendor_row->supplier_invoice as $invoice_row)
      <tr>
        <td class="nowrap" align="left" valign="top" style="padding-left:8px;">{{ $invoice_row->number }}</td>
        <td class="nowrap" align="right" valign="top">{{ $invoice_row->due_date }}</td>
        <td class="nowrap" align="right" valign="top">{{ $currency->symbol }}</td>
        <td class="nowrap" align="right" valign="top">{{ $class::currency_format($invoice_row->amount_current) }}</td>
        <td class="nowrap" align="right" valign="top">{{ $currency->symbol }}</td>
        <td class="nowrap" align="right" valign="top">{{ $class::currency_format($invoice_row->amount1_6) }}</td>
        <td class="nowrap" align="right" valign="top">{{ $currency->symbol }}</td>
        <td class="nowrap" align="right" valign="top">{{ $class::currency_format($invoice_row->amount7_12) }}</td>
        <td class="nowrap" align="right" valign="top">{{ $currency->symbol }}</td>
        <td class="nowrap" align="right" valign="top">{{ $class::currency_format($invoice_row->amount_1) }}</td>
        <td class="nowrap" align="right" valign="top">{{ $currency->symbol }}</td>
        <td class="nowrap" align="right" valign="top">{{ $class::currency_format($invoice_row->amount_2) }}</td>
        <td class="nowrap" align="right" valign="top">{{ $currency->symbol }}</td>
        <td class="nowrap" align="right" valign="top">{{ $class::currency_format($invoice_row->balance) }}</td>
      </tr>

      @php
        $total_amount_current += $invoice_row->amount_current;
        $total_amount1_6 += $invoice_row->amount1_6;
        $total_amount7_12 += $invoice_row->amount7_12;
        $total_amount_1 += $invoice_row->amount_1;
        $total_amount_2 += $invoice_row->amount_2;
        $total_balance += $invoice_row->balance;
      @endphp
    @endforeach
    <tr>
      <td colspan="11" style="height: 30px"></td>
    </tr>
    <tr>
        <td align="center" valign="top" colspan="2"><b>Total</b></td>
        <td align="right" valign="top"><b>{{ $currency->symbol }}</b></td>
        <td align="right" valign="right"><b>{{ $class::currency_format($total_amount_current) }}</b></td>
        <td align="right" valign="top"><b>{{ $currency->symbol }}</b></td>
        <td align="right" valign="right"><b>{{ $class::currency_format($total_amount1_6) }}</b></td>
        <td align="right" valign="top"><b>{{ $currency->symbol }}</b></td>
        <td align="right" valign="right"><b>{{ $class::currency_format($total_amount7_12) }}</b></td>
        <td align="right" valign="top"><b>{{ $currency->symbol }}</b></td>
        <td align="right" valign="right"><b>{{ $class::currency_format($total_amount_1) }}</b></td>
        <td align="right" valign="top"><b>{{ $currency->symbol }}</b></td>
        <td align="right" valign="right"><b>{{ $class::currency_format($total_amount_2) }}</b></td>
        <td align="right" valign="top"><b>{{ $currency->symbol }}</b></td>
        <td align="right" valign="right"><b>{{ $class::currency_format($total_balance) }}</b></td>
    </tr>
  </tbody>
</table>
@endforeach