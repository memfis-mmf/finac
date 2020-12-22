@php
  use Illuminate\Support\Carbon;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Oustanding Invoices</title>
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
            margin-top: 5cm;
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
        }
        ul li{
            display: inline-block;
        }

        table{
            border-collapse: collapse;
        }

        #head{
            top: 4px;
            left: 220px;
            position: absolute;
            text-align: center;
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
        <img src="./vendor/courier/img/form/printoutfa/HeaderFA-A4-Landscape.png" alt=""width="100%">
        <div id="head">
            <table width="95%">
                <tr>
                    <td width="55%" valign="middle" style="font-size:14px;line-height:20px;">
                        Juanda International Airport, Surabaya Indonesia
                        <br>
                        Phone : 031-8686482 &nbsp;&nbsp;&nbsp; Fax : 031-8686500
                        <br>
                        Email : marketing@ptmmf.co.id
                        <br>
                        Website : www.ptmmf.co.id
                    </td>
                    <td width="45%" valign="top" align="center">
                        <h1 style="font-size:26px;">OUTSTANDING INVOICES<br> 
                        <span style="font-size:15px;font-weight: none;">Period : {{ Carbon::parse($date)->format('d F Y') }}</span></h1>
                    </td>
                </tr>
            </table>
        </div>
        <div id="body">
            <div class="container" style="margin-top:12px;">
                <table width="100%" cellpadding="3">
                    <tr>
                        <td width="12%" valign="top">MMF Department</td>
                        <td width="1%" valign="top">:</td>
                        <td width="77%" valign="top">MMF Department</td>
                    </tr>
                    <tr>
                        <td>MMF Location</td>
                        <td>:</td>
                        <td>{{ $request->location ?? '-'  }}</td>
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

    <div id="content">
        <div class="container">
          @foreach ($customer as $customer_row)
            <div style="margin-bottom:10px;">
                <table width="100%" cellpadding="3" class="table-head">
                    <tr>
                        <td width="12%" valign="top"><b>Customer Name</b></td>
                        <td width="1%" valign="top"><b>:</b></td>
                        <td width="77%" valign="top"><b>{{ $customer_row->name }}</b></td>
                    </tr>
                </table>
                <table width="100%" cellpadding="4" class="table-body" page-break-inside: auto;>  
                    <thead>     
                        <tr>
                            <td width="19%" align="left" valign="top" style="padding-left:8px;"><b>Invoice No.</b></td>
                            <td width="8%"align="center" valign="top"><b>Date</b></td>
                            <td width="8%"align="center" valign="top"><b>Due Date</b></td>
                            <td width="17%"align="center" valign="top"><b>Ref No.</b></td>
                            <td width="4%"align="center" valign="top"><b>Currency</b></td>
                            <td width="6%"align="center" valign="top" colspan="2"><b>Rate</b></td>
                            <td width="9%"align="center" valign="top"  colspan="2"><b>Sub Total Invoice</b></td>
                            <td width="13%"align="center" valign="top"  colspan="2"><b>VAT</b></td>
                            <td width="13%"align="center" valign="top"  colspan="2"><b>Ending Balance</b></td>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($customer_row->invoice as $invoice_row)
                        <tr>
                          <td width="19%" align="left" valign="top" style="padding-left:8px;">{{ $invoice_row->transactionnumber }}</td>
                          <td width="8%"align="center" valign="top">{{ Carbon::parse($invoice_row->transactiondate)->format('d F Y') }}</td>
                          <td width="8%"align="center" valign="top">{{  Carbon::parse($invoice_row->due_date)->format('d F Y') }}</td>
                          <td width="17%"align="left" valign="top">{{ $invoice_row->quotations->number ?? '-' }}</td>
                          <td width="4%"align="center" valign="top">{{ $invoice_row->currencies->code }}</td>
                          <td width="1%" align="right" valign="top">Rp </td>
                          <td width="5%"align="left" valign="top">{{ number_format($invoice_row->exchangerate, 2, ',', '.') }}</td>
                          <td width="1%" align="right" valign="top">{{ $invoice_row->currencies->symbol }}</td>
                          <td width="8%"align="right" valign="top" >{{ number_format($invoice_row->subtotal, 2, ',', '.') }}</td>
                          <td width="1%" align="right" valign="top">{{ $invoice_row->currencies->symbol }}</td>
                          <td width="12%"align="right" valign="top">{{ number_format($invoice_row->ppnvalue, 2, ',', '.') }}</td>
                          <td width="1%" align="right" valign="top">{{ $invoice_row->currencies->symbol }}</td>
                          <td width="12%"align="right" valign="top">{{ number_format($invoice_row->ending_balance['amount'], 2, ',', '.') }}</td>
                        </tr>
                      @endforeach
                      @foreach ($customer_row->sum_total as $sum_total_index => $sum_total_row)
                        <tr style="border-top:2px solid black;" >
                            <td colspan="5"></td>
                            <td align="left" valign="top" colspan="2"><b>Total {{ strtoupper($sum_total_index) }}</b></td>
                            <td width="1%" align="right" valign="top" class="table-footer"><b>{{ $sum_total_row['symbol'] }}</b></td>
                            <td width="12%"align="right" valign="top" class="table-footer"><b>{{ number_format($sum_total_row['subtotal'], 2, ',', '.') }}</b></td>
                            <td width="1%" align="right" valign="top" class="table-footer"><b>{{ $sum_total_row['symbol'] }}</b></td>
                            <td width="12%" align="right" valign="top" class="table-footer"><b>{{ number_format($sum_total_row['ppnvalue'], 2, ',', '.') }}</b></td>
                            <td width="1%" align="right" valign="top" class="table-footer"><b>{{ $sum_total_row['symbol'] }}</b></td>
                            <td width="12%"align="right" valign="top" class="table-footer"><b>{{ number_format($sum_total_row['ending_value'], 2, ',', '.') }}</b></td>
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
