@php
  use Illuminate\Support\Carbon;
@endphp
<table>
  <tr>
    <td valign="top">MMF Department</td>
    <td valign="top">:</td>
    <td valign="top">{{$department->name}}</td>
  </tr>
  <tr>
    <td>MMF Location</td>
    <td>:</td>
    <td style="text-transform: capitalize">{{$location}}</td>
  </tr>
  <tr>
    <td>Currency</td>
    <td>:</td>
    <td>{{$currency}}</td>
  </tr>
</table>

@foreach ($data as $dataRow)
  @php
    $sum_subtotal = 0;
    $sum_discount = 0;
    $sum_vat = 0;
    $sum_receivable_total = 0;
    $sum_paid_amount = 0;
    $sum_pph = 0;
    $sum_ending_balance = 0;
    $sum_ending_balance_idr = 0;

    $invoice_currency = $dataRow[0]->currencies->code;
  @endphp
  <table cellpadding="3" class="table-head">
      <tr>
          <td valign="top"><b>Customer Name</b></td>
          <td valign="top"><b>:</b></td>
          <td valign="top"><b>{{$dataRow[0]->customer->name}}</b></td>
      </tr>
  </table>
  <table  cellpadding="4" class="table-body">  
      <thead style="border-bottom:2px solid black;">     
          <tr>
              <td align="left" valign="top" style="padding-left:8px;"><b>Transaction No.</b></td>
              <td align="center" valign="top"><b>Date</b></td>
              <td align="center" valign="top"><b>Ref No.</b></td>
              @if ($invoice_currency != 'idr')
                <td align="center" valign="top"><b>Exchange Rate</b></td>
              @endif
              <td align="center" valign="top"><b>Description</b></td>
              <td align="center" valign="top"><b>Subtotal</b></td>
              <td align="center" valign="top"><b>Discount</b></td>
              <td align="center" valign="top"><b>VAT</b></td>
              <td align="center" valign="top"><b>Receivables Total</b></td>
              <td align="center" valign="top"><b>Paid Amount</b></td>
              <td align="center" valign="top"><b>PPH</b></td>
              <td align="center" valign="top"><b>Ending Balance</b></td>
              @if ($invoice_currency != 'idr')
                <td align="center" valign="top"><b>Ending Balance in IDR</b></td>
              @endif
          </tr>
      </thead>
      <tbody>
        @foreach ($dataRow as $item)
          <tr style="font-size:8.4pt;" class="nowrap">
            <td align="left" valign="top" style="padding-left:8px;">{{$item->transactionnumber}}</td>
            <td align="center" valign="top">{{Carbon::parse($item->transactiondate)->format('d-m-Y')}}</td>
            <td align="left" valign="top">{{$item->quotations->number}}</td>
            @if ($invoice_currency != 'idr')
              <td align="left" valign="top">Rp {{number_format($item->ara[0]->ar->exchangerate)}}</td>
            @endif
            <td align="left" valign="top">{{$item->description}}</td>
            <td align="right" valign="top">{{$item->currencies->symbol.' '.number_format($item->report_subtotal)}}</td>
            <td align="right" valign="top">{{$item->currencies->symbol.' '.number_format($item->report_discount)}}</td>
            <td align="right" valign="top">{{$item->currencies->symbol.' '.number_format($item->ppnvalue)}}</td>
            <td align="right" valign="top">{{$item->currencies->symbol}} 0</td>
            <td align="right" valign="top">{{$item->currencies->symbol.' '.number_format($item->report_paid_amount)}}</td>
            <td align="right" valign="top">{{$item->currencies->symbol}} 0</td>
            <td align="right" valign="top">{{$item->currencies->symbol.' '.number_format($item->report_ending_balance)}}</td>
            @if ($invoice_currency != 'idr')
              <td align="right" valign="top">Rp {{number_format($item->report_ending_balance * $item->ara[0]->ar->exchangerate)}}</td>
            @endif
          </tr>
          @php
            $sum_subtotal += $item->report_subtotal;
            $sum_discount += $item->report_discount;
            $sum_vat += $item->ppnvalue;
            $sum_receivable_total += 0;
            $sum_paid_amount += $item->report_paid_amount;
            $sum_pph += 0;
            $sum_ending_balance += $item->report_ending_balance;
            $sum_ending_balance_idr += ($sum_ending_balance * $item->ara[0]->ar->exchangerate)
          @endphp
        @endforeach
        <tr style="border-top:2px solid black; font-size:9pt;" >
            <td colspan="{{($invoice_currency != 'idr')? 4: 3}}"></td>
            <td align="left" valign="top" colspan="1"><b>Total {{strtoupper($currency)}}</b></td>
            <td align="right" valign="top" class="table-footer"><b>{{$item->currencies->symbol.' '.number_format($sum_subtotal)}}</b></td>
            <td align="right" valign="top" class="table-footer"><b>{{$item->currencies->symbol.' '.number_format($sum_discount)}}</b></td>
            <td align="right" valign="top" class="table-footer"><b>{{$item->currencies->symbol.' '.number_format($sum_vat)}}</b></td>
            <td align="right" valign="top" class="table-footer"><b>{{$item->currencies->symbol.' '.number_format($sum_receivable_total)}}</b></td>
            <td align="right" valign="top" class="table-footer"><b>{{$item->currencies->symbol.' '.number_format($sum_paid_amount)}}</b></td>
            <td align="right" valign="top" class="table-footer"><b>{{$item->currencies->symbol.' '.number_format($sum_pph)}}</b></td>
            <td align="right" valign="top" class="table-footer"><b>{{$item->currencies->symbol.' '.number_format($sum_ending_balance)}}</b></td>
            @if ($invoice_currency != 'idr')
              <td align="right" valign="top">Rp {{number_format($sum_ending_balance_idr)}}</td>
            @endif
        </tr>
        
      </tbody>
  </table>
@endforeach