<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
      @page {
        margin: 0cm 0cm;
      }

      html,
      body {
        padding: 0;
        margin: 0;
        font-size: 12px;
      }

      body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin-top: 6cm;
        margin-bottom: 2cm;
      }

      header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 3cm;
      }

      footer {
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        height: 1.4cm;
      }

      ul li {
        display: inline-block;
      }

      table {
        border-collapse: collapse;
      }

      #head {
        top: 9px;
        left: 220px;
        position: absolute;
        text-align: center;
      }

      #body #header-content tr td {
        border-bottom: 2px solid black;
      }

      .container {
        width: 100%;
        margin: 0 36px;
      }

      .barcode {
        margin-left: 70px;
        margin-top: 12px;
      }

      #content table .amount {
        border-top: 2px solid black;
      }

      .page_break {
        page-break-before: always;
      }

      footer .page-number:after {
        content: counter(page);
      }
    </style>
</head>
<body>
    <header>
        <img src="./vendor/courier/img/form/printoutfa/HeaderFA-A4-Potrait.png" alt=""width="100%">
        <div id="head">
            <table width="95%">
                <tr>
                    <td width="15%" ></td>
                    <td width="50%" valign="middle" style="font-size:12px;line-height:20px;">
                        Jl. Indonesia Raya 116
                        <br>
                        Phone : 031-5730289 &nbsp;&nbsp;&nbsp; Fax : 031-5203618
                        <br>
                        Email : marketing@company.co.id
                        <br>
                        Website : www.company.co.id
                    </td>
                    <td width="45%" valign="top" align="center">
                        <h1 style="font-size:22px;">AGING PAYABLE<br> 
                        <span style="font-size:15px;font-weight: none;">Date : {{ $date }}</span></h1>
                    </td>
                </tr>
            </table>
        </div>
        <div id="body">
            <div class="container" style="margin-top:12px;">
                <table width="100%" cellpadding="3">
                    <tr>
                        <td width="12%" valign="top">Department</td>
                        <td width="1%" valign="top">:</td>
                        <td width="77%" valign="top">{{ $department }}</td>
                    </tr>
                    <tr>
                        <td>Location</td>
                        <td>:</td>
                        <td>{{ $location }}</td>
                    </tr>
                    <tr>
                        <td>Currency</td>
                        <td>:</td>
                        <td>{{ strtoupper($currency->code) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </header>

    <footer>
        <div class="container">
            <table width="100%">
                <tr>
                    <td>Printed on {{ date('d-m-Y H:i:s') }}
                    </td>
                    <td align="right" valign="bottom"> <span class="page-number">Page </span></td>
                </tr>
            </table>
        </div>
        <img src="./vendor/courier/img/form/printoutfa/FooterFA-A4-Landscape.png" width="100%" alt="" >
    </footer>

    <div id="content">
        <div class="container">
            <table width="100%" cellpadding="4" class="table-body" page-break-inside: auto;>  
                <thead>     
                    <tr>
                      <td align="left" valign="top" style="padding-left:8px;"><b>Supplier Name</b></td>
                      <td align="center" valign="top"><b>Account</b></td>
                      <td align="center" valign="top" colspan="2" style="color:red;"><i><b>1-6 Months</b></i></td>
                      <td align="center" valign="top"  colspan="2" style="color:red;"><i><b>7-12 Months</b></i></td>
                      <td align="center" valign="top"  colspan="2" style="color:red;"><i><b> 1 Year</b></i></td>
                      <td align="center" valign="top"  colspan="2" style="color:red;"><i><b> 2 Year</b></i></td>
                      <td align="center" valign="top"  colspan="2"><i><b>Total Balance</b></i></td>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($data as $vendor_row)
                    <tr>
                      <td class="nowrap" align="left" valign="top" style="padding-left:8px;">{{ $vendor_row->name }}</td>
                      <td class="nowrap" align="center" valign="top">{{ $vendor_row->coa_formated }}</td>
                      <td class="nowrap" align="right" valign="top" >{{ $currency->symbol }} </td>
                      <td class="nowrap" align="right" valign="top">{{ $class::currency_format($vendor_row->supplier_invoice1_6) }}</td>
                      <td class="nowrap" align="right" valign="top" >{{ $currency->symbol }} </td>
                      <td class="nowrap" align="right" valign="top">{{ $class::currency_format($vendor_row->supplier_invoice7_12) }}</td>
                      <td class="nowrap" align="right" valign="top" > {{ $currency->symbol }} </td>
                      <td class="nowrap" align="right" valign="top">{{ $class::currency_format($vendor_row->supplier_invoice_1) }}</td>
                      <td class="nowrap" align="right" valign="top" > {{ $currency->symbol }} </td>
                      <td class="nowrap" align="right" valign="top">{{ $class::currency_format($vendor_row->supplier_invoice_2) }}</td>
                      <td class="nowrap" align="right" valign="top" >{{ $currency->symbol }} </td>
                      <td class="nowrap" align="right" valign="top">{{ $class::currency_format($vendor_row->balance) }}</td>
                    </tr>
                    @php
                        $total1_6 += $vendor_row->supplier_invoice1_6;
                        $total7_12 += $vendor_row->supplier_invoice7_12;
                        $total_1 += $vendor_row->supplier_invoice_1;
                        $total_2 += $vendor_row->supplier_invoice_2;
                        $total_balance += $vendor_row->balance;
                    @endphp
                  @endforeach
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
        </div>
    </div>
</body>
</html>
