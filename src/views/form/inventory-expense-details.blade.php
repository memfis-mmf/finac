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
            margin-top: 3.1cm;
            margin-bottom: 1.5cm;
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
            font-size: 9px;
        }
        ul li{
            display: inline-block;
        }

        table{
            border-collapse: collapse;
        }

        #head{
            top: 10px;
            left: 210px;
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

        #content{
            color:blue;
            font-weight: 700;
            margin-bottom:20px;
        }


        #content2 thead tr td{
            border-bottom: 2px solid black;
            font-weight: bold;
        }
        #content2 tbody tr td{
            border-bottom: 1px solid grey;
        }

        .page_break {
            page-break-before: always;
        }

        footer .num:after { 
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
                    <td valign="top" align="center">
                        <h1 style="font-size:24px;">
                            INVENTORY EXPENSE DETAILS
                        </h1>
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <footer>
        <div class="container" style="margin-bottom:6px;">
            <table width="100%">
                <tr>
                    <td>Print on March 25 2020 18.53</td>
                    <td align="right">Page <span class="num"></span></td>
                </tr>
            </table>
        </div>

        <img src="./vendor/courier/img/form/printoutfa/FooterFA-A4-Potrait.png" width="100%" alt="" >
    </footer>

    <div id="content">
        <div class="container">
            <table width="100%">
                <tr>
                    <td width="50%" valign="top">
                        <table width="100%" cellpadding="4">
                            <tr>
                                <td valign="top" width="30%">Project Title</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">generated</td>
                            </tr>
                            <tr>
                                <td valign="top" width="30%">Project No.</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">generated</td>
                            </tr>
                            <tr>
                                <td valign="top" width="30%">Quotation No.</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">generated</td>
                            </tr>
                            <tr>
                                <td valign="top" width="30%">Work Order No.</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">generated</td>
                            </tr>
                            <tr>
                                <td valign="top" width="30%">Invoice No.</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">generated</td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%" valign="top">
                        <table width="100%" cellpadding="4">
                            <tr>
                                <td valign="top" width="30%">A/C Type</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">Lorem </td>
                            </tr>
                            <tr>
                                <td valign="top" width="30%">A/C Reg</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">generated</td>
                            </tr>
                            <tr>
                                <td valign="top" width="30%">A/C Serial No.</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">generated</td>
                            </tr>
                            <tr>
                                <td valign="top" width="30%">Start Date</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">generated</td>
                            </tr>
                            <tr>
                                <td valign="top" width="30%">End Date</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">generated</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div id="content2">
        <div class="container">
            <table cellpadding="4" width="100%" page-break-inside: auto;>
                <thead>
                    <tr>
                        <td align="center" width="1%">No.</td>
                        <td align="center">Transaction No.</td>
                        <td align="center">Part Number</td>
                        <td align="center" width="20%">Items Name</td>
                        <td align="center" width="8%">Qty</td>
                        <td align="center" width="8%">Unit</td>
                        <td align="center">Amount</td>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 40; $i++)    
                        <tr>
                            <td align="center" valign="top">1</td>
                            <td valign="top">MTRQ-YYYY/MM/00001</td>
                            <td align="center" valign="top">123232123</td>
                            <td valign="top">3M RADIAL BRISTAL DISC 2-P120</td>
                            <td align="center" valign="top">100</td>
                            <td align="center" valign="top">Centimeter</td>
                            <td align="right" valign="top">1.000.000.000</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
