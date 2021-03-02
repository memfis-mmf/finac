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
                    <td width="55%" valign="middle" style="font-size:12px;line-height:20px;">
                        Juanda International Airport, Surabaya Indonesia
                        <br>
                        Phone : 031-8686482 &nbsp;&nbsp;&nbsp; Fax : 031-8686500
                        <br>
                        Email : marketing@ptmmf.co.id
                        <br>
                        Website : www.ptmmf.co.id
                    </td>
                    <td width="45%" valign="top" align="center">
                        <h1 style="font-size:19px;">OUTSTANDING INVOICES<br> 
                        <span style="font-size:12px;font-weight: none;">Period : {{ Carbon::parse($date)->format('d F Y') }}</span></h1>
                    </td>
                </tr>
            </table>
        </div>
        <div id="body">
            <div class="container" style="margin-top:12px;">
                <table width="100%" cellpadding="3">
                    <!-- <tr>
                        <td width="18%" valign="top">MMF Department</td>
                        <td width="1%" valign="top">:</td>
                        <td width="71%" valign="top">MMF Department</td>
                    </tr>
                    <tr>
                        <td>MMF Location</td>
                        <td>:</td>
                        <td>{{ $request->location ?? '-'  }}</td>
                    </tr> -->
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
          @foreach ($vendor as $vendor_row)
            <div style="margin-bottom:10px;">
                <table width="100%" cellpadding="3" class="table-head">
                    <tr>
                        <td width="18%" valign="top"><b>Supplier Name</b></td>
                        <td width="1%" valign="top"><b>:</b></td>
                        <td width="71%" valign="top"><b>{{ $vendor_row->name }}</b></td>
                    </tr>
                </table>
                <table width="100%" cellpadding="4" class="table-body" page-break-inside: auto;>  
                    <thead style="font-size:10px;">     
                        <tr>
                            <td width="15%" align="left" valign="top" style="padding-left:8px;"><b>Invoice No.</b></td>
                            <td width="11%"align="center" valign="top"><b>Date</b></td>
                            <td width="11%"align="center" valign="top"><b>Due Date</b></td>
                            <td width="10%"align="center" valign="top"><b>Ref No.</b></td>
                            <td width="4%"align="center" valign="top"><b>Currency</b></td>
                            <td width="8%"align="center" valign="top"><b>Rate</b></td>
                            <td width="16%"align="center" valign="top"><b>Total Invoice</b></td>
                            <td width="25%"align="center" valign="top"><b>Outstanding Balance</b></td>
                        </tr>
                    </thead>
                    <tbody style="font-size:10px;">
                      @foreach ($vendor_row->supplier_invoice as $supplier_invoice_row)
                        <tr>
                          <td align="left" valign="top" style="padding-left:8px;">{{ $supplier_invoice_row->transaction_number }}</td>
                          <td align="center" valign="top">{{ Carbon::parse($supplier_invoice_row->updated_at)->format('d F Y') }}</td>
                          <td align="center" valign="top">{!! $supplier_invoice_row->due_date_formated !!}</td>
                          <td align="left" valign="top">{{ $supplier_invoice_row->project->code ?? '-' }}</td>
                          <td align="center" valign="top">{{ $supplier_invoice_row->currencies->code }}</td>
                          <td align="center" valign="top">{{ number_format($supplier_invoice_row->exchange_rate, 2, ',', '.') }}</td>
                          <td align="right" valign="top" >{{ number_format($supplier_invoice_row->grandtotal_foreign, 2, ',', '.') }}</td>
                          <td align="right" valign="top">{{ number_format($supplier_invoice_row->ending_balance['amount'], 2, ',', '.') }}</td>
                        </tr>
                      @endforeach
                      @foreach ($vendor_row->sum_total as $sum_total_index => $sum_total_row)
                        <tr style="border-top:2px solid black;" >
                            <td colspan="4"></td>
                            <td align="right" valign="top" colspan="2"><b>Total {{ strtoupper($sum_total_index) }}</b></td>
                            <td align="right" valign="top" class="table-footer"><b>{{ number_format($sum_total_row['grandtotal_foreign'], 2, ',', '.') }}</b></td>
                            <td align="right" valign="top" class="table-footer"><b>{{ number_format($sum_total_row['ending_value'], 2, ',', '.') }}</b></td>
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
