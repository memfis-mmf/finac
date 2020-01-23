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
            margin-top:135px;
            height: 115px;
            background: #ccdfe8;
        }

        #content2{
            margin-top:10px;
        }
        
        #content2 table tr td{
            border-left:  1px solid  #d4d7db;
            border-right:  1px solid  #d4d7db;
            border-top:  1px solid  #d4d7db;
            border-bottom:  1px solid  #d4d7db;
        }


        .page_break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <header>
        <img src="./vendor/courier/img/form/invoice/Header.png" alt=""width="100%">
        <div id="head">
            <div style="margin-right:20px;text-align:center;">
                <h3 style="font-size:40px;">INVOICE <br> <span style="font-size:12px;">INVC/2019/09/000001</span></h3>
            </div>
        </div>
    </header>

    <footer>
        <div class="container">
            <table width="100%">
                <tr>
                    <td><b>Form No : F02-1234</b></td>
                </tr>
            </table>
        </div>
        <img src="./vendor/courier/img/form/invoice/Footer.png" width="100%" alt="" >
    </footer>
     
    <div id="content">
        <div class="container">
            <table width="100%" cellpadding="4" style="padding-top:10px">
                <tr>
                    <td valign="top" width="18%">Customer Name</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">PT. Sarana Mendulang Arta</td>
                    <td valign="top" width="18%">Invoice Date</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">20/09/2019</td>
                </tr>
                <tr>
                    <td valign="top" width="18%">Address</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">Jl Raya Juanda 16 Betro</td>
                    <td valign="top" width="18%">Quotation No.</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">QPRO/2019/09/00005</td>
                </tr>
                <tr>
                    <td valign="top" width="18%">Phone</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">031-1232321</td>
                    <td valign="top" width="18%">Currency</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">USD</td>
                </tr>
                <tr>
                    <td valign="top" width="18%">Attn</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">Yemima</td>
                    <td valign="top" width="18%">Rate</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">Rp. 12.500</td>
                </tr>
            </table>
        </div>
    </div>

    <div id="content2">
        <div class="container">
            <table width="100%" cellpadding="4" border="1">
                <tr style="background:#49535c; color:white">
                    <td width="10%"></td>
                    <td width="65%" align="center" colspan="2"><b>Detail</b></td>
                    <td width="23%" align="center" colspan="2"><b>Amount</b></td>
                </tr>
                <tr>
                    <td colspan="5" height="20">
                       <span style="font-size: 14px; font-weight: bold;padding:15px">Subject : Generated dari Quotation Subject/Title</span>
                    </td>
                </tr>
                <tr>
                    <td width="10%" rowspan="3" align="center" valign="top">1</td>

                    <td width="65%" valign="top" style="border-bottom:none" colspan="2"><b>Generated dari job Description Quotation / WP Title :</b></td>

                    <td width="1%" style="border-right:none;border-bottom:none;"></td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;border-bottom:none; padding-right:8px;"></td>
                </tr>
                <tr>
                    <td width="65%" valign="top" style="border-top:none; border-bottom:none;padding-left:12px;" colspan="2">Total 1.200 Taskcard(s) & 1750 Manhours</td>

                    <td width="1%" style="border-bottom:none;border-right:none;border-top:none">USD</td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;border-top:none;border-bottom:none; padding-right:8px;">12.000.000,00</td>
                </tr>
                <tr>
                    <td width="65%" valign="top" style="border-top:none;padding-left:12px;" colspan="2">Material Need 50 Item(s)</td>

                    <td width="1%" style="border-right:none;border-top:none">USD</td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;border-top:none; padding-right:8px;">12.000.000</td>
                </tr>
                {{-- BreakPoint --}}
                <tr>
                    <td width="10%" rowspan="3" align="center" valign="top">2</td>

                    <td width="65%" valign="top" style="border-bottom:none" colspan="2"><b>Generated dari job Description Quotation / WP Title :</b></td>

                    <td width="1%" style="border-right:none;border-bottom:none;"></td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;border-bottom:none; padding-right:8px;"></td>
                </tr>
                <tr>
                    <td width="65%" valign="top" style="border-top:none; border-bottom:none;padding-left:12px;" colspan="2">Total 1.200 Taskcard(s) & 1750 Manhours</td>

                    <td width="1%" style="border-bottom:none;border-right:none;border-top:none">USD</td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;border-top:none;border-bottom:none; padding-right:8px;">12.000.000,00</td>
                </tr>
                <tr>
                    <td width="65%" valign="top" style="border-top:none;padding-left:12px;" colspan="2">Material Need 50 Item(s)</td>

                    <td width="1%" style="border-right:none;border-top:none">USD</td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;border-top:none; padding-right:8px;">12.000.000</td>
                </tr>
                {{-- Others&Disc --}}
                <tr>
                    <td width="10%" align="center" valign="top"></td>

                    <td width="65%" valign="top" style="padding-left:12px;" colspan="2">Others</td>

                    <td width="1%" style="border-right:none;">USD</td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;padding-right:8px;">100.000</td>
                </tr>
                <tr>
                    <td width="10%" align="center" valign="top"></td>

                    <td width="65%" valign="top" style="padding-left:12px;" colspan="2">Disc</td>

                    <td width="1%" style="border-right:none;">USD</td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;padding-right:8px;">{100.000}</td>
                </tr>
                 {{-- TheOthers --}}
                <tr>
                    <td width="10%" rowspan="4" align="center" valign="top"></td>

                    <td width="35%" style="border-bottom:none;color:red;border-right:none;"></td>

                    <td width="30%" valign="top" style="border-bottom:none;border-left:none;">
                        {{-- jika scheduled payment 1x --}}
                        @if(1==1)
                            Sub Total
                        @else
                            {{-- jika scheduled payment lebih dari 2x --}}
                            <span style="color:red;"><b>DUE PAYMENT AMOUNT</b></span>
                        @endif
                    </td>

                    <td width="1%" style="border-right:none;border-bottom:none;">USD</td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;border-bottom:none; padding-right:8px;">12.232.123</td>
                </tr>
                <tr>
                    <td width="35%" style="border-top:none; border-bottom:none;border-right:none;"></td>

                    <td width="30%" valign="top" style="border-top:none; border-bottom:none;border-left:none;">PPN 10% (included)</td>
                    
                    <td width="1%" style="border-bottom:none;border-right:none;border-top:none">USD</td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;border-top:none;border-bottom:none; padding-right:8px;">12.00</td>
                </tr>
                <tr>
                    <td width="35%" style="border-top:none;border-bottom:none;border-right:none;"></td>

                    <td width="30%" valign="top" style="border-top:none;border-bottom:none;border-left:none;"><b>Total in USD</b></td>
                   
                    <td width="1%" style="border-right:none;border-bottom:none;border-top:none"><b>USD</b></td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;border-top:none;border-bottom:none; padding-right:8px;"><b>12.000.000</b></td>
                </tr>
                <tr>
                    <td width="35%" style="border-top:none;border-right:none;"></td>

                    <td width="30%" valign="top" style="border-top:none;border-left:none;"><b>Total in IDR</b></td>
                    
                    <td width="1%" style="border-right:none;border-top:none"><b>IDR</b></td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;border-top:none; padding-right:8px;"><b>375.321.932.321</b></td>
                </tr>
                {{-- Terbilang --}}
                <tr>
                    <td colspan="5" align="center" valign="top" style="color:#134678"><b><i>THIRTY THOUSAND DOLLARS</i></b></td>
                </tr>
            </table>
        </div>
    </div>

    <div id="content3">
        <div class="container">
            <fieldset>
                <legend style="color:#3b98f5;font-weight: bold; font-size:14px;">Bank Account Information</legend>
                <table width="100%" cellpadding="4" style="padding-top:10px">
                        <tr>
                            <td valign="top" width="18%">Bank Name</td>
                            <td valign="top" width="1%">:</td>
                            <td valign="top" width="31%">Bank BNI Graha Pengeran</td>
                            <td valign="top" width="18%">Bank Name</td>
                            <td valign="top" width="1%">:</td>
                            <td valign="top" width="31%">Bank BNI Graha Pengeran</td>
                        </tr>
                        <tr>
                            <td valign="top" width="18%">Bank Account Name</td>
                            <td valign="top" width="1%">:</td>
                            <td valign="top" width="31%">PT. Merpaty Maintance Facility</td>
                            <td valign="top" width="18%">Bank Account Name</td>
                            <td valign="top" width="1%">:</td>
                            <td valign="top" width="31%">PT. Merpaty Maintance Facility</td>
                        </tr>
                        <tr>
                            <td valign="top" width="18%">Bank Account Number</td>
                            <td valign="top" width="1%">:</td>
                            <td valign="top" width="31%">888123232</td>
                            <td valign="top" width="18%">Bank Account Number</td>
                            <td valign="top" width="1%">:</td>
                            <td valign="top" width="31%">888123232</td>
                        </tr>
                        <tr>
                            <td valign="top" width="18%">Currency</td>
                            <td valign="top" width="1%">:</td>
                            <td valign="top" width="31%">IDR</td>
                            <td valign="top" width="18%">Currency</td>
                            <td valign="top" width="1%">:</td>
                            <td valign="top" width="31%">IDR</td>
                        </tr>
                        <tr>
                            <td valign="top" width="18%"></td>
                            <td valign="top" width="1%"></td>
                            <td valign="top" width="31%"></td>
                            <td valign="top" width="18%">Swift Code</td>
                            <td valign="top" width="1%">:</td>
                            <td valign="top" width="31%">BNNIDIAXXX</td>
                        </tr>
                    </table>
            </fieldset>
        </div>
    </div>

    <div id="content4">
        <div class="container">
            <table width="100%" cellpadding="4">
                <tr>
                    <td colspan="2"><b>Term & Condition :</b></td>
                </tr>
                <tr>
                    <td width="60%" height="70" valign="top">
                        <i>PAYMENT SHOULD BE RECEIVED IN FULL AMOUNT</i>
                    </td>
                    <td width="40%" valign="top" align="center">Sidoarjo, Sept 20, 2020</td>
                </tr>
                <tr>
                    <td width="60%"><b>Remark :</b></td>
                    <td width="40%"></td>
                </tr>
                <tr>
                    <td width="60%" height="60" valign="top">
                        <i>Generated</i>
                    </td>
                    <td width="40%" valign="top" align="center"><b>Generated Position User Approve<br>Generated User Name Approve</b></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
