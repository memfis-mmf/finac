<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Cash Statement {{ $start_date }} - {{ $end_date }}</title>
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
      margin-top: 4.9cm;
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


    #content thead tr td {
      border-bottom: 2px solid black;
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
            <h1 style="font-size:18px;">CASH STATEMENT<br>
              <span style="font-size:12px;font-weight: none;">Period : {{ $start_date }} - {{ $end_date }}</span></h1>
          </td>
        </tr>
      </table>
    </div>
    <div id="body">
      <div class="container" style="margin-top:12px;">
        <table width="100%" cellpadding="3">
          <tr valign="top">
            <td width="15%">Account Code</td>
            <td width="1%">:</td>
            <td width="84%">{{ $account_code }}</td>
          </tr>
          <tr valign="top">
            <td>Account Name</td>
            <td>:</td>
            <td>{{ $account_name }}</td>
          </tr>
          <tr valign="top">
            <td>Currency</td>
            <td>:</td>
            <td>{{ $currency }}</td>
          </tr>
        </table>
      </div>
    </div>
  </header>

  <footer>
    <div class="container">
      <table width="100%">
        <tr>
          <td>Printed on {{ date('d/m/Y H:i:s') }}
          </td>
          <td align="right" valign="bottom"> <span class="page-number">Page </span></td>
        </tr>
      </table>
    </div>
    <img src="./vendor/courier/img/form/printoutfa/FooterFA-A4-Potrait.png" width="100%" alt="">
  </footer>

  <div id="content">
    <div class="container">
        <table width="100%" cellpadding="3" page-break-inside: auto;>
            <thead>
                <tr>
                  <td width="" align="left" valign="top" width="30px"><b>Date</b></td>
                  <td width="" align="center" valign="top"><b>Transaction No</b></td>
                  <td width="" align="center" valign="top"><b>Reference</b></td>
                  <td width="" align="center" valign="top" width="100px" ><b>Description</b></td>
                  <td width="" align="right" valign="top"><b>Debit</b></td>
                  <td width="" align="right" valign="top"><b>Credit</b></td>
                  <td width="" align="right" valign="top"><b>Balance</b></td>
                </tr>
            </thead>
            <tbody style="font-size:11px;">
              @foreach ($data as $data_row)
                <tr>
                  <td>{{ $carbon::parse($data_row->date)->format('d-m-Y') }}</td>
                  <td>{{ $data_row->number }}</td>
                  <td>{{ $data_row->ref }}</td>
                  <td>{{ $data_row->description }}</td>
                  <td style="text-align: right">{{ $data_row->debit_formated }}</td>
                  <td style="text-align: right">{{ $data_row->credit_formated }}</td>
                  <td style="text-align: right">{{ $data_row->balance_formated }}</td>
                </tr>
              @endforeach
            </tbody>
        </table>
    </div>
  </div>
</body>

</html>
