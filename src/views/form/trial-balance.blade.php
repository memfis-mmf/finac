<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trial Balance {{ $startDate }} - {{ $finishDate }} </title>
    <style>
        @page {
            margin: 0cm, 0cm;
        }
        html,body{
            padding: 0;
            margin: 0;
            font-size: 12px;
        }
        
        body {
            margin-top: 3.5cm;
            margin-bottom: 1cm;
            font-family: 'Segeo UI', Tahoma, Geneva, Verdana, sans-serif;
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
            height: 1.8cm;
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
            top:8px;
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
 
        #content{
            width:100%;
            margin-bottom:34px;
        }
 
        #content table tr td{
            /* border-left:  1px solid  #d4d7db;
            border-right:  1px solid  #d4d7db;
            border-top:  1px solid  #d4d7db; */
            border-bottom:  1px solid  #d4d7db;
        }
 
        #content2{
            width:100%;
            margin-bottom:34px;
        }
 
        #content2 table tr td{
            /* border-left:  1px solid  #d4d7db;
            border-right:  1px solid  #d4d7db;
            border-top:  1px solid  #d4d7db; */
            border-bottom:  1px solid  #d4d7db;
        }
 
        .page_break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <header>
    <img src="./vendor/courier/img/form/printoutfa/HeaderFA-A4-Landscape.png" alt="" width="100%">
        <div id="head">
        <table width="95%">
                <tr>
                    <td width="55%" valign="middle" style="font-size:14px;line-height:20px;">
                        Jl. Indonesia Raya 116
                        <br>
                        Phone : 031-5730289 &nbsp;&nbsp;&nbsp; Fax : 031-5730289
                        <br>
                        Email : marketing@company.co.id
                        <br>
                        Website : www.company.co.id
                    </td>
                    <td width="45%" valign="top" align="center">
                        <h1 style="font-size:26px;">TRIAL BALANCE<br> 
                        <span style="font-size:15px;font-weight: none;">Period : {{ $startDate }} - {{ $finishDate }}</span></h1>
                    </td>
                </tr>
            </table>
        </div>
    </header>
 
    <footer>
        <table width="100%">
            <tr>
                <td>  <span style="margin-left:6px;">Printed By : {{Auth::user()->name}} ;</span> </td>
            </tr>
        </table>
        <img src="./vendor/courier/img/form/trial-balance/Footer.png" width="100%" alt="" >
    </footer>
 
    <div id="content">
        <div class="container">
            <table width="100%" cellpadding="6" page-break-inside: auto;>
                <thead style="background:#72829c;color:white;">
                    <tr>
                        <th valign="top" align="left" width="14%">Account Code</th>
                        <th valign="top" align="left" width="16%">Account Name</th>
                        <th valign="top" align="center" width="16%">Beginning Balance</th>
                        <th valign="top" align="center" width="18%">Debit</th>
                        <th valign="top" align="center" width="18%">Credit</th>
                        <th valign="top" align="center" width="18%">Ending Balance</th>
                    </tr>
                </thead>
                <tbody style="border-left:  1px solid  #d4d7db;border-right:  1px solid  #d4d7db;">
                  @foreach ($data as $data_row)
                    <tr>
                        <td valign="top" width="14%" style="border-left:  1px solid  #d4d7db;">{{ $data_row->code }}</td>
                        <td valign="top" width="16%">{{ $data_row->name }}</td>
                        <td valign="top" align="center" width="16%">{{ number_format($data_row->LastBalance, 0, ',', '.') }}</td>
                        <td valign="top" align="center" width="18%">{{ number_format($data_row->Debit, 0, ',', '.') }}</td>
                        <td valign="top" align="center" width="18%">{{ number_format($data_row->Credit, 0, ',', '.') }}</td>
                        <td valign="top" align="center" width="18%" style="border-right:  1px solid  #d4d7db;">{{ number_format($data_row->EndingBalance, 0, ',', '.') }}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>