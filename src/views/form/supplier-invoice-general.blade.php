<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$header->transaction_number}}-General</title>
    <style>
        @page {
            margin: 0cm 0cm;
        }
        
        html,body{
            padding: 0;
            margin: 0;
            font-size: 11px;
        }

        body{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin-top: 2.3cm;
            margin-bottom: 1cm;
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
            height: 1cm;
            font-size: 9px;
        }
        /* ul li{
            display: inline-block;
        } */

        ol,ul {
            counter-reset: item; 
            padding-left: 0; 
            line-height: 1;
        }

        ol > li,
        ul > li{ 
            counter-increment: item;  
            padding-left:1.5em;
            position: relative; 
            page-break-inside: avoid;
        }

        table{
            border-collapse: collapse;
        }

        #head{
            top:-3px;
            left: 150px;
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

        #content2, #content3, #content4{
            margin-top:12px;
        }

        #content2 table thead{
            border-bottom: 2px solid grey;
        }

        #content2 table tbody{
            border-bottom: 2px solid grey;
        }

        #content3 .body{
            border:1px solid #d4d7db;
            width:95%;
            min-height:80px;
            border-radius:10px;
            padding:6px;
        }

        #content4{
            font-size: 9px;
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
                    <td width="55%" valign="middle" style="font-size:9px;">
                        Jl. Indonesia Raya 116
                        <br>
                        Phone : 031-5730289 &nbsp;&nbsp;&nbsp; Fax : 031-5730289
                        <br>
                        Email : marketing@company.co.id
                        <br>
                        Website : www.company.co.id
                    </td>
                    <td width="45%" valign="top" align="center">
                        <h1 style="font-size:24px;">OFFICIAL RECEIPT</h1>
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <footer>
        <div class="container">
            <table width="100%">
                <tr>
                    <td>Printed on {{date('d-m-Y H:i:s')}}
                    </td>
                    <td align="right" valign="bottom"> <span class="page-number">Page </span></td>
                </tr>
            </table>
        </div>
        <img src="./vendor/courier/img/form/printoutfa/FooterFA-A4-Landscape.png" width="100%" alt="" >
    </footer>

    <div id="content">
        <div class="container">
            <table width="100%">
                <tr>
                    <td width="60%"  valign="top">
                        <table width="100%%" cellpadding="4">
                            <tr>
                                <td width="25%" valign="top"><b>Received From</b></td>
                                <td width="1%" valign="top">:</td>
                                <td width="74%" valign="top">
                                  {{$header->vendor->name}}<br>
                                  {{
                                    (@$header->vendor->addresses->first())? @$header->vendor->addresses->first()->address: '-'
                                  }}<br>
                                  Phone : {{
                                    (@$header->vendor->phones->first())? @$header->vendor->phones->first()->number: '-'
                                  }}<br>
                                  Fax : {{
                                    (@$header->vendor->faxes->first())? @$header->vendor->faxes->first()->number: '-'
                                  }}<br>
                                  Email : {{
                                    (@$header->vendor->emails->first()->address)? @$header->vendor->emails->first()->address: '-'
                                  }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="40%" valign="top">
                        <table width="100%">
                            <tr>
                                <td width="40%" valign="top"><b>Receipt No.</b></td>
                                <td width="1%" valign="top">:</td>
                                <td width="59%" valign="top">{{$header->transaction_number}}</td>
                            </tr>
                            <tr>
                                <td width="40%" valign="top"><b>Date</b></td>
                                <td width="1%" valign="top">:</td>
                                <td width="59%" valign="top">{{$header->transaction_date->format('d-m-Y')}}</td>
                            </tr>
                            <tr>
                                <td width="40%" valign="top"><b>Term of Payment</b></td>
                                <td width="1%" valign="top">:</td>
                                <td width="59%" valign="top">{{$header->closed}} Day</td>
                            </tr>
                            <tr>
                                <td width="40%" valign="top"><b>Due Date</b></td>
                                <td width="1%" valign="top">:</td>
                                <td width="59%" valign="top">{{$header->due_date}}</td>
                            </tr>
                            <tr>
                                <td width="40%" valign="top"><b>Currency</b></td>
                                <td width="1%" valign="top">:</td>
                                <td width="59%" valign="top">{{$header->currencies->code}}</td>
                            </tr>
                            <tr>
                                <td width="40%" valign="top"><b>Rate</b></td>
                                <td width="1%" valign="top">:</td>
                                <td width="59%" valign="top">{{number_format($header->exchange_rate, 0, ',', '.')}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div id="content2">
        <div class="container">
            <table width="100%" cellpadding="4" page-break-inside: auto;>
                <thead>
                    <tr>
                        <th valign="top" align="center" width="20%">Account Code</th>
                        <th valign="top" align="center" width="20%">Account Name</th>
                        <th valign="top" align="center" width="30%">Description</th>
                        <th valign="top" align="center" width="30%">Total</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($detail as $item)
                    <tr>
                      <td valign="top" align="center" width="20%">{{$item->coa->code}}</td>
                      <td valign="top" align="center" width="20%">{{$item->coa->name}}</td>
                      <td valign="top" align="center" width="30%">{!! $item->description !!}</td>
                      <td valign="top" align="right" width="30%">{{$class::currency_format($item->total)}} </td>
                    </tr>
                  @endforeach
                  @foreach ($adjustment as $adjustment_row)
                    <tr>
                      <td valign="top" align="center" width="20%">{{$adjustment_row->coa->code}}</td>
                      <td valign="top" align="center" width="20%">{{$adjustment_row->coa->name}}</td>
                      <td valign="top" align="center" width="30%">{{$adjustment_row->description}}</td>
                      <td valign="top" align="right" width="30%">{{$adjustment_row->single_amount_formated}} </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="content3">
        <div class="container">
            <table width="100%">
                <tr>
                    <td width="60%" valign="top">
                        <div class="body">
                            <table width="100%">
                                <tr>
                                    <td width="10%" valign="top"><b>Remark</b></td>
                                    <td width="1%" valign="top">:</td>
                                    <td width="89%" valign="top">{{$header->description}} </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td width="40%" valign="top">
                        <table width="100%">
                            <tr>
                                <td width="40%" valign="top"><b>GRAND TOTAL</b></td>
                                <td width="60%" valign="top" align="right"><b>{{$class::currency_format($total)}}</b></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div id="content4">
        <div class="container">
            <table width="40%">
                <tr>
                    <td>
                        <table width="70%">
                            <tr>
                                <td align="center"><b>Authorized Signature,</b></td>
                            </tr>
                            <tr>
                                <td height="30"></td>
                            </tr>
                            <tr>
                                <td align="center">
                                  {{@$header->approvals->first()->conductedBy->full_name}}
                                  <hr>
                                  {{@$header->department}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</body>
</html>
