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
            height: 1.8cm;
        }
        ul li{
            display: inline-block;
        }

        table{
            border-collapse: collapse;
        }

        #head{
            top:8px;
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
            margin-bottom:34px;
        }

        #content table tr td{
            /* border-left:  1px solid  #d4d7db;
            border-right:  1px solid  #d4d7db;
            border-top:  1px solid  #d4d7db; */
            border-bottom:  1px solid  #d4d7db;
        }

        #content2{
            width:100%;
            margin-bottom:34px;
        }

        #content2 table tr td{
            /* border-left:  1px solid  #d4d7db;
            border-right:  1px solid  #d4d7db;
            border-top:  1px solid  #d4d7db; */
            border-bottom:  1px solid  #d4d7db;
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
                        <h1 style="font-size:26px;">TRIAL BALANCE <br>
                            <span style="font-size:12px;font-weight: none;">Period : {{ $startDate }} - {{ $finishDate }}</span></h1>
                    </td>
                   
                </tr>
            </table>
           
            <!-- <div style="margin-right:20px;text-align:left;">
                <h1 style="font-size:24px;">TRIAL BALANCE</h1>
                <table width="90%" cellpadding="3" style="margin-left:-10px;font-size:16px;">
                    <tr>
                        <td valign="top" width="15%">Period</td>
                        <td valign="top" width="1%">:</td>
                        <td valign="top" width="84%">{{ $startDate }} - {{ $finishDate }}</td>
                        <td valign="top" width="84%"></td>
                    </tr>
                </table>
            </div> -->
        </div>
    </header>

    <footer>
        <table width="100%">
            <tr>
                <td>  <span style="margin-left:6px;">Printed By : {{Auth::user()->name}} ;</span> </td>
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
                    <th valign="top" align="center" width="16%">Beginning Balance</th>
                    <th valign="top" align="center" width="18%">Debit</th>
                    <th valign="top" align="center" width="18%">Credit</th>
                    <th valign="top" align="center" width="18%">Ending Balance</th>
                </tr>
                    @for ($i=0; $i < count($data[0]); $i++)
                        @php
                            $x = $data[0][$i];
                        @endphp
                        <tr>
                            <td valign="top" width="14%" style="border-left:  1px solid  #d4d7db;">{{ $x->code }}</td>
                            <td valign="top" width="16%">{{ $x->name }}</td>
                            <td valign="top" align="center" width="16%">{{ number_format($x->LastBalance, 0, 0, '.') }}</td>
                            <td valign="top" align="center" width="18%">{{ number_format($x->Debit, 0, 0, '.') }}</td>
                            <td valign="top" align="center" width="18%">{{ number_format($x->Credit, 0, 0, '.') }}</td>
                            <td valign="top" align="center" width="18%" style="border-right:  1px solid  #d4d7db;">{{ number_format($x->EndingBalance, 0, 0, '.') }}</td>
                        </tr>
                    @endfor
            </table>
        </div>
    </div>

    @if(count($data)>1)
        @for ($i = 1; $i < count($data); $i++)
            <div class="page_break">
                <div id="content2">
                    <div class="container">
                        <table width="100%" cellpadding="6">
                            <tr style="background:#72829c;color:white;">
                                <th valign="top" align="left" width="14%">Account Code</th>
                                <th valign="top" align="left" width="16%">Account Name</th>
                                <th valign="top" align="center" width="16%">Beginning Balance</th>
                                <th valign="top" align="center" width="18%">Debit</th>
                                <th valign="top" align="center" width="18%">Credit</th>
                                <th valign="top" align="center" width="18%">Ending Balance</th>
                            </tr>
														@for ($j=0; $j < count($data[$i]); $j++)
															@php
																$x = $data[$i][$j];
															@endphp
	                            <tr>
		                            <td valign="top" width="14%" style="border-left:  1px solid  #d4d7db;">{{ $x->code }}</td>
		                            <td valign="top" width="16%">{{ $x->name }}</th>
		                            <td valign="top" align="center"width="16%">{{ number_format($x->LastBalance, 0, 0, '.') }}</td>
		                            <td valign="top" align="center" width="18%">{{ number_format($x->Debit, 0, 0, '.') }}</td>
		                            <td valign="top" align="center" width="18%">{{ number_format($x->Credit, 0, 0, '.') }}</td>
		                            <td valign="top" align="center" width="18%" style="border-right:  1px solid  #d4d7db;">{{ number_format($x->EndingBalance, 0, 0, '.') }}</td>
	                            </tr>
														@endfor
                        </table>
                    </div>
                </div>
            </div>
        @endfor
    @endif

</body>
</html>
