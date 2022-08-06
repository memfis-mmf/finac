<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$data->transactionnumber}}</title>
    <style>
        @page {
            margin: 0cm 0cm;
        }

        html,body{
            padding: 0;
            margin: 0;
            font-size: 12px;
        }

        body{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin-top: 3.1cm;
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
            height: .7cm;
            font-size: 9px;
        }
        ul li{
            display: inline-block;
        }

        table{
            border-collapse: collapse;
        }

        #head{
            top: 10px;
            left: 210px;
            position: absolute;
            text-align: center;
        }

        #footer{
            position: absolute;
            bottom: 18px;
            z-index: 1;
        }

        .footer-container{
            width: 100%;
            margin: 0 12px;
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
            margin-bottom:20px;
        }

        #content2 .body{
            width: 100%;
            border-left:  2px solid  #e6eef2;
            border-right:  2px solid  #e6eef2;
            border-bottom:  2px solid  #e6eef2;
        }

        .page_break {
            page-break-before: always;
        }

        .form_number {
            position: absolute;
            bottom: 1cm;
            right: 0.5cm;
            font-weight: bold;
        }

        footer .num:after {
            content: counter(page);
        }
    </style>
</head>
<body>
    <header>
        <img src="./vendor/courier/img/form/printoutfa/HeaderFA-A4-Potrait.png" alt=""width="100%">
        <div id="head">
            <table width="95%">
                <tr>
                    <td width="50%" valign="middle" style="font-size:12px;line-height:15px;">
                        Juanda International Airport, Surabaya Indonesia
                        <br>
                        Phone : 031-8686482 &nbsp;&nbsp;&nbsp; Fax : 031-8686500
                        <br>
                        Email : marketing@ptmmf.co.id
                        <br>
                        Website : www.ptmmf.co.id
                    </td>
                    <td width="50%" valign="top" align="center" style="padding-top:-16px">
                        {{-- jika if didalam h1 akan broken --}}
                        <h1 style="font-size:24px;">
                            {{$header_title}} Received
                        <br>
                        <span style="font-size:18px;">(Account Receivables)</span></h1>
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <footer>
        <div class="form_number">Form No. F02-0602</div>
        <img src="./vendor/courier/img/form/trial-balance/Footer.png" width="100%" alt="" >

        <div class="footer-container">
            <div id="footer">
                <table width="100%">
                    <tr>
                        <td>  <span style="margin-left:6px;">Created By : {{$data->created_by ?? '-'}}  &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;Approved By : {{$data->approved_by}} &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp; Printed By : {{auth()->user()->name." ".date('d-m-Y H:i:s')}} </font></span> </td>
                        <td align="right">Page <span class="num"></span></td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>


    <div id="content">
        <div class="container">
            <table width="100%" cellpadding="4">
                <tr>
                    <td valign="top" width="18%">Transaction No.</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">{{$data->transactionnumber}}</td>
                    <td valign="top" width="18%">
                      Receive From
                    </td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">{{$to->name}}</td>
                </tr>
                <tr>
                    <td valign="top" width="18%">Date</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">{{$data->transactiondate->format('d-m-Y')}}</td>
                    <td valign="top" width="18%">Currency</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">{{strtoupper($data->currencies->code)}}</td>
                </tr>
                <tr>
                    <td valign="top" width="18%">Project No.</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">{{$data->project->code ?? '-'}}</td>
                    <td valign="top" width="18%">Exchange Rate</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">{{number_format($data->exchangerate, 0, ',', '.')}}</td>
                </tr>
            </table>
        </div>
    </div>

    <div id="content2">
        <div class="container">
            <div class="body">
                <table width="100%" cellpadding="4" page-break-inside: auto;>
                    <thead>
                        <tr style="background:#e6eef2;">
                            <td width="15%" align="center">Account Code</td>
                            <td width="20%" align="center">Account Name</td>
                            <td width="31%" align="center">Description</td>
                            <td width="17%" align="center">Debit</td>
                            <td width="17%" align="center">Credit</td>
                        </tr>
                    </thead>
                    <tbody>
                        @for($a = 0 ; $a<count($data_child); $a++)
                            @php
                              $arr = $data_child[$a];
                              $journal_detail = $controller->getJournalDetail($data->transactionnumber, $arr->coa_code);
                            @endphp
                          <tr>
                              <td width="15%" align="center">{{$arr->coa_code}}</td>
                              <td width="20%" align="left">{{$arr->coa_name}}</td>
                              <td width="31%" align="left">{!! $journal_detail->description_2 ?? $arr->_desc !!}</td>
                              <td width="17%" align="right">
                                @php
                                    if ($arr->debit != 0) {
                                        echo 'Rp '.
                                        number_format($arr->debit, 0, ',', '.');

                                      if (($invoice_sample->currencies->code != 'idr' or $data->currency != 'idr') and $arr->debit_foreign != 0) {
                                        echo "<br>($ ".number_format($arr->debit_foreign, 2, ',', '.').' )';
                                      }
                                    }
                                @endphp
                              </td>
                              <td width="17%" align="right">
                                @php
                                    if ($arr->credit != 0) {
                                      echo 'Rp '.
                                      number_format($arr->credit, 0, ',', '.');

                                      if (($invoice_sample->currencies->code != 'idr' or $data->currency != 'idr') and $arr->credit_foreign != 0) {
                                        echo "<br>($ ".number_format($arr->credit_foreign, 2, ',', '.').' )';
                                      }
                                    }
                                @endphp
                              </td>
                          </tr>
                        @endfor
                    </tbody>
                    <tr style="background:#d3e9f5;">
                        <td colspan="3">
                          @if ($total_foreign != 0)
                            <b>Total USD : $ {{ number_format($total_foreign, 2, ',', '.') }}</b>
                          @endif
                        </td>
                        <td colspan="2" style="background:#e6eef2" align="right">
                            <b>Total : <span>Rp {{number_format($total, 0, ',', '.')}}<span></b>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div id="content3" style="margin-top:15px">
        <div class="container">
            <table width="100%" border="1">
                <thead>
                    <tr>
                        @if ('payment' == 'payment')
                            <td align="center" rowspan="2">Submitted By</td>
                        @else
                            <td align="center" rowspan="2">Prepared By</td>
                        @endif
                            <td align="center"  rowspan="2">Controlled By <br><span style="font-size: 10px;"><b><i>
                                Finance Controller/GB</i></b></span></td>
                            <td align="center"  rowspan="2">Approve By <br><span style="font-size: 10px;"><b><i>Director/President Director</i></b></span></td>
                            <td align="center"  colspan="3">FINANCE & ACCOUNTING</td>

                        @if ('payment' == 'payment')
                            <td align="center" width="13%" rowspan="2"> Received By </td>
                        @else
                            <td align="center" width="13%" rowspan="2"> Paid By </td>
                        @endif
                    </tr>
                    <tr>
                        <td align="center" width="15%">Executed By <br><span style="font-size: 10px;"><b><i>Finance Manager</i></b> </span></td>
                        <td align="center" >Processed By <br><span style="font-size: 10px;"><b><i>Cashier</i></b> </span></td>
                        <td align="center" >Recorded By<br><span style="font-size: 10px;"><b><i>Accounting</i></b></span> </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td height="50"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
