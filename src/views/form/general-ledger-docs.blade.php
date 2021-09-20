<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>General Ledger</title>
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
      margin-top: 3.6cm;
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

    #content .transaction tbody {
      border-right: 1px solid #d4d7db;
      border-left: 1px solid #d4d7db;
      border-bottom: 1px solid #d4d7db;
    }

    #content .transaction tbody tr td {
      border-bottom: 1px solid #d4d7db;
    }

    .transaction {
      margin-top: 12px;
    }

    .accountcode {
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
    <img src="./vendor/courier/img/form/printoutfa/HeaderFA-A4-Landscape.png" alt="" width="100%">
    <div id="head">
      <table width="95%">
        <tr>
          <td width="55%" valign="middle" style="font-size:14px;line-height:20px;">
            Juanda International Airport, Surabaya Indonesia
            <br>
            Phone : 031-8686482 &nbsp;&nbsp;&nbsp; Fax : 031-8686500
            <br>
            Email : marketing@ptmmf.co.id
            <br>
            Website : www.ptmmf.co.id
          </td>
          <td width="45%" valign="top" align="center">
            <h1 style="font-size:26px;">GENERAL LEDGER<br>
              <span style="font-size:15px;font-weight: none;">Period : 01 January 2020 - 28 January 2020</span></h1>
          </td>
        </tr>
      </table>
    </div>
  </header>

  <footer>
    <div class="container">
      <table width="100%">
        <tr>
          <td>Printed on 26 January 2020 18:53
          </td>
          <td align="right" valign="bottom"> <span class="page-number">Page </span></td>
        </tr>
      </table>
    </div>
    <img src="./vendor/courier/img/form/printoutfa/FooterFA-A4-Landscape.png" width="100%" alt="">
  </footer>

  <div id="content">
    <div class="container">
      @foreach ($data as $items)
      @if (! isset($items['data'][0]->AccountCode))
        @php
          continue;
        @endphp
      @endif
      <table class="accountcode" width="100%" style="font-size:14px;">
        <tr>
          <td width="9%">Account Code</td>
          <td width="1%">:</td>
          <td width="90%">{{$items['data'][0]->AccountCode}} - <span> {{$items['data'][0]->Name}}</span> </td>
        </tr>
      </table>
      <table class="transaction" width="100%" cellpadding="6" page-break-inside: auto;>
        <thead>
          <tr style="background:#72829c;color:white;">
            <th>No</th>
            <th>Date</th>
            <th>Transaction No.</th>
            <th>Ref. No.</th>
            <th>Description</th>
            <th>Currency</th>
            <th>Amount Total</th>
            <th>Rate</th>
            <th>Debit (IDR)</th>
            <th>Credit (IDR)</th>
            <th>Ending Balance (IDR)</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($items['data'] as $index => $item)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $carbon::parse($item->TransactionDate)->format('d/m/Y') }}</td>
            <td>{!!$item->voucher_linked!!}</td>
            <td>{{$item->RefNo}}</td>
            <td>{{$item->description_formated}}</td>
            <td>{{ strtoupper($item->currency->code) }}</td>
            <td style="text-align: right"> {{ "{$controller->currency_format((($item->Debit != 0)? $item->Debit: $item->Credit) / $item->rate, 2)}" }} </td>
            <td>{!! $controller->fa_format('Rp', $controller->currency_format($item->rate, 2)) !!}</td>
            <td>{!! $controller->fa_format('Rp', $controller->currency_format($item->Debit, 2)) !!}</td>
            <td>{!! $controller->fa_format('Rp', $controller->currency_format($item->Credit, 2)) !!}</td>
            <td>{!! $controller->fa_format('Rp', $controller->currency_format($item->endingBalance, 2)) !!}</td>
          </tr>
          @endforeach
          <tr>
            <td colspan="11">
              <table>
                @foreach ($items['total']['local'] as $total_local_index => $total_local_row)
                <tr>
                  <td style="width: 1px; white-space: nowrap">Total {{ $total_local_index }}</td>
                  <td style="width: 1px">:</td>
                  <td style="width: 1px; ">Rp </td>
                  <td style="text-align:right">
                    {{ $controller->currency_format($total_local_row) }}
                  </td>
                </tr>
                @endforeach
                @foreach ($items['total']['foreign'] as $total_foreign_index => $total_foreign_row)
                <tr>
                  <td style="width: 1px; white-space: nowrap">Total
                    {{ strtoupper($total_foreign_row['currency']->code) }}
                  </td>
                  <td style="width: 1px">:</td>
                  <td style="width: 1px; ">{{ $total_foreign_row['currency']->symbol }}</td>
                  <td style="text-align:right">
                    {{ $controller->currency_format($total_foreign_row['amount']) }}
                  </td>
                </tr>
                @endforeach

              </table>
            </td>
          </tr>
        </tbody>
      </table>
      @endforeach
    </div>
  </div>
</body>

</html>
