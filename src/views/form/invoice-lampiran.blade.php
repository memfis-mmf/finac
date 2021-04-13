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
            margin-top: 4.4cm;
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
            top:20px;
            left: 510px;
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
            height: 115px;
            margin-top: -30px;
            background: #e6f2f7;
        }

        #content2{
            text-align: center;
            color: #3660e0;
            font-weight: bold;
        }

        #content3 .type-taskcard ol{
            margin: 0;
            list-style-type:lower-alpha;
        }


        #content3 table tr td{
            border-left:  1px solid  #d4d7db;
            border-right:  1px solid  #d4d7db;
            border-top:  1px solid  #d4d7db;
            border-bottom:  1px solid  #d4d7db;
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
                    <td align="right"> <span class="page-number">Page </span>  </td>
                </tr>
            </table>
        </div>
        <img src="./vendor/courier/img/form/invoice/Footer-Invoice.png" width="100%" alt="" >
    </footer>
     
    {{-- LAMPIRAN 1 --}}
    <div>
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
            <h2>WORKPACKAGE DETAILS</h2>
        </div>

        <div id="content3">
            <div class="container">
                <table width="100%" cellpadding="4" border="1">
                    <tr style="background:#49535c; color:white">
                        <td width="10%"></td>
                        <td width="90%" align="center"><b>Detail</b></td>
                    </tr>
                    <tr>
                        <td width="10%" align="center" valign="top">1</td>
                        <td width="90%" valign="top" style="line-height:20px;">
                            <b>Generate dari Job Description Quotation / WP Title :</b>
                            <br>
                            <div style="padding-left:8px;">
                                Material Need 50 item(s) <br> 
                                Total 1.200 Taskcard(s) & 1750 Manhours
                            </div>
                            <div class="type-taskcard">
                                <ol>
                                    <li>Basic Taskcard 800 item(s)</li>
                                    <li>SIP Taskcard 50 item(s)</li>
                                    <li>CPCP Taskcard 50 item(s)</li>
                                    <li>AD/SB Taskcard 50 item(s)</li>
                                    <li>CMR/AWL Taskcard 50 item(s)</li>
                                    <li>EO Taskcard 50 item(s)</li>
                                    <li>EA Taskcard 50 item(s)</li>
                                    <li>SI Taskcard 50 item(s)</li>
                                    <li>Hard time Taskcard 50 item(s)</li>
                                </ol>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div id="content4">
            <div class="container">
                <table width="100%" cellpadding="4" border="1" page-break-inside: auto;>
                    <thead>
                        <tr style="background:#ffdcc2;">
                            <td align="center" width="5%">No</td>
                            <td align="center" width="20%">Part Number</td>
                            <td align="center" width="50%">Item Name</td>
                            <td align="center" width="12%">Qty</td>
                            <td align="center" width="13%">Unit</td>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i < 45; $i++)
                            <tr>
                                <td align="center" valign="top" width="5%">1</td>
                                <td align="center" valign="top" width="20%">generate</td>
                                <td valign="top" width="50%">Lorem ipsum dolor, </td>
                                <td align="center" valign="top" width="12%">123</td>
                                <td align="center" valign="top" width="13%">generate</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    {{-- LAMPIRAN 2 --}}
    <div>
        <div class="page_break">
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
            <div id="content3" style="margin-top:20px">
                <div class="container">
                    <table width="100%" cellpadding="4" border="1">
                        <tr style="background:#49535c; color:white">
                            <td width="10%"></td>
                            <td width="90%" align="center"><b>Detail</b></td>
                        </tr>
                        <tr>
                            <td width="10%" align="center" valign="top">2</td>
                            <td width="90%" valign="top" style="line-height:20px;">
                                <b>Generate dari Job Description Quotation / WP Title :</b>
                                <br>
                                <div style="padding-left:8px;">
                                    Material Need 50 item(s) <br> 
                                    Total 1.200 Taskcard(s) & 1750 Manhours
                                </div>
                                <div class="type-taskcard">
                                    <ol>
                                        <li>Basic Taskcard 800 item(s)</li>
                                        <li>CPCP Taskcard 50 item(s)</li>
                                        <li>AD/SB Taskcard 50 item(s)</li>
                                        <li>EO Taskcard 50 item(s)</li>
                                    </ol>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div id="content4">
                <div class="container">
                    <table width="100%" cellpadding="4" border="1"  page-break-inside: auto;>
                        <thead>
                            <tr style="background:#ffdcc2;">
                                <td align="center" width="5%">No</td>
                                <td align="center" width="20%">Part Number</td>
                                <td align="center" width="50%">Item Name</td>
                                <td align="center" width="12%">Qty</td>
                                <td align="center" width="13%">Unit</td>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 1; $i < 120; $i++)
                                <tr>
                                    <td align="center" valign="top" width="5%">1</td>
                                    <td align="center" valign="top" width="20%">generate</td>
                                    <td valign="top" width="50%">Lorem ipsum dolor, </td>
                                    <td align="center" valign="top" width="12%">123</td>
                                    <td align="center" valign="top" width="13%">generate</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        <div>
    </div>
</body>
</html>
