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

    html,
    body {
        padding: 0;
        margin: 0;
        font-size: 12px;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin-top: 3cm;
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

    ul li {
        display: inline-block;
    }

    table {
        border-collapse: collapse;
    }

    #head {
        top: 4px;
        left: 220px;
        position: absolute;
        text-align: center;
    }

    .container {
        width: 100%;
        margin: 0 36px;
    }

    .barcode {
        margin-left: 70px;
        margin-top: 12px;
    }

    #content {
        width: 100%;
        margin-bottom: 34px;
    }

    .page_break {
        page-break-before: always;
    }
    </style>
</head>

<body>
<header>
        <img src="./vendor/courier/img/form/printoutfa/HeaderFA-A4-Potrait.png" alt=""width="100%">
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
                        <h1 style="font-size:26px;">BALANCE SHEET<br> 
                        <span style="font-size:12px;font-weight: none;">Period : 01 January 2020 - 28 January 2020</span></h1>
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <footer>
        <table width="100%">
            <tr>
                <td> <span style="margin-left:6px;">Printed By : generated ;</span> </td>
            </tr>
        </table>
        <img src="./vendor/courier/img/form/trial-balance/Footer.png" width="100%" alt="">
    </footer>

    <div id="content">
        <div class="container">
            <table width="100%" cellpadding="8">
                {{-- ACTIVA --}}
                <tr style="color:#244c8a;font-weight: bold;">
                    <td width="22%" colspan="3"style="font-weight: bold; font-size: 18px;">ACTIVA</td>
                </tr>
                    {{-- Current Asset --}}
                <tr style="font-weight: bold; border-bottom:1px solid black">
                    <td width="22%" colspan="3" style="font-size: 14px;">Current Asset
                    </td>
                </tr>
                <tr style="background:#5f6b5e; color:white;font-weight: bold;">
                    <td width="22%">Account Code</td>
                    <td width="48%" align="center">Account Name</td>
                    <td width="30%" align="center">Total Balance</td>
                </tr>
                <tr>
                    <td width="22%">11110000</td>
                    <td width="48%">Cash & Bank</td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000</td>
                </tr>
                <tr>
                    <td width="22%">11120000</td>
                    <td width="48%">Deposit</td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000,000</td>
                </tr>
                <tr>
                    <td width="22%">11130000</td>
                    <td width="48%">Temporary Investment</td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000,000</td>
                </tr>
                <tr>
                    <td width="22%">11140000</td>
                    <td width="48%">Account Receivables</td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000,000</td>
                </tr>
                <tr>
                    <td width="22%">11150000</td>
                    <td width="48%">Account Receivables Other</td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000,000</td>
                </tr>
                <tr>
                    <td width="22%">11160000</td>
                    <td width="48%">Inventories</td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000,000</td>
                </tr>
                <tr>
                    <td width="22%">11170000</td>
                    <td width="48%">Advance Payment</td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000,000</td>
                </tr>
                <tr>
                    <td width="22%">11180000</td>
                    <td width="48%">Prepaid Tax</td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000,000</td>
                </tr>
                <tr>
                    <td width="22%">11190000</td>
                    <td width="48%">Prepaid Expense</td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000,000</td>
                </tr>
                <tr>
                    <td width="22%">11200000</td>
                    <td width="48%">Accurued Revenue</td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000,000</td>
                </tr>
                <tr>
                    <td width="22%">11220000</td>
                    <td width="48%">Other Current Assets</td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000</td>
                </tr>
                <tr style="background:#cfcfcf;font-weight: bold;">
                    <td width="22%">Current Asset Total</td>
                    <td width="48%" align="center"></td>
                    <td width="30%" align="right" style="padding-right:20px ">9.002,000,000</td>
                </tr>
                <tr>
                    <td width="22%" colspan="3"></td>
                </tr>
                    {{-- Non Current Asset --}}
                <tr style="font-weight: bold; border-bottom:1px solid black">
                    <td width="22%" colspan="3"  style="font-size: 14px;">Non Current Asset</td>
                </tr>
                <tr style="background:#5f6b5e; color:white;font-weight: bold;">
                    <td width="22%">Account Code</td>
                    <td width="48%" align="center">Account Name</td>
                    <td width="30%" align="center">Total Balance</td>
                </tr>
                <tr>
                    <td width="22%">12210000</td>
                    <td width="48%">Fixed Asset</td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000</td>
                </tr>
                <tr>
                    <td width="22%">12220000</td>
                    <td width="48%">Long Term Invesment</td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000,000</td>
                </tr>
                <tr>
                    <td width="22%">12230000</td>
                    <td width="48%">Other Asset</td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000</td>
                </tr>
                <tr style="background:#cfcfcf;font-weight: bold;">
                    <td width="22%">Non Current Asset Total</td>
                    <td width="48%" align="center"></td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000,000</td>
                </tr>
                {{-- spasi --}}
                <tr>
                    <td width="22%" colspan="3"></td>
                </tr>
                {{-- total Activa --}}
                <tr style="background:#add8f7;font-weight: bold;">
                    <td width="22%">ASSETS TOTAL</td>
                    <td width="48%" align="center"></td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000,000,000</td>
                </tr>

                {{-- spasi --}}
                <tr>
                    <td width="22%" colspan="3"></td>
                </tr>

                {{-- PASIVA --}}
                <tr style="color:#244c8a;font-weight: bold;">
                    <td width="22%" colspan="3"style="font-weight: bold; font-size: 18px;">PASIVA</td>
                </tr>
                    {{-- Liabilities --}}
                <tr style="font-weight: bold; border-bottom:1px solid black">
                    <td width="22%" colspan="3"  style="font-size: 14px;">Liabilities</td>
                </tr>
                <tr style="background:#5f6b5e; color:white;font-weight: bold;">
                    <td width="22%">Account Code</td>
                    <td width="48%" align="center">Account Name</td>
                    <td width="30%" align="center">Total Balance</td>
                </tr>
                <tr>
                    <td width="22%">22110000</td>
                    <td width="48%">Current Liabilies</td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000</td>
                </tr>
                <tr>
                    <td width="22%">22120000</td>
                    <td width="48%">Other Current Liabilities</td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000</td>
                </tr>
                <tr>
                    <td width="22%">22130000</td>
                    <td width="48%">Long Term Liabilies</td>
                    <td width="30%" align="right"style="padding-right:20px">1.000,000</td>
                </tr>
                <tr style="background:#cfcfcf;font-weight: bold;">
                    <td width="22%">Liabilities Total</td>
                    <td width="48%" align="center"></td>
                    <td width="30%" align="right"style="padding-right:20px">3.000,000</td>
                </tr>
                <tr>
                    <td width="22%" colspan="3"></td>
                </tr>
                    {{-- Equities --}}
                <tr style="font-weight: bold; border-bottom:1px solid black">
                    <td width="22%" colspan="3"  style="font-size: 14px;">Equities</td>
                </tr>
                <tr style="background:#5f6b5e; color:white;font-weight: bold;">
                    <td width="22%">Account Code</td>
                    <td width="48%" align="center">Account Name</td>
                    <td width="30%" align="center">Total Balance</td>
                </tr>
                <tr>
                    <td width="22%">31110000</td>
                    <td width="48%">Capital</td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000</td>
                </tr>
                <tr>
                    <td width="22%">31120000</td>
                    <td width="48%">Retained Earning</td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000,000</td>
                </tr>
                <tr>
                    <td width="22%">31130000</td>
                    <td width="48%">Profit and Loss</td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000</td>
                </tr>
                <tr>
                    <td width="22%">31140000</td>
                    <td width="48%">Devident</td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000</td>
                </tr>
                <tr style="background:#cfcfcf;font-weight: bold;">
                    <td width="22%">Equities Total</td>
                    <td width="48%" align="center"></td>
                    <td width="30%" align="right"style="padding-right:20px">1.003,000,000</td>
                </tr>
                {{-- spasi --}}
                <tr>
                    <td width="22%" colspan="3"></td>
                </tr>
                {{-- total Pasiva --}}
                
               
                <tr style="background:#add8f7;font-weight: bold;">
                    <td width="70%" colspan="2">LIABILITIES & EQUITIES TOTAL</td>
                    <td width="30%" align="right" style="padding-right:20px">1.000,000,000,000</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>