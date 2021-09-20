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
            top:10px;
            left: 210px;
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
        <img src="./vendor/courier/img/form/printoutfa/HeaderFA-A4-Potrait.png" alt=""width="100%">
        <div id="head">
            <table width="95%">
                <tr>
                    <td width="50%" valign="middle" style="font-size:12px;line-height:15px;">
                        Jl. Indonesia Raya 116
                        <br>
                        Phone : 031-5730289 &nbsp;&nbsp;&nbsp; Fax : 031-5203618
                        <br>
                        Email : marketing@company.co.id
                        <br>
                        Website : www.company.co.id
                    </td>
                    <td width="55%" valign="top" align="center" style="padding-top:-16px">
                        <h1 style="font-size:24px;">COA<br> 
                        <span style="font-size:18px;">(Chart Of Account)</span></h1>
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <footer>
        <div class="container">
            <table width="100%">
                <tr>
                    <td>  <span style="margin-left:6px;">Created By :  ;  &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp; Printed By :  ; </span> </td>

                    <td align="right" valign="bottom"> <span class="page-number">Page </span></td>
                </tr>
            </table>
        </div>
        <img src="./vendor/courier/img/form/trial-balance/Footer.png" width="100%" alt="" >
    </footer>

    <div id="content">
        <div class="container">
            <table width="100%" cellpadding="6"  page-break-inside: auto;>
                <thead>
                    <tr style="background:#72829c;color:white;">
                        <th valign="top" align="left" width="14%">Account Code</th>
                        <th valign="top" align="left" width="16%">Account Name</th>
                        <th valign="top" align="center" width="52%">Description</th>
                        <th valign="top" align="center" width="18%">Date Created</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td valign="top" width="14%" style="border-left:  1px solid  #d4d7db;">Pr-12312</td>
                        <td valign="top" width="16%">Lorem </th>
                        <td valign="top" align="center"width="52%"><b>Header</b></td>
                        <td valign="top" align="center" width="18%" style="border-right:  1px solid  #d4d7db;">10/29/2019</td>
                    </tr>
                    @for ($i = 0; $i < 40; $i++)
                        
                    <tr>
                        <td valign="top" width="14%" style="border-left:  1px solid  #d4d7db;">Pr-12312</td>
                        <td valign="top" width="16%">Lorem </th>
                        <td valign="top" align="center"width="52%">Detail</td>
                        <td valign="top" align="center" width="18%" style="border-right:  1px solid  #d4d7db;">10/29/2019</td>
                    </tr>

                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
