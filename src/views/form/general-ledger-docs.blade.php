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
        
        html,body{
            padding: 0;
            margin: 0;
            font-size: 12px;
        }

        body{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin-top: 3.6cm;
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

        #content .transaction tbody{
            border-right: 1px solid #d4d7db;
            border-left: 1px solid  #d4d7db;
            border-bottom: 1px solid  #d4d7db;
        }

        #content .transaction tbody tr td{
            border-bottom: 1px solid  #d4d7db;
        }

        .transaction{
            margin-top: 12px;
        }

        .accountcode{
            margin-top: 12px;
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
                        <h1 style="font-size:26px;">GENERAL LEDGER<br> 
                        <span style="font-size:15px;font-weight: none;">Period : 01 January 2020 - 28 January 2020</span></h1>
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <footer>
        <div class="container">
            <table width="100%">
                <tr>
                    <td>Printed on 26 January 2020 18:53
                    </td>
                    <td align="right" valign="bottom"> <span class="page-number">Page </span></td>
                </tr>
            </table>
        </div>
        <img src="./vendor/courier/img/form/printoutfa/FooterFA-A4-Landscape.png" width="100%" alt="" >
    </footer>

    <div id="content">
        <div class="container">
        @foreach ($data as $items)
            <table class="accountcode" width="100%" style="font-size:14px;" >
                <tr >
                    <td width="9%" >Account Code</td>
                    <td width="1%">:</td>
                    <td width="90%">{{$items[0]->AccountCode}} - <span> {{$items[0]->Name}}</span> </td>
                </tr>
            </table>
            <table class="transaction" width="100%" cellpadding="6" page-break-inside: auto;>
                <thead>
                    <tr style="background:#72829c;color:white;">
                        <th valign="top" align="center" width="10%">Date</th>
                        <th valign="top" align="center" width="13%">Transaction No.</th>
                        <th valign="top" align="center" width="12%">Ref. No.</th>
                        <th valign="top" align="center" width="20%">Description</th>
                        <th valign="top" align="center" width="15%">Debit</th>
                        <th valign="top" align="center" width="15%">Credit</th>
                        <th valign="top" align="center" width="15%">Ending Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        
                        <tr>
                            <td valign="top" width="10%">{{$item->TransactionDate}}</td>
                            <td valign="top" width="13%">{{$item->VoucherNo}}</td>
                            <td valign="top" width="12%">-</td>
                            <td valign="top" width="20%">{{$item->Description}}</td>
                            <td valign="top" width="15%" align="right" style="padding-right:10px">{{number_format($item->Debit, 0, 0, '.')}}</td>
                            <td valign="top" width="15%" align="right" style="padding-right:10px">{{number_format($item->Credit, 0, 0, '.')}}</td>
                            <td valign="top" width="15%" align="right" style="padding-right:10px">{{number_format($item->SaldoAwal, 0, 0, '.')}}</td>
                        </tr>
                        
                    @endforeach
                </tbody>
            </table>
        @endforeach
        </div>
    </div>
</body>
</html>
