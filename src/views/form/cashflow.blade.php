<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Cash Flow</title>
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
      margin-bottom: 1.6cm;
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

    ul li {
      display: inline-block;
    }

    table {
      border-collapse: collapse;
    }

    #head {
      top: 9px;
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
    <img src="./vendor/courier/img/form/printoutfa/HeaderFA-A4-Potrait.png" alt="" width="100%">
    <div id="head">
      <table width="95%">
        <tr>
          <td width="50%" valign="middle" style="font-size:12px;line-height:20px;">
            Juanda International Airport, Surabaya Indonesia
            <br>
            Phone : 031-8686482 &nbsp;&nbsp;&nbsp; Fax : 031-8686500
            <br>
            Email : marketing@ptmmf.co.id
            <br>
            Website : www.ptmmf.co.id
          </td>
          <td width="50%" valign="top" align="center">
            <h1 style="font-size:18px;">CASH FLOW<br>
              <span style="font-size:12px;font-weight: none;">Period : 01 January 2018 - 01 January 2020</span></h1>
          </td>
        </tr>
      </table>
    </div>
  </header>

  <footer>
    <div class="container">
      <table width="100%">
        <tr>
          <td>Printed on 
          </td>
          <td align="right" valign="bottom"> <span class="page-number">Page </span></td>
        </tr>
      </table>
    </div>
    <img src="./vendor/courier/img/form/printoutfa/FooterFA-A4-Potrait.png" width="100%" alt="">
  </footer>

  <div id="content">
    <div class="container">
        <table width="100%" cellpadding="5" page-break-inside: auto;>
            <tr style="background:#5f6b5e; color:white;font-weight: bold; font-size:16px">
                <td width="60%"></td>
                <td width="20%" align="center">Currency</td>
                <td width="20%" align="right">Period</td>
            </tr>
            {{-- operating activities --}}
            <tr style="font-weight: bold; border-bottom:1px solid black">
                <td  colspan="3" style="font-weight: bold; border-bottom:1px solid black; font-size:12px">
                    Cash flows from operating activities
                </td>
            </tr>
            @for ($i = 0; $i < 15; $i++)
            <tr>
                <td>Cash receipts from another account</td>
                <td align="center">IDR</td>
                <td align="right">100.000.000.000</td>
            </tr>
            @endfor
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr style="background:#add8f7;font-weight: bold;">
                <td><i>Net Cash From Opertating Activities</i></td>
                <td align="center">IDR</td>
                <td align="right">100.000.000.000.000</td>
            </tr>
            {{-- investing activities --}}
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr style="font-weight: bold; border-bottom:1px solid black">
                <td  colspan="3" style="font-weight: bold; border-bottom:1px solid black; font-size:12px">
                    Cash flows from investing activities
                </td>
            </tr>
            @for ($i = 0; $i < 3; $i++)
            <tr>
                <td>Cash receipts from another account</td>
                <td align="center">IDR</td>
                <td align="right">100.000.000.000</td>
            </tr>
            @endfor
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr style="background:#add8f7;font-weight: bold;">
                <td><i>Net Cash Used in Investing Activities</i></td>
                <td align="center">IDR</td>
                <td align="right">100.000.000.000.000</td>
            </tr>
            {{-- financing activities --}}
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr style="font-weight: bold; border-bottom:1px solid black">
                <td  colspan="3" style="font-weight: bold; border-bottom:1px solid black; font-size:12px">
                    Cash flows from financing activities
                </td>
            </tr>
            @for ($i = 0; $i < 5; $i++)
            <tr>
                <td>Cash receipts from another account</td>
                <td align="center">IDR</td>
                <td align="right">100.000.000.000</td>
            </tr>
            @endfor
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr style="background:#add8f7;font-weight: bold;">
                <td><i>Net Cash Used in Financing Activities</i></td>
                <td align="center">IDR</td>
                <td align="right">100.000.000.000.000</td>
            </tr>
             {{-- summary --}}
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr style="font-weight: bold;">
                <td><i>Surplus/Defisit</i></td>
                <td align="center">IDR</td>
                <td align="right">100.000.000.000</td>
            </tr>
            <tr style="font-weight: bold;">
                <td style="border-bottom:1px solid black;"><i>Valuation</i></td>
                <td style="border-bottom:1px solid black;"align="center">IDR</td>
                <td style="border-bottom:1px solid black;"align="right">100.000.000.000</td>
            </tr>
            <tr style="font-weight: bold;">
                <td><i>Cash at Beginning of Period</i></td>
                <td align="center">IDR</td>
                <td align="right">100.000.000.000</td>
            </tr>
            <tr style="font-weight: bold;">
                <td><i>Cash at End of Period</i></td>
                <td align="center">IDR</td>
                <td align="right">100.000.000.000</td>
            </tr>
        </table>
    </div>
  </div>
</body>

</html>