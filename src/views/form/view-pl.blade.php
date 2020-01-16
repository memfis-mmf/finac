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
                <h4>Date Period {{ date('d/m/Y', strtotime($beginDate)) }} - {{ date('d/m/Y', strtotime($endingDate)) }}</h4>
            </div>
        </div>
    </header>

    <footer>
        <table width="100%">
            <tr>
                <td>  <span style="margin-left:6px;">Printed By : {{Auth::user()->name}}  ;</span> </td>
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

								@for ($a=0; $a < count($data['pendapatan']); $a++)
									@php
										$x = $data['pendapatan'][$a];
									@endphp
                  <tr style="font-weight: bold; border-bottom:1px solid black">
                    <td width="60%" style="font-weight: bold; border-bottom:1px solid black"><h3>{{$x->name}}</h3></td>
                    <td width="20%"  align="center" style="border-bottom:1px solid black">{{number_format($x->CurrentBalance, 0, 0, '.')}}</td>
                    <td width="20%"  align="center"  style="border-bottom:1px solid black">{{number_format($x->EndingBalance, 0, 0, '.')}}</td>
                  </tr>
									@for ($b=0; $b < count($x->child); $b++)
										@php
											$y = $x->child[$b];
										@endphp
                    <tr>
	                    <td width="60%">{{$y->name}}</td>
	                    <td width="20%"  align="center">{{number_format($y->CurrentBalance, 0, 0, '.')}}</td>
	                    <td width="20%"  align="center">{{number_format($y->EndingBalance, 0, 0, '.')}}</td>
                    </tr>
									@endfor
								@endfor

                <tr style="background:#add8f7;font-weight: bold;">
                    <td width="60%"><h5>Total Revenue</h5></td>
                    <td width="20%"  align="center">{{number_format($pendapatan_accumulated, 0, 0, '.')}}</td>
                    <td width="20%"  align="center">{{number_format($pendapatan_period, 0, 0, '.')}}</td>
                </tr>

								{{-- Biaya --}}
								@for ($a=0; $a < count($data['biaya']); $a++)
									@php
										$x = $data['biaya'][$a];
									@endphp
                  <tr style="font-weight: bold; border-bottom:1px solid black">
                    <td width="60%" style="font-weight: bold; border-bottom:1px solid black"><h3>{{$x->name}}</h3></td>
                    <td width="20%"  align="center" style="border-bottom:1px solid black">{{number_format($x->CurrentBalance, 0, 0, '.')}}</td>
                    <td width="20%"  align="center" style="border-bottom:1px solid black">{{number_format($x->EndingBalance, 0, 0, '.')}}</td>
                  </tr>
									@for ($b=0; $b < count($x->child); $b++)
										@php
											$y = $x->child[$b];
										@endphp
                    <tr>
	                    <td width="60%">{{$y->name}}</td>
	                    <td width="20%"  align="center">{{number_format($y->CurrentBalance, 0, 0, '.')}}</td>
	                    <td width="20%"  align="center">{{number_format($y->EndingBalance, 0, 0, '.')}}</td>
                    </tr>
									@endfor
								@endfor
                <tr style="background:#add8f7;font-weight: bold;">
                    <td width="60%"><h5>Total Revenue</h5></td>
                    <td width="20%"  align="center">{{number_format($biaya_accumulated, 0, 0, '.')}}</td>
                    <td width="20%"  align="center">{{number_format($biaya_period, 0, 0, '.')}}</td>
                </tr>
            </table>
            <table width="100%">
                <tr>
                    <td width="60%" align="right"><h3>Calculated Return</h3></td>
                    <td width="20%" align="center"><h4>{{number_format($total_accumulated, 0, 0, '.')}}</h4></td>
                    <td width="20%" align="center"><h4>{{number_format($total_period, 0, 0, '.')}}</h4></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
