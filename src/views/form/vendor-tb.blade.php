<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>TB Supplier Report</title>
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
      margin-top: 5.7cm;
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

    #body #header-content tr td {
      border-bottom: 2px solid black;
    }

    .container {
      width: 100%;
      margin: 0 36px;
    }

    .barcode {
      margin-left: 70px;
      margin-top: 12px;
    }

    #content table .amount {
      border-top: 2px solid black;
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
            Jl. Indonesia Raya 116
            <br>
            Phone : 031-5730289 &nbsp;&nbsp;&nbsp; Fax : 031-5730289
            <br>
            Email : marketing@company.co.id
            <br>
            Website : www.company.co.id
          </td>
          <td width="50%" valign="top" align="center">
            <h1 style="font-size:18px;">SUPPLIER TRIAL BALANCE<br>
              <span style="font-size:12px;font-weight: none;">Period : {{ $start_date }} - {{ $end_date }}</span></h1>
          </td>
        </tr>
      </table>
    </div>
    <div id="body">
      <div class="container" style="margin-top:12px;">
        <table width="100%" cellpadding="3">
          <!-- <tr>
            <td width="20%" valign="top">Department</td>
            <td width="1%" valign="top">:</td>
            <td width="79%" valign="top">{{ $department ?? '-' }}</td>
          </tr>
          <tr>
            <td>Location</td>
            <td>:</td>
            <td>{{ $request->location ?? '-' }}</td>
          </tr>
          <tr> -->
            <td colspan="3"><i>All Amount in IDR</i></td>
          </tr>
        </table>
        <table width="100%" cellpadding="3" style="margin-top:12px;" id="header-content">
          <tr>
            <td width="20%" align="center"><b>Supplier Name</b></td>
            <td width="20%" align="center"><b>Beginning Balance</b></td>
            <td width="20%" align="center"><b>Debit</b></td>
            <td width="20%" align="center"><b>Credit</b></td>
            <td width="20%" align="center"><b>Ending Balance</b></td>
          </tr>
        </table>
      </div>
    </div>
  </header>

  <footer>
    <div class="container">
      <table width="100%">
        <tr>
          <td>Printed on {{ $current_date }}
          </td>
          <td align="right" valign="bottom"> <span class="page-number">Page </span></td>
        </tr>
      </table>
    </div>
    <img src="./vendor/courier/img/form/printoutfa/FooterFA-A4-Potrait.png" width="100%" alt="">
  </footer>

  <div id="content">
    <div class="container">
      <table width="100%" cellpadding="6" page-break-inside: auto;>
        @foreach ($vendor as $vendor_row)
          <tr>
            <td align="left" valign="top">{{ $vendor_row->name }}</td>
            <td align="right" valign="top">{!! $controller->fa_format('Rp', $controller->currency_format($vendor_row->begining_balance, 2), true) !!}</td>
            <td align="right" valign="top">{!! $controller->fa_format('Rp', $controller->currency_format($vendor_row->debit, 2), true) !!}</td>
            <td align="right" valign="top">{!! $controller->fa_format('Rp', $controller->currency_format($vendor_row->credit, 2), true) !!}</td>
            <td align="right" valign="top">{!! $controller->fa_format('Rp', $controller->currency_format($vendor_row->ending_balance, 2), true) !!}</td>
          </tr>
        @endforeach
        <tr>
          <td align="right" valign="top"><b>TOTAL</b></td>
          <td align="right" valign="top" class="amount"><b>{!! $controller->fa_format('Rp', $controller->currency_format($total->begining_balance, 2), true) !!}</b></td>
          <td align="right" valign="top" class="amount"><b>{!! $controller->fa_format('Rp', $controller->currency_format($total->debit, 2), true) !!}</b></td>
          <td align="right" valign="top" class="amount"><b>{!! $controller->fa_format('Rp', $controller->currency_format($total->credit, 2), true) !!}</b></td>
          <td align="right" valign="top" class="amount"><b>{!! $controller->fa_format('Rp', $controller->currency_format($total->ending_balance, 2), true) !!}</b></td>
        </tr>
      </table>
    </div>
  </div>
</body>

</html>