<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profit and Loss Report</title>
    <style>
    @page {
        margin: 0cm, 0cm;
    }

    html,
    body {
        padding: 0;
        margin: 0;
        font-size: 12px;
    }

    body {
        margin-top: 4cm;
        margin-bottom: 1cm;
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
        margin-bottom: 100px;
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
                        Jl. Indonesia Raya 116
                        <br>
                        Phone : 031-5730289 &nbsp;&nbsp;&nbsp; Fax : 031-5730289
                        <br>
                        Email : marketing@company.co.id
                        <br>
                        Website : www.company.co.id
                    </td>
                    <td width="45%" valign="top" align="center">
                        <h1 style="font-size:26px;">PROFIT & LOSS<br>
                            <span style="font-size:12px;font-weight: none;">
                              {{ date('d F y', strtotime($beginDate)) }} - {{ date('d F y', strtotime($endingDate)) }}
                            </span></h1>
                    </td>
                </tr>
            </table>
        </div>

    </header>
    <footer>
        <table width="100%">
            <tr>
              <td> <span style="margin-left:6px;">Printed By : {{Auth::user()->name}}</span> </td>
            </tr>
        </table>
        <img src="./vendor/courier/img/form/trial-balance/Footer.png" width="100%" alt="">
    </footer>

    <div id="content">
        <div class="container">
          <table width="100%" cellpadding="8">
              <tr style="background:#5f6b5e; color:white;font-weight: bold;">
                  <td width="60%">Account Name</td>
                  <td width="20%" align="center">Accumulated</td>
                  <td width="20%" align="center">Periods</td>
              </tr>

              @for ($a=0; $a < count($data['pendapatan']); $a++)
                @php
                  $x = $data['pendapatan'][$a];
                @endphp
                <tr style="font-weight: bold; border-bottom:1px solid black">
                  <td width="60%"><h3>{{$x->name}}</h3></td>
                  <td width="20%" align="center">{{number_format($x->CurrentBalance, 0, ',', '.')}}</td>
                  <td width="20%" align="center">{{number_format($x->EndingBalance, 0, ',', '.')}}</td>
                </tr>
                @for ($b=0; $b < count($x->child); $b++)
                  @php
                    $y = $x->child[$b];
                  @endphp
                  <tr>
                    <td width="60%"><h4>{{$y->name}}</h4></td>
                    <td width="20%" align="center">{{number_format($y->CurrentBalance, 0, ',', '.')}}</td>
                    <td width="20%" align="center">{{number_format($y->EndingBalance, 0, ',', '.')}}</td>
                  </tr>
                  @for ($c=0; $c < count($y->grandchild); $c++)
                    @php
                      $z = $y->grandchild[$c];
                    @endphp
                    <tr>
                      <td width="60%">{{$z->name}}</td>
                      <td width="20%" align="center">{{number_format($z->CurrentBalance, 0, ',', '.')}}</td>
                      <td width="20%" align="center">{{number_format($z->EndingBalance, 0, ',', '.')}}</td>
                    </tr>
                  @endfor
                @endfor
              @endfor

              <tr style="background:#add8f7;font-weight: bold;">
                  <td width="60%"><h5>Total Revenue</h5></td>
                  <td width="20%" align="center">{{number_format($pendapatan_accumulated, 0, ',', '.')}}</td>
                  <td width="20%" align="center">{{number_format($pendapatan_period, 0, ',', '.')}}</td>
              </tr>

              @for ($a=0; $a < count($data['biaya']); $a++)
                @php
                  $x = $data['biaya'][$a];
                @endphp
                <tr style="font-weight: bold; border-bottom:1px solid black">
                  <td width="60%"><h3>{{$x->name}}</h3></td>
                  <td width="20%" align="center">{{number_format($x->CurrentBalance, 0, ',', '.')}}</td>
                  <td width="20%" align="center">{{number_format($x->EndingBalance, 0, ',', '.')}}</td>
                </tr>
                @for ($b=0; $b < count($data['biaya'][0]->child); $b++)
                  @php
                    $y = $x->child[$b];
                  @endphp
                  <tr>
                    <td width="60%"><h4>{{$y->name}}</h4></td>
                    <td width="20%" align="center">{{number_format($y->CurrentBalance, 0, ',', '.')}}</td>
                    <td width="20%" align="center">{{number_format($y->EndingBalance, 0, ',', '.')}}</td>
                  </tr>
                  @for ($c=0; $c < count($y->grandchild); $c++)
                    @php
                      $z = $y->grandchild[$c];
                    @endphp
                    <tr>
                      <td width="60%">{{$z->name}}</td>
                      <td width="20%" align="center">{{number_format($z->CurrentBalance, 0, ',', '.')}}</td>
                      <td width="20%" align="center">{{number_format($z->EndingBalance, 0, ',', '.')}}</td>
                    </tr>
                  @endfor
                @endfor
              @endfor
              <tr style="background:#add8f7;font-weight: bold;">
                  <td width="60%"><h5>Total Revenue</h5></td>
                  <td width="20%" align="center">{{number_format($biaya_accumulated, 0, ',', '.')}}</td>
                  <td width="20%" align="center">{{number_format($biaya_period, 0, ',', '.')}}</td>
              </tr>
          </table>
        </div>
    </div>
</body>

</html>