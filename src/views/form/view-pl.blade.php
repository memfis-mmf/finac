<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        html,body{
            padding: 0;
            margin: 0;
            font-size: 12px;
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
            top:20px;
            left: 510px;
            position: absolute;
            color: #5c5b5b;
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
            margin-top:155px;
            margin-bottom:34px;
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
            <div style="margin-right:20px;text-align:center;">
                <h1 style="font-size:24px;">PROFIT & LOSS</h1>
                <h4>Period : 10/01/2019 - 10/01/2019</h4>
            </div>
        </div>
    </header>

    <footer>
        <table width="100%">
            <tr>
                <td>  <span style="margin-left:6px;">Created By :  ;  &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp; Printed By :  ; </span> </td>
            </tr>
        </table>
        <img src="./vendor/courier/img/form/trial-balance/Footer.png" width="100%" alt="" >
    </footer>

    <div id="content">
        <div class="container">
            <table width="100%" cellpadding="5">
                <tr style="background:#5f6b5e; color:white;font-weight: bold;">
                    <td width="60%">Account Name</td>
                    <td width="20%"  align="center">Accumulated</td>
                    <td width="20%"  align="center">Periods</td>
                </tr>
                <tr>
                    <td width="60%" style="font-weight: bold; border-bottom:1px solid black"><h3>Revenue</h3></td>
                    <td width="20%"  align="center" style="border-bottom:1px solid black"></td>
                    <td width="20%"  align="center"  style="border-bottom:1px solid black"></td>
                </tr>
                <tr>
                    <td width="60%">Operating Revenue</td>
                    <td width="20%"  align="center"></td>
                    <td width="20%"  align="center"></td>
                </tr>
                <tr>
                    <td width="60%">Sales Discount</td>
                    <td width="20%"  align="center"></td>
                    <td width="20%"  align="center"></td>
                </tr>
                <tr>
                    <td width="60%" style="font-weight: bold; border-bottom:1px solid black"><h3>Non Operating Revenue (Expense)</h3></td>
                    <td width="20%"  align="center" style="border-bottom:1px solid black"></td>
                    <td width="20%"  align="center" style="border-bottom:1px solid black"></td>
                </tr>
                <tr>
                    <td width="60%">Non Operating Revenue</td>
                    <td width="20%"  align="center"></td>
                    <td width="20%"  align="center"></td>
                </tr>
                <tr style="background:#add8f7;font-weight: bold;">
                    <td width="60%"><h5>Total Revenue</h5></td>
                    <td width="20%"  align="center">Amount</td>
                    <td width="20%"  align="center">Amount</td>
                </tr>
                <tr>
                    <td width="60%" style="font-weight: bold; border-bottom:1px solid black"><h3>Cost Of Gold</h3></td>
                    <td width="20%"  align="center" style="border-bottom:1px solid black"></td>
                    <td width="20%"  align="center" style="border-bottom:1px solid black"></td>
                </tr>
                <tr>
                    <td width="60%">Production Expenses</td>
                    <td width="20%"  align="center"></td>
                    <td width="20%"  align="center"></td>
                </tr>
                <tr>
                    <td width="60%">Maintenance & Repair Expense</td>
                    <td width="20%"  align="center"></td>
                    <td width="20%"  align="center"></td>
                </tr>
                <tr>
                    <td width="60%">Direct Labor</td>
                    <td width="20%"  align="center"></td>
                    <td width="20%"  align="center"></td>
                </tr>
                <tr>
                    <td width="60%">Distribution Cost</td>
                    <td width="20%"  align="center"></td>
                    <td width="20%"  align="center"></td>
                </tr>
                <tr >
                    <td width="60%" style="font-weight: bold; border-bottom:1px solid black"><h3>Operating Expense</h3></td>
                    <td width="20%"  align="center"  style="border-bottom:1px solid black"></td>
                    <td width="20%"  align="center" style="border-bottom:1px solid black"></td>
                </tr>
                <tr>
                    <td width="60%">Sales Cost</td>
                    <td width="20%"  align="center"></td>
                    <td width="20%"  align="center"></td>
                </tr>
                <tr>
                    <td width="60%">Organization Expense</td>
                    <td width="20%"  align="center"></td>
                    <td width="20%"  align="center"></td>
                </tr>
                <tr>
                    <td width="60%">General Expenses</td>
                    <td width="20%"  align="center"></td>
                    <td width="20%"  align="center"></td>
                </tr>
                <tr>
                    <td width="60%">Office Cost</td>
                    <td width="20%"  align="center"></td>
                    <td width="20%"  align="center"></td>
                </tr>
                <tr>
                    <td width="60%">Depreciation & Amortization Expense</td>
                    <td width="20%"  align="center"></td>
                    <td width="20%"  align="center"></td>
                </tr>
                <tr>
                    <td width="60%">Other Expense</td>
                    <td width="20%"  align="center"></td>
                    <td width="20%"  align="center"></td>
                </tr>
                <tr>
                    <td width="60%" style="font-weight: bold; border-bottom:1px solid black"><h3>Non Operating Expenses</h3></td>
                    <td width="20%"  align="center" style="border-bottom:1px solid black"></td>
                    <td width="20%"  align="center" style="border-bottom:1px solid black"></td>
                </tr>
                <tr>
                    <td width="60%">Non Operating Expenses MMF</td>
                    <td width="20%"  align="center"></td>
                    <td width="20%"  align="center"></td>
                </tr>
                <tr style="background:#add8f7;font-weight: bold;">
                    <td width="60%"><h5>Total Revenue</h5></td>
                    <td width="20%"  align="center">Amount</td>
                    <td width="20%"  align="center">Amount</td>
                </tr>
            </table>
            <table width="100%">
                <tr>
                    <td width="60%" align="right"><h3>Calculated Return</h3></td>
                    <td width="20%" align="center"><h4>Amount</h4></td>
                    <td width="20%" align="center"><h4>Amount</h4></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
