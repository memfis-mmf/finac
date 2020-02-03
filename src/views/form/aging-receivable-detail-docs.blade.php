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
            margin-top: 4.5cm;
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
                        <h1 style="font-size:26px;">AGING RECEIVABLE DETAIL<br> 
                        <span style="font-size:15px;font-weight: none;">Period : 01 January 2020 - 28 January 2020</span></h1>
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
                        <td>Sidoarjo</td>
                    </tr>
                </table>
            </div>
        </div>
    </header>

    <footer>
        <div class="container">
            <table width="100%">
                <tr>
                    <td>Printed on 26 January 2020 18:53 <br> 
                        <b>Merpati Maintenance Facility Information System Report</b>
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
                        <td width="15%" align="left" valign="top" style="padding-left:8px;"><b>Customer Name</b></td>
                        <td width="12%"align="center" valign="top"><b>ACC No.</b></td>
                        <td width="8%"align="center" valign="top"><b>Currency</b></td>
                        <td width="13%"align="center" valign="top" colspan="2" style="color:red;"><i><b>1-6 Months</b></i></td>
                        <td width="13%"align="center" valign="top"  colspan="2" style="color:red;"><i><b>7-12 Months</b></i></td>
                        <td width="13%"align="center" valign="top"  colspan="2" style="color:red;"><i><b>> 1 Year</b></i></td>
                        <td width="13%"align="center" valign="top"  colspan="2" style="color:red;"><i><b>> 2 Year</b></i></td>
                        <td width="13%"align="center" valign="top"  colspan="2"><i><b>Total Balance</b></i></td>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 100; $i++)
                        <tr>
                            <td width="15%" align="left" valign="top" style="padding-left:8px;">Sriwijaya Air</td>
                            <td width="12%"align="center" valign="top">111423</td>
                            <td width="8%"align="center" valign="top">IDR</td>
                            <td width="1%"align="right" valign="top" >Rp.</td>
                            <td width="12%"align="right" valign="top">1.232.232,00</td>
                            <td width="1%"align="right" valign="top" >Rp.</td>
                            <td width="12%"align="right" valign="top">1.232.232,00</td>
                            <td width="1%"align="right" valign="top" > Rp.</td>
                            <td width="12%"align="right" valign="top"> 1.232.232,00</td>
                            <td width="1%"align="right" valign="top" > Rp.</td>
                            <td width="12%"align="right" valign="top"> 1.232.232,00</td>
                            <td width="1%"align="right" valign="top" >Rp.</td>
                            <td width="12%"align="right" valign="top">1.232.232,00</td>
                        </tr>
                    @endfor
                    {{-- Total in IDR --}}
                    <tr>
                        <td align="center" valign="top" colspan="3"><b>Total IDR</b></td>
                        <td width="1%"align="right" valign="top" class="table-footer"><b>Rp.</b></td>
                        <td width="12%"align="right" valign="top" class="table-footer"><b>1.232.232,00</b></td>
                        <td width="1%"align="right" valign="top" class="table-footer"><b>Rp.</b></td>
                        <td width="12%"align="right" valign="top" class="table-footer"><b>1.232.232,00</b></td>
                        <td width="1%"align="right" valign="top" class="table-footer"><b>Rp.</b></td>
                        <td width="12%"align="right" valign="top" class="table-footer"><b>1.232.232,00</b></td>
                        <td width="1%"align="right" valign="top" class="table-footer"><b> Rp.</b></td>
                        <td width="12%"align="right" valign="top" class="table-footer"><b>1.232.232,00</b></td>
                        <td width="1%"align="right" valign="top" class="table-footer"><b>Rp.</b></td>
                        <td width="12%"align="right" valign="top" class="table-footer"><b>1.232.232,00</b></td>
                    </tr>
                    {{-- Total in USD --}}
                    <tr>
                        <td align="center" valign="top" colspan="3"><b>Total USD</b></td>
                        <td width="1%"align="right" valign="top"><b>$</b></td>
                        <td width="12%"align="right" valign="top"><b>1.232.232.000,00</b></td>
                        <td width="1%"align="right" valign="top"><b>$</b></td>
                        <td width="12%"align="right" valign="top"><b>1.232.232.000,00</b></td>
                        <td width="1%"align="right" valign="top"><b>$</b></td>
                        <td width="12%"align="right" valign="top"><b>1.232.232.000,00</b></td>
                        <td width="1%"align="right" valign="top"><b> $</b></td>
                        <td width="12%"align="right" valign="top"><b>1.232.232.000,00</b></td>
                        <td width="1%"align="right" valign="top"><b>$</b></td>
                        <td width="12%"align="right" valign="top"><b>1.232.232.000,00</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
