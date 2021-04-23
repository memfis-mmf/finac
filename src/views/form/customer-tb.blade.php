<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>TB Customer Report</title>
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
            Juanda International Airport, Surabaya Indonesia
            <br>
            Phone : 031-8686482 &nbsp;&nbsp;&nbsp; Fax : 031-8686500
            <br>
            Email : marketing@ptmmf.co.id
            <br>
            Website : www.ptmmf.co.id
          </td>
          <td width="50%" valign="top" align="center">
            <h1 style="font-size:18px;">CUSTOMER TRIAL BALANCE<br>
              <span style="font-size:12px;font-weight: none;">Period : {{ $start_date }} - {{ $end_date }}</span></h1>
          </td>
        </tr>
      </table>
    </div>
    <div id="body">
      <div class="container" style="margin-top:12px;">
        <table width="100%" cellpadding="3">
          <!-- <tr>
            <td width="20%" valign="top">MMF Department</td>
            <td width="1%" valign="top">:</td>
            <td width="79%" valign="top">{{ $department ?? '-' }}</td>
          </tr>
          <tr>
            <td>MMF Location</td>
            <td>:</td>
            <td>{{ $request->location ?? '-' }}</td>
          </tr>
          <tr> -->
            <td colspan="3"><i>All Amount in IDR</i></td>
          </tr>
        </table>
        <table width="100%" cellpadding="3" style="margin-top:12px;" id="header-content">
          <tr>
            <td width="20%" align="center"><b>Customer Name</b></td>
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
      <table width="100%" cellpadding="6">
        @foreach ($customer as $customer_row)
          <tr>
            <td width="20%" align="left" valign="top">{{ $customer_row->name }}</td>
            <td width="20%" align="right" valign="top">Rp {{ number_format($customer_row->begining_balance, 2, ',', '.') }}</td>
            <td width="20%" align="right" valign="top">Rp {{ number_format($customer_row->debit, 2, ',', '.') }}</td>
            <td width="20%" align="right" valign="top">Rp {{ number_format($customer_row->credit, 2, ',', '.') }}</td>
            <td width="20%" align="right" valign="top">Rp {{ number_format($customer_row->ending_balance, 2, ',', '.') }}</td>
          </tr>
        @endforeach
        <tr>
          <td width="20%" align="right" valign="top"><b>TOTAL</b></td>
          <td width="20%" align="right" valign="top" class="amount"><b>Rp {{ number_format($total->begining_balance, 2, ',', '.') }}</b></td>
          <td width="20%" align="right" valign="top" class="amount"><b>Rp {{ number_format($total->debit, 2, ',', '.') }}</b></td>
          <td width="20%" align="right" valign="top" class="amount"><b>Rp {{ number_format($total->credit, 2, ',', '.') }}</b></td>
          <td width="20%" align="right" valign="top" class="amount"><b>Rp {{ number_format($total->ending_balance, 2, ',', '.') }}</b></td>
        </tr>
      </table>
    </div>
  </div>
</body>

</html>