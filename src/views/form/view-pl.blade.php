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
        margin-top: 3.5cm;
        margin-bottom: 3cm;
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
        top: 8px;
        left: 210px;
        position: absolute;
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
        margin-bottom: 30px;
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
                        <h1 style="font-size:26px;">PROFIT & LOSS<br>
                            <span style="font-size:12px;font-weight: none;">Period
                                {{ date('d/m/Y', strtotime($beginDate)) }} -
                                {{ date('d/m/Y', strtotime($endingDate)) }}</span></h1>
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <footer>
        <table width="100%">
            <tr>
                <td> <span style="margin-left:6px;">Printed By : {{Auth::user()->name}} ;</span> </td>
            </tr>
        </table>
        <img src="./vendor/courier/img/form/trial-balance/Footer.png" width="100%" alt="">
    </footer>

    <div id="content">
        <div class="container">
            <table width="100%" cellpadding="5" >
                <tr style="background:#5f6b5e; color:white;font-weight: bold;">
                    <td width="60%">Account Name</td>
                    <td width="20%" align="right">Accumulated</td>
                    <td width="20%" align="right">Period</td>
                </tr>

                @for ($a=0; $a < count($data['pendapatan']); $a++) @php $x=$data['pendapatan'][$a]; @endphp <tr
                    style="font-weight: bold; border-bottom:1px solid black">
                    <td width="60%" style="font-weight: bold; border-bottom:1px solid black; font-size:18px">
                        {{$x->name}}
                    </td>
                    <td width="20%" align="right" style="border-bottom:1px solid black; font-size:14px">
                        {{number_format($x->CurrentBalance, 0, 0, '.')}}</td>
                    <td width="20%" align="right" style="border-bottom:1px solid black; font-size:14px">
                        {{number_format($x->EndingBalance, 0, 0, '.')}}</td>
                    </tr>
                    @for ($b=0; $b < count($x->child); $b++)
                        @php
                        $y = $x->child[$b];
                        @endphp
                        <tr>
                            <td width="60%">{{$y->name}}</td>
                            <td width="20%" align="right">{{number_format($y->CurrentBalance, 0, 0, '.')}}</td>
                            <td width="20%" align="right">{{number_format($y->EndingBalance, 0, 0, '.')}}</td>
                        </tr>
                        @endfor
                        @endfor
                        <tr>
                            <td colspan=3></td>
                        </tr>
                        <tr>
                            <td colspan=3></td>
                        </tr>
                        <tr style="background:#add8f7;font-weight: bold; font-size:14px">
                            <td width="60%">
                                Total Revenue
                            </td>
                            <td width="20%" align="right">{{number_format($pendapatan_accumulated, 0, 0, '.')}}</td>
                            <td width="20%" align="right">{{number_format($pendapatan_period, 0, 0, '.')}}</td>
                        </tr>
                        <tr>
                            <td colspan=3></td>
                        </tr>
                        <tr>
                            <td colspan=3></td>
                        </tr>
                        {{-- Biaya --}}
                        @for ($a=0; $a < count($data['biaya']); $a++) @php $x=$data['biaya'][$a]; @endphp 
                        <tr style="font-weight: bold; border-bottom:1px solid black">
                            <td width="60%" style="font-weight: bold; border-bottom:1px solid black; font-size:18px">
                                {{$x->name}}
                            </td>
                            <td width="20%" align="right" style="border-bottom:1px solid black; font-size:14px">
                                {{number_format($x->CurrentBalance, 0, 0, '.')}}</td>
                            <td width="20%" align="right" style="border-bottom:1px solid black; font-size:14px">
                                {{number_format($x->EndingBalance, 0, 0, '.')}}</td>
                        </tr>
                            @for ($b=0; $b < count($x->child); $b++)
                                @php
                                $y = $x->child[$b];
                                @endphp
                        <tr>
                            <td width="60%">{{$y->name}}</td>
                            <td width="20%" align="right">{{number_format($y->CurrentBalance, 0, 0, '.')}}</td>
                            <td width="20%" align="right">{{number_format($y->EndingBalance, 0, 0, '.')}}</td>
                        </tr>
                       
                        @endfor
                        @endfor
                        <tr>
                            <td colspan=3></td>
                        </tr>
                        <tr>
                            <td colspan=3></td>
                        </tr>
                        <tr style="background:#add8f7;font-weight: bold;font-size:14px">
                            <td width="60%">
                                Total Revenue
                            </td>
                            <td width="20%" align="right">{{number_format($biaya_accumulated, 0, 0, '.')}}</td>
                            <td width="20%" align="right">{{number_format($biaya_period, 0, 0, '.')}}</td>
                        </tr>


            </table>
            <table width="100%">


                <tr style="font-size:14px">
                    <td width="60%" align="right">
                        <h3>Calculated Return</h3>
                    </td>
                    <td width="20%" align="right">
                        <h4>{{number_format($total_accumulated, 0, 0, '.')}}</h4>
                    </td>
                    <td width="20%" align="right">
                        <h4>{{number_format($total_period, 0, 0, '.')}}</h4>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>