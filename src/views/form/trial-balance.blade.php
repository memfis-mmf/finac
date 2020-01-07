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

        #content2{
            width:100%;
            margin-top:155px;
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
        <img src="./vendor/courier/img/form/trial-balance/Header.png" alt=""width="100%">
        <div id="head">
            <div style="margin-right:20px;text-align:left;">
                <h1 style="font-size:24px;">TRIAL BALANCE</h1>
                <table width="90%" cellpadding="3" style="margin-left:-10px;font-size:16px;">
                    <tr>
                        <td valign="top" width="15%">Period</td>
                        <td valign="top" width="1%">:</td>
                        {{-- <td valign="top" width="84%">{{ $startDate }} - {{ $finishDate }}</td> --}}
                        <td valign="top" width="84%"></td>
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
                <tr style="background:#72829c;color:white;">
                    <th valign="top" align="left" width="14%">Account Code</th>
                    <th valign="top" align="left" width="16%">Account Name</th>
                    <th valign="top" align="center" width="16%">Beginning Balance</th>
                    <th valign="top" align="center" width="18%">Debet</th>
                    <th valign="top" align="center" width="18%">Kredit</th>
                    <th valign="top" align="center" width="18%">Ending Balance</th>
                </tr>
                    @for ($i=0; $i < count($data[0]); $i++)
                        @php
                            $x = $data[0][$i];
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
                                <th valign="top" align="center" width="18%">Debet</th>
                                <th valign="top" align="center" width="18%">Kredit</th>
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
