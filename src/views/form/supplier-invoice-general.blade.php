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
            font-size: 11px;
        }

        body{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin-top: 2.3cm;
            margin-bottom: 1cm;
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
        ul li{
            display: inline-block;
        }

        table{
            border-collapse: collapse;
        }

        #head{
            top:-3px;
            left: 150px;
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

        #content2, #content3, #content4{
            margin-top:12px;
        }

        #content2 table thead{
            border-bottom: 2px solid grey;
        }

        #content2 table tbody{
            border-bottom: 2px solid grey;
        }

        #content3 .body{
            border:1px solid #d4d7db;
            width:95%;
            min-height:80px;
            border-radius:10px;
            padding:6px;
        }

        #content4{
            font-size: 9px;
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
                    <td width="55%" valign="middle" style="font-size:9px;">
                        Juanda International Airport, Surabaya Indonesia
                        <br>
                        Phone : 031-8686482 &nbsp;&nbsp;&nbsp; Fax : 031-8686500
                        <br>
                        Email : marketing@ptmmf.co.id
                        <br>
                        Website : www.ptmmf.co.id
                    </td>
                    <td width="45%" valign="top" align="center">
                        <h1 style="font-size:24px;">OFFICIAL RECEIPT</h1>
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
            <table width="100%">
                <tr>
                    <td width="60%"  valign="top">
                        <table width="100%%" cellpadding="4">
                            <tr>
                                <td width="25%" valign="top"><b>Received From</b></td>
                                <td width="1%" valign="top">:</td>
                                <td width="74%" valign="top">
                                    {{$header->vendor->name}}<br>
                                    {{
                                      (@$header->vendor->addresses->first())? @$header->vendor->addresses->first()->address: '-'
                                    }}<br>
                                    Phone : {{
                                      (@$header->vendor->phones->first())? @$header->vendor->phones->first()->number: '-'
                                    }}<br>
                                    Fax : {{
                                      (@$header->vendor->faxes->first())? @$header->vendor->faxes->first()->number: '-'
                                    }}<br>
                                    Email : {{
                                      (@$header->vendor->emails->first()->address)? @$header->vendor->emails->first()->address: '-'
                                    }}

                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="40%" valign="top">
                        <table width="100%%">
                            <tr>
                                <td width="40%" valign="top"><b>Receipt No.</b></td>
                                <td width="1%" valign="top">:</td>
                                <td width="59%" valign="top">SITR-YYYY/MM/00001</td>
                            </tr>
                            <tr>
                                <td width="40%" valign="top"><b>Date</b></td>
                                <td width="1%" valign="top">:</td>
                                <td width="59%" valign="top">16/02/1220</td>
                            </tr>
                            <tr>
                                <td width="40%" valign="top"><b>Term of Payment</b></td>
                                <td width="1%" valign="top">:</td>
                                <td width="59%" valign="top">30 Days</td>
                            </tr>
                            <tr>
                                <td width="40%" valign="top"><b>Due Date</b></td>
                                <td width="1%" valign="top">:</td>
                                <td width="59%" valign="top">Noted TW</td>
                            </tr>
                            <tr>
                                <td width="40%" valign="top"><b>Currency</b></td>
                                <td width="1%" valign="top">:</td>
                                <td width="59%" valign="top">IDR</td>
                            </tr>
                            <tr>
                                <td width="40%" valign="top"><b>Rate</b></td>
                                <td width="1%" valign="top">:</td>
                                <td width="59%" valign="top">1</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div id="content2">
        <div class="container">
            <table width="100%" cellpadding="4" page-break-inside: auto;>
                <thead>
                    <tr>
                        <th valign="top" align="center" width="20%">Account Code</th>
                        <th valign="top" align="center" width="20%">Account Name</th>
                        <th valign="top" align="center" width="30%">Description</th>
                        <th valign="top" align="center" width="30%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 4; $i++)
                    <tr>
                        <td valign="top" align="center" width="20%">Ambil dari Account Code</td>
                        <td valign="top" align="center" width="20%">Ambil dari Account Name</td>
                        <td valign="top" align="center" width="30%">Ambil dari Description</td>
                        <td valign="top" align="right" width="30%">720.000.000.000.000,00</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

    <div id="content3">
        <div class="container">
            <table width="100%">
                <tr>
                    <td width="60%" valign="top">
                        <div class="body">
                            <table width="100%">
                                <tr>
                                    <td width="10%" valign="top"><b>Remark</b></td>
                                    <td width="1%" valign="top">:</td>
                                    <td width="89%" valign="top">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Rerum, consequuntur molestias nisi corporis eum minus expedita tenetur fugiat quod similique qui mollitia. Laboriosam ullam ipsum ex, architecto neque blanditiis consequuntur?</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td width="40%" valign="top">
                        <table width="100%">
                            <tr>
                                <td width="40%" valign="top"><b>GRAND TOTAL</b></td>
                                <td width="60%" valign="top" align="right"><b>720.720.000.000.000,00</b></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div id="content4">
        <div class="container">
            <table width="40%">
                <tr>
                    <td>
                        <table width="70%">
                            <tr>
                                <td align="center"><b>Authorized Signature,</b></td>
                            </tr>
                            <tr>
                                <td height="30"></td>
                            </tr>
                            <tr>
                                <td align="center">
                                    User Name Approved SI
                                    <hr>
                                    Department User
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</body>
</html>
