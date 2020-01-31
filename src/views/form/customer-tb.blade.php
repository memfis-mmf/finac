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
            margin-top: 6.8cm;
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
            height: 1.8cm;
        }
        ul li{
            display: inline-block;
        }

        table{
            border-collapse: collapse;
        }

        #head{
            top:28px;
            left: 510px;
            position: absolute;
            color: #5c5b5b;
            text-align: center;
        }

        #body #header-content tr td{
            border-bottom: 2px solid  black;
        }

        .container{
            width: 100%;
            margin: 0 36px;
        }

        .barcode{
            margin-left:70px;
            margin-top:12px;
        }

        #content table .amount{
            border-top: 2px solid  black;
        }

        .page_break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <header>
        <img src="./vendor/courier/img/form/trial-balance/Header.png" alt=""width="100%">
        <div id="head">
            <div style="margin-right:20px;">
                <h1 style="font-size:18px;">CUSTOMER TRIAL BALANCE <br> 
                <span style="font-size:14px;font-weight: none;">Period : 01/01/2020 - 28/01/2020</span></h1>
            </div>
        </div>
        <div id="body">
            <div class="container" style="margin-top:12px;">
                <table width="100%" cellpadding="3">
                    <tr>
                        <td width="20%" valign="top">MMF Department</td>
                        <td width="1%" valign="top">:</td>
                        <td width="79%" valign="top">MMF Department</td>
                    </tr>
                    <tr>
                        <td>MMF Location</td>
                        <td>:</td>
                        <td>Sidoarjo</td>
                    </tr>
                    <tr>
                        <td colspan="3"><i>All Currency in IDR</i></td>
                    </tr>
                </table>
                <table width="100%" cellpadding="3" style="margin-top:12px;" id="header-content">
                    <tr>
                        <td width="20%" align="center"><b>Customer Name</b></td>
                        <td width="20%" align="center"><b>Beginning Balace</b></td>
                        <td width="20%" align="center"><b>Debit</b></td>
                        <td width="20%" align="center"><b>Credit</b></td>
                        <td width="20%" align="center"><b>Credit</b></td>
                    </tr>
                </table>
            </div>
        </div>
    </header>

    <footer>
        <table width="100%">
            <tr>
                <td>  <span style="margin-left:6px;">Created By :  ;  &nbsp;&nbsp;&nbsp; Name :  ; </span> </td>
            </tr>
        </table>
        <img src="./vendor/courier/img/form/trial-balance/Footer.png" width="100%" alt="" >
    </footer>

    <div id="content">
        <div class="container">
            <table width="100%" cellpadding="6">
                @for ($i = 0; $i < 100; $i++)
                    <tr>
                        <td width="20%" align="left" valign="top">Merpati</td>
                        <td width="20%" align="right" valign="top">1.000.000.000.000</td>
                        <td width="20%" align="right" valign="top">1.000.000.000.000</td>
                        <td width="20%" align="right" valign="top">1.000.000.000.000</td>
                        <td width="20%" align="right" valign="top">1.000.000.000.000</td>
                    </tr>
                @endfor
                <tr>
                    <td width="20%" align="right" valign="top"><b>TOTAL</b></td>
                    <td width="20%" align="right" valign="top" class="amount"><b>1.000.000.000.000</b></td>
                    <td width="20%" align="right" valign="top" class="amount"><b>1.000.000.000.000</b></td>
                    <td width="20%" align="right" valign="top" class="amount"><b>1.000.000.000.000</b></td>
                    <td width="20%" align="right" valign="top" class="amount"><b>1.000.000.000.000</b></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
