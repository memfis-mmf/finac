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
        margin-top: 3cm;
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

    ul li {
        display: inline-block;
    }

    table {
        border-collapse: collapse;
    }

    #head {
        top: 4px;
        left: 220px;
        position: absolute;
        text-align: center;
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
        margin-bottom: 34px;
    }

    .page_break {
        page-break-before: always;
    }
    </style>
</head>

<body>
<header>
        <img src="./vendor/courier/img/form/printoutfa/HeaderFA-A4-Potrait.png" alt=""width="100%">
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
                        <h1 style="font-size:26px;">BALANCE SHEET<br> 
                        <span style="font-size:12px;font-weight: none;">Period : {{date('d M Y', strtotime($beginDate))}} - {{date('d M Y', strtotime($endingDate))}} </span></h1>
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <footer>
        <table width="100%">
            <tr>
                <td> <span style="margin-left:6px;">Printed By : {{ Auth::user()->name }} ;</span> </td>
            </tr>
        </table>
        <img src="./vendor/courier/img/form/trial-balance/Footer.png" width="100%" alt="">
    </footer>

    <div id="content">
        <div class="container">
            <table width="100%" cellpadding="8">
                <tr>
                    <td width="18%" colspan="3"></td>
                </tr>
                <tr>
                    <td width="18%" colspan="3"></td>
                </tr>
                {{-- Activa --}}
                <tr style="color:blue;font-weight: bold;">
                    <td width="18%" colspan="3"><h3>ACTIVA</h3></td>
                </tr>
                @for ($index_activa=0; $index_activa < count($data['activa']); $index_activa++)
                    <tr style="background:#5f6b5e; color:white;font-weight: bold;">
                        <td width="18%">Account Code</td>
                        <td width="52%" align="center">Account Name</td>
                        <td width="30%" align="center">Total Balance</td>
                    </tr>
                    {{-- spasi --}}
                    @php
                        $arr = $data['activa'][$index_activa];
                    @endphp
                    <tr style="font-weight: bold; border-bottom:1px solid black">
                        <td width="18%" colspan="3"><h3>{{$arr->name}}</h3></td>
                    </tr>
                    @for ($index_child=0; $index_child < count($arr->child); $index_child++)
                        @php
                            $arr2 = $arr->child[$index_child];
                        @endphp
                        <tr>
                            <td width="18%">{{$arr2->code}}</td>
                            <td width="52%">{{$arr2->name}}</td>
                            <td width="30%" align="center">{{number_format($arr2->CurrentBalance, '0', '0', '.')}}</td>
                        </tr>
                                                        @endfor
                        <tr style="background:#cfcfcf;font-weight: bold;">
                            <td width="38%"><h5>Total {{$arr->name}}</h5></td>
                            <td width="32%" align="center"></td>
                            <td width="30%" align="center">{{number_format($arr->total, '0', '0', '.')}}</td>
                        </tr>
                    @endfor
                    {{-- spasi --}}
                    <tr>
                        <td width="18%" colspan="3"></td>
                    </tr>
                    <tr>
                        <td width="18%" colspan="3"></td>
                    </tr>
                    {{-- total Activa --}}
                    <tr style="background:#add8f7;font-weight: bold;">
                        <td width="18%"><h5>Total Assets</h5></td>
                        <td width="52%" align="center"></td>
                        <td width="30%" align="center">{{number_format($totalActiva, 0, 0, '.')}}</td>
                    </tr>

                    {{-- spasi --}}
                    <tr>
                        <td width="18%" colspan="3"></td>
                    </tr>
                    <tr>
                        <td width="18%" colspan="3"></td>
                    </tr>

                    {{-- Pasiva --}}
                    <tr style="color:blue;font-weight: bold;">
                        <td width="18%" colspan="3"><h3>PASIVA & EQUITY</h3></td>
                    </tr>
                    @for ($index_activa=0; $index_activa < count($data['pasiva']); $index_activa++)
                        <tr style="background:#5f6b5e; color:white;font-weight: bold;">
                            <td width="18%">Account Code</td>
                            <td width="52%" align="center">Account Name</td>
                            <td width="30%" align="center">Total Balance</td>
                        </tr>
                        @php
                            $arr = $data['pasiva'][$index_activa];
                        @endphp
                        <tr style="font-weight: bold; border-bottom:1px solid black">
                            <td width="18%" colspan="3"><h3>{{$arr->name}}</h3></td>
                        </tr>
                        @for ($index_child=0; $index_child < count($arr->child); $index_child++)
                            @php
                                $arr2 = $arr->child[$index_child];
                            @endphp
                            <tr>
                                <td width="18%">{{$arr2->code}}</td>
                                <td width="52%">{{$arr2->name}}</td>
                                <td width="30%" align="center">{{number_format($arr2->CurrentBalance, '0', '0', '.')}}</td>
                            </tr>
                    @endfor
                    <tr style="background:#cfcfcf;font-weight: bold;">
                        <td width="18%"><h5>Total {{$arr->name}}</h5></td>
                        <td width="52%" align="center"></td>
                        <td width="30%" align="center">{{number_format($arr->total, '0', '0', '.')}}</td>
                    </tr>
                @endfor
                {{-- spasi --}}
                <tr>
                    <td width="18%" colspan="3"></td>
                </tr>
                <tr>
                    <td width="18%" colspan="3"></td>
                </tr>
                {{-- total Activa --}}
                <tr style="background:#add8f7;font-weight: bold;">
                    <td width="18%"><h5>Total Liabilitie & Equities</h5></td>
                    <td width="52%" align="center"></td>
                    <td width="30%" align="center">{{number_format($totalPasiva, 0, 0, '.')}}</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>