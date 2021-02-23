<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
            margin-bottom: 3cm;
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
            padding-bottom: 20px;
            min-height: 125px;
            background: #ccdfe8;
            margin-top:-29px;
        }

        #content2, #content4, #content3{
            margin-top:10px;
        }

        #content2 table tr td{
            border-left:  1px solid  #d4d7db;
            border-right:  1px solid  #d4d7db;
            border-top:  1px solid  #d4d7db;
            border-bottom:  1px solid  #d4d7db;
        }

        #content2 table tr td #no-border tr td{
            border: none;
        }

        .page_break {
            page-break-before: always;
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
                        <h1 style="font-size:40px;">INVOICE<br>
                            <span style="font-size:12px;font-weight: none;">INVC/YYYY/MM/000001</h1>
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <footer>
        <div class="container">
            <table width="100%">
                <tr>
                    <!-- {{-- <td><b>Form No : F02-1234</b></td> --}} -->
                    <td>  <span style="margin-left:6px;">Created By : xxx ; </span> </td>
                    <td>  <span style="margin-left:6px;">Timestamp : 2020-04-24 17:13:10 ; </span> </td>
                    <td style="text-align:right">
                        <i>
                            Original
                        </i>
                    </td>
                </tr>
            </table>
        </div>
        <img src="./vendor/courier/img/form/invoice/Footer-Invoice.png" width="100%" alt="" >
    </footer>

    <div id="content">
        <div class="container">
            <table width="100%" cellpadding="4" style="padding-top:10px">
                <tr>
                    <td valign="top" width="18%">Customer Name</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">PT. Alam Semesta</td>
                    <td valign="top" width="18%">Invoice Date</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">2020/04/12</td>
                </tr>
                <tr>
                    <td valign="top" width="18%">Address</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">
                        Jl. Merpati No.17
                    </td>
                    <td valign="top" width="18%">Quotation No.</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">
                        <span style="text-transform:uppercase">qsls/yyyy/mm/00001</span>
                    </td>
                </tr>
                <tr>
                    <td valign="top" width="18%">Phone/Fax</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">
                        031-8686482/031-8686482
                    </td>
                    <td valign="top" width="18%">Currency/Rate</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">
                        <span style="text-transform:uppercase">USD</span>/14.000
                    </td>
                </tr>
                <tr>
                    <td valign="top" width="18%">Attn</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">
                        Budi Winarto
                    </td>
                    <td valign="top" width="18%"></td>
                    <td valign="top" width="1%"></td>
                    <td valign="top" width="31%"></td>
                </tr>
            </table>
        </div>
    </div>

    <div id="content2">
        <div class="container">
            <table width="100%" cellpadding="4" page-break-inside: auto;>
                <thead>
                    <tr style="background:#49535c; color:white; text-align: center">
                        <td width="2%"><b>No</b></td>
                        <td width="15%"><b>Part Number</b></td>
                        <td width="17%"><b>Item Name</b></td>
                        <td width="2%"><b>Qty</b></td>
                        <td width="2%"><b>Unit</b></td>
                        <td width="11%"><b>Price</b></td>
                        <td width="15%"><b>Subtotal</b></td>
                        <td width="11%"><b>Disc</b></td>
                        <td width="20%"><b>Total</b></td>
                    </tr>
                </thead>
                <tbody style="font-size:10px">
                    @for ($i = 0; $i < 14; $i++)                        
                        <tr>
                            <td valign="top" align="center">1</td>
                            <td valign="top">1123123-12312</td>
                            <td valign="top">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat accusantium voluptas aliquam </td>
                            <td valign="top" align="center">12</td>
                            <td valign="top" align="center">Each</td>
                            <td valign="top" align="right" nowrap><div style="float:left;">$</div>000.000.000</td>
                            <td valign="top" align="right" nowrap><div style="float:left;">$</div>000.000.000.000</td>
                            <td valign="top" align="right" nowrap><div style="float:left;">$</div>000.000.000</td>
                            <td valign="top" align="right" nowrap><div style="float:left;">$</div>000.000.000.000</td>
                        </tr>
                    @endfor
                    <tr>
                        <td colspan="6" valign="top">
                            <b>Delivery Address :</b><br>
                            <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi adipisci voluptatum repellendus, hic nam excepturi obcaecati animi reprehenderit quibusdam architecto itaque similique veniam expedita asperiores accusamus debitis dignissimos illum veritatis.</span>
                        </td>
                        <td colspan="3" valign="top">
                            <table width="100%" id="no-border">
                                <tr>
                                    <td valign="top" width="50%">Subtotal</td>
                                    <td valign="top" width="4%">$</td>
                                    <td valign="top" align="right">000.000.000.000.000</td>
                                </tr>
                                <tr>
                                    <td valign="top" width="50%">VAT 10% (Exclude)</td>
                                    <td valign="top" width="4%">$</td>
                                    <td valign="top" align="right">000.000.000.000.000</td>
                                </tr>
                                <tr>
                                    <td valign="top" width="50%">Other Cost</td>
                                    <td valign="top" width="4%">$</td>
                                    <td valign="top" align="right">000.000.000.000.000</td>
                                </tr>
                                <tr style="font-weight: bold">
                                    <td valign="top" width="50%">Grand Total</td>
                                    <td valign="top" width="4%">$</td>
                                    <td valign="top" align="right">000.000.000.000.000.000</td>
                                </tr>
                                <tr style="font-weight: bold">
                                    <td valign="top" width="50%">Grand Total IDR</td>
                                    <td valign="top" width="4%">Rp.</td>
                                    <td valign="top" align="right">000.000.000.000.000.000</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div id="content3">
        <div class="container">
            <table width="100%">
                <tr>
                    <td>
                        <fieldset>
                            <legend style="color:#3b98f5;font-weight: bold; font-size:14px;">Bank Account Information</legend>
                            <table width="100%" cellpadding="4" style="padding-top:10px">
                                    <tr>
                                        <td valign="top" width="18%">Bank Name</td>
                                        <td valign="top" width="1%">:</td>
                                        <td valign="top" width="31%">
                                            Bank BNI
                                        </td>
                                        {{-- bank 2 --}}
                                        <td valign="top" width="18%">Bank Name</td>
                                        <td valign="top" width="1%">:</td>
                                        <td valign="top" width="31%">
                                            Bank Mandiri
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="18%">Bank Acc Name</td>
                                        <td valign="top" width="1%">:</td>
                                        <td valign="top" width="31%">PT. Merpati Maintance Facility</td>
                                        {{-- bank 2 --}}
                                        <td valign="top" width="18%">Bank Acc Name</td>
                                        <td valign="top" width="1%">:</td>
                                        <td valign="top" width="31%">PT. Merpati Maintance Facility</td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="18%">Bank Acc No.</td>
                                        <td valign="top" width="1%">:</td>
                                        <td valign="top" width="31%">12312321</td>
                                        {{-- bank 2 --}}
                                        <td valign="top" width="18%">Bank Acc No.</td>
                                        <td valign="top" width="1%">:</td>
                                        <td valign="top" width="31%">2131232321</td>
                                    </tr>
                                    <tr>
                                        <td valign="top" width="18%">Currency</td>
                                        <td valign="top" width="1%">:</td>
                                        <td valign="top" width="31%" style="text-transform:uppercase">usd</td>
                                        {{-- bank 2 --}}
                                        <td valign="top" width="18%">Currency</td>
                                        <td valign="top" width="1%">:</td>
                                        <td valign="top" width="31%" style="text-transform:uppercase">idr</td>
                                    </tr>
                                </table>
                        </fieldset>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div id="content4">
        <div class="container">
            <table width="100%">
                <tr>
                    <td width="50%" valign="top">
                        <table width="100%">
                            <tr>
                                <td><b>Term & Condition :</b></td>
                            </tr>
                            <tr>
                                <td height="40" valign="top">
                                   Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad architecto modi impedit ratione accusamus temporibus ipsa saepe commodi possimus eum similique voluptas dolores dolorum, aliquam placeat rerum reiciendis tempora atque.
                                </td>
                            </tr>
                            <tr>
                                <td><b>Remark :</b></td>
                            </tr>
                            <tr>
                                <td height="40" valign="top">
                                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Soluta quod voluptatem dolorem, quidem quibusdam ea, eveniet blanditiis quo perspiciatis odit neque sint! Perspiciatis, perferendis ipsam enim consectetur quaerat possimus vitae.
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%" valign="top">
                        <table width="100%">
                            <tr>
                                <td width="100%" valign="top" align="center">Surabaya Juni 12, 2020</td>
                            </tr>
                            <tr>
                                <td width="100%" height="60"></td>
                            </tr>
                            <tr>
                                <td width="100%" valign="top" align="center"><b>Rowin H. Mangkoesendroto</b></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
