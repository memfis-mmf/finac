<table>
  <tr>
    <td>
      <h1>AGING RECEIVABLE</h1>
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
        <td  valign="top">{{ $department }}</td>
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

<table>  
    <thead style="border-bottom:2px solid black;">     
        <tr>
            <td align="left" valign="top" style="padding-left:8px;"><b>Customer Name</b></td>
            <td align="center" valign="top"><b>Account</b></td>
            <td align="center" valign="top" colspan="2" style="color:red;"><i><b>1-6 Months</b></i></td>
            <td align="center" valign="top"  colspan="2" style="color:red;"><i><b>7-12 Months</b></i></td>
            <td align="center" valign="top"  colspan="2" style="color:red;"><i><b> 1 Year</b></i></td>
            <td align="center" valign="top"  colspan="2" style="color:red;"><i><b> 2 Year</b></i></td>
            <td align="center" valign="top"  colspan="2"><i><b>Total Balance</b></i></td>
        </tr>
    </thead>
    <tbody>
      @foreach ($data as $customer_row)
        <tr>
          <td class="nowrap" align="left" valign="top" style="padding-left:8px;">{{ $customer_row->name }}</td>
          <td class="nowrap" align="center" valign="top">{{ $customer_row->coa_formated }}</td>
          <td class="nowrap" align="right" valign="top" >{{ $currency->symbol }} </td>
          <td class="nowrap" align="right" valign="top">{{ $class::currency_format($customer_row->invoice1_6) }}</td>
          <td class="nowrap" align="right" valign="top" >{{ $currency->symbol }} </td>
          <td class="nowrap" align="right" valign="top">{{ $class::currency_format($customer_row->invoice7_12) }}</td>
          <td class="nowrap" align="right" valign="top" > {{ $currency->symbol }} </td>
          <td class="nowrap" align="right" valign="top">{{ $class::currency_format($customer_row->invoice_1) }}</td>
          <td class="nowrap" align="right" valign="top" > {{ $currency->symbol }} </td>
          <td class="nowrap" align="right" valign="top">{{ $class::currency_format($customer_row->invoice_2) }}</td>
          <td class="nowrap" align="right" valign="top" >{{ $currency->symbol }} </td>
          <td class="nowrap" align="right" valign="top">{{ $class::currency_format($customer_row->balance) }}</td>
        </tr>
        @php
            $total1_6 += $customer_row->invoice1_6;
            $total7_12 += $customer_row->invoice7_12;
            $total_1 += $customer_row->invoice_1;
            $total_2 += $customer_row->invoice_2;
            $total_balance += $customer_row->balance;
        @endphp
      @endforeach
      <tr>
        <td colspan="11" style="height: 30px"></td>
      </tr>
      <tr>
          <td align="center" valign="top" colspan="2"><b>Total</b></td>
          <td align="right" valign="top"><b>{{ $currency->symbol }} </b></td>
          <td align="right" valign="right"><b>{{ $class::currency_format($total1_6) }}</b></td>
          <td align="right" valign="top"><b>{{ $currency->symbol }} </b></td>
          <td align="right" valign="right"><b>{{ $class::currency_format($total7_12) }}</b></td>
          <td align="right" valign="top"><b>{{ $currency->symbol }} </b></td>
          <td align="right" valign="right"><b>{{ $class::currency_format($total_1) }}</b></td>
          <td align="right" valign="top"><b> {{ $currency->symbol }} </b></td>
          <td align="right" valign="right"><b>{{ $class::currency_format($total_2) }}</b></td>
          <td align="right" valign="top"><b>{{ $currency->symbol }} </b></td>
          <td align="right" valign="right"><b>{{ $class::currency_format($total_balance) }}</b></td>
      </tr>
    </tbody>
</table>