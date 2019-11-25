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

        #content table tr td{
            /* border-left:  1px solid  #d4d7db;
            border-right:  1px solid  #d4d7db;
            border-top:  1px solid  #d4d7db; */
            border-bottom:  1px solid  #d4d7db;
        }

    </style>
</head>
<body>
    <header>
        <img src="./vendor/courier/img/form/trial-balance/Header.png" alt=""width="100%">
        <div id="head">
            <div style="margin-right:20px;text-align:center;">
                <h1 style="font-size:24px;">COA <br> (Chart Of Account)</h1>
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
            <table width="100%" cellpadding="6">
                <tr style="background:#72829c;color:white;">
                    <th valign="top" align="left" width="14%">Account Code</th>
                    <th valign="top" align="left" width="16%">Account Name</th>
                    <th valign="top" align="center" width="52%">Description</th>
                    <th valign="top" align="center" width="18%">Date Created</th>
                </tr>
                <tr>
                    <td valign="top" width="14%" style="border-left:  1px solid  #d4d7db;">Pr-12312</td>
                    <td valign="top" width="16%">Lorem </th>
                    <td valign="top" align="center"width="52%"><b>Header</b></td>
                    <td valign="top" align="center" width="18%" style="border-right:  1px solid  #d4d7db;">10/29/2019</td>
                </tr>
                <tr>
                    <td valign="top" width="14%" style="border-left:  1px solid  #d4d7db;">Pr-12312</td>
                    <td valign="top" width="16%">Lorem </th>
                    <td valign="top" align="center"width="52%">Detail</td>
                    <td valign="top" align="center" width="18%" style="border-right:  1px solid  #d4d7db;">10/29/2019</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
