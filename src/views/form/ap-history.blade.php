<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account Payables History</title>
    <style>
        @page {
            margin: 0cm 0cm;
        }
        
        html,body{
            padding: 0;
            margin: 0;
            font-size: 12px;
        }

        body{
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
            height: 1.3cm;
            font-size: 9px;
        }
        ul li{
            display: inline-block;
        }

        table{
            border-collapse: collapse;
        }

        #head{
            top: 12px;
            left: 220px;
            position: absolute;
        }
        .container{
            width: 100%;
            margin: 0 36px;
        }

        .barcode{
            margin-left:70px;
            margin-top:12px;
        }

        #content .table-head{
            margin-bottom: 8px;
        }

        #content .table-body thead tr td{
            border-bottom: 2px solid black;
        }
        #content .table-body tbody .table-footer{
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
        <img src="./vendor/courier/img/form/printoutfa/HeaderFA-A4-Potrait.png" alt="" width="100%">
        <div id="head">
            <table width="95%">
                <tr>
                    <td width="20%"></td>
                    <td width="55%" valign="middle" style="font-size:12px;line-height:20px;">
                        Jl. Indonesia Raya 116
                        <br>
                        Phone : 031-5730289 &nbsp;&nbsp;&nbsp; Fax : 031-5203618
                        <br>
                        Email : marketing@company.co.id
                        <br>
                        Website : www.company.co.id
                    </td>
                    <td width="45%" valign="top" align="center">
                        <h1 style="font-size:19px;">Account Payables History<br> 
                        <span style="font-size:12px;font-weight: none;">Period : {{ $carbon::parse($date[0])->format('d F Y') .' - '. $carbon::parse($date[1])->format('d F Y')}}</span></h1>
                    </td>
                </tr>
            </table>
        </div>
        <div id="body">
            <div class="container" style="margin-top:12px;">
                <table width="100%" cellpadding="3">
                    <tr>
                        <td width="18%" valign="top">Department</td>
                        <td width="1%" valign="top">:</td>
                        <td width="77%" valign="top">{{ $department ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Location</td>
                        <td>:</td>
                        <td style="text-transform: capitalize">{{ $request->location ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Currency</td>
                        <td>:</td>
                        <td>{{ $currency ?? 'All' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </header>

    <footer>
        <div class="container">
            <table width="100%">
                <tr>
                    <td>Printed on {{ date('d F Y H:i') }}
                    </td>
                    <td align="right" valign="bottom"> <span class="page-number">Page </span></td>
                </tr>
            </table>
        </div>
        <img src="./vendor/courier/img/form/printoutfa/FooterFA-A4-Landscape.png" width="100%" alt="" >
    </footer>

    <div id="content" style="font-size: 10px !important;">
        <div class="container">
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
            <div style="margin-bottom:10px">
                <table width="100%" cellpadding="3" class="table-head">
                    <tr>
                        <td width="18%" valign="top"><b>Customer Name</b></td>
                        <td width="1%" valign="top"><b>:</b></td>
                        <td width="71%" valign="top"><b>{{ $vendor_row->name }}</b></td>
                    </tr>
                </table>
                <table width="100%" cellpadding="4" class="table-body" page-break-inside: auto;>  
                    <thead style="font-size:10px;">     
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
                    <tbody style="font-size:10px;">
                      @foreach ($vendor_row->supplier_invoice as $invoice_row)
                        <tr style="font-size:8.4pt;" class="nowrap">
                            <td width="" align="left" valign="top" style="padding-left:8px;">{{ $invoice_row->transaction_number }}</td>
                            <td width="" align="center" valign="top">{{ $carbon::parse($invoice_row->transaction_date)->format('d F Y') }}</td>
                            <td width="" align="left" valign="top">{{ $invoice_row->quotations->number ?? '-' }}</td>
                            <td width="" align="left" valign="top">{!! $controller->fa_format('Rp', number_format($invoice_row->exchange_rate, 2, ',', '.'), true) !!}</td>
                            {{-- <td width="" align="left" valign="top">{!! $invoice_row->description !!}</td> --}}
                            {{-- <td width="" align="right" valign="top">{!! $controller->fa_format($invoice_row->currencies->symbol, number_format($invoice_row->subtotal, 2, ',', '.'), true) !!}</td> --}}
                            <td width="" align="right" valign="top">{!! $controller->fa_format($invoice_row->currencies->symbol, number_format($invoice_row->discount_value, 2, ',', '.'), true) !!}</td>
                            <td width="" align="right" valign="top">{!! $controller->fa_format($invoice_row->currencies->symbol, number_format($invoice_row->ppn_value, 2, ',', '.'), true) !!}</td>
                            <td width="" align="right" valign="top">{!! $controller->fa_format($invoice_row->currencies->symbol, number_format($invoice_row->grandtotal_foreign, 2, ',', '.'), true)  !!}</td>
                            <td width="" align="right" valign="top">{!! $controller->fa_format($invoice_row->currencies->symbol, number_format($invoice_row->ap_amount['debit'], 2, ',', '.'), true) !!}</td>
                            {{-- <td width="" align="right" valign="top">{{ number_format(0, 2, ',', '.') }}</td> --}}
                            <td width="" align="right" valign="top">{!! $controller->fa_format($invoice_row->currencies->symbol, number_format($invoice_row->ending_balance['amount'], 2, ',', '.'), true) !!}</td>
                            <td width="" align="right" valign="top">{!! $controller->fa_format('Rp', number_format($invoice_row->ending_balance['amount_idr'], 2, ',', '.'), true) !!}</td>
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
                            {!! $controller->fa_format($total_row['currency']->symbol, $controller::currency_format($total_row['ending_balance_total'], 2), true) !!}
                          </b>
                        </td>
                        <td width="" align="right" valign="top" class="table-footer">
                          <b>
                            {!! $controller->fa_format($total_row['currency']->symbol, $controller::currency_format($total_row['discount_total'], 2), true) !!}
                          </b>
                        </td>
                        <td width="" align="right" valign="top" class="table-footer">
                          <b>
                            {!! $controller->fa_format($total_row['currency']->symbol, $controller::currency_format($total_row['vat_total'], 2), true) !!}
                          </b>
                        </td>
                        <td width="" align="right" valign="top" class="table-footer">
                          <b>
                            {!! $controller->fa_format($total_row['currency']->symbol, $controller::currency_format($total_row['invoice_total'], 2), true) !!}
                          </b>
                        </td>
                        <td width="" align="right" valign="top" class="table-footer">
                          <b>
                            {!! $controller->fa_format($total_row['currency']->symbol, $controller::currency_format($total_row['paid_amount_total'], 2), true) !!}
                          </b>
                        </td>
                        <td width="" align="right" valign="top" class="table-footer">
                          <b>
                            {!! $controller->fa_format('Rp', $controller::currency_format($total_row['ending_balance_total_idr'], 2), true) !!}
                          </b>
                        </td>
                      </tr>   
                      @endforeach
                    </tbody>
                </table>
            </div> 
          @endforeach
        </div>
    </div>

</body>
</html>
