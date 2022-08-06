<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$invoice->transactionnumber}}</title>
    <style>
        @page {
            margin: 0cm, 0cm;
        }
        html,body{
            padding: 0;
            margin: 0;
            font-size: 12px;
        }

        body {
            margin-top: 3.5cm;
            margin-bottom: 3cm;
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
            bottom: 0.5cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;
            font-size: 9px;
        }

        /* ul li{
            display: inline-block;
        } */

        ol,ul {
            counter-reset: item;
            padding-left: 0;
            line-height: 1;
        }

        ol > li,
        ul > li{
            counter-increment: item;
            padding-left:1.5em;
            position: relative;
            page-break-inside: avoid;
        }

        table{
            border-collapse: collapse;
        }

        #head{
            left: 220px;
            position: absolute;
        }

        .container{
            width: 100%;
            margin: 0 36px;
            position: relative;
        }

        .barcode{
            margin-left:70px;
            margin-top:12px;
        }

        #content{
            width:100%;
            padding-bottom: 20px;
            min-height: 125px;
            background: #ccdfe8;
            margin-top:-29px;
        }

        #content2, #content4, #content3{
            margin-top:10px;
        }

        #content2 table tr td{
            border-left:  1px solid  #d4d7db;
            border-right:  1px solid  #d4d7db;
            border-top:  1px solid  #d4d7db;
            border-bottom:  1px solid  #d4d7db;
        }

        .form_number {
            position: absolute;
            font-weight: bold;
            right: 0cm;
            top: 0.5cm;
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
                    <td width="55%" valign="middle" style="padding-bottom:15px;font-size:12px;line-height:18px;">
                        Bandara Internasional Juanda,
                        <br>
                        Betro, Sedati, Sidoarjo, 61253, Indonesia
                        <br>
                        Phone : 031-8686482 &nbsp;&nbsp;&nbsp; Fax : 031-8686500
                        <br>
                        Email : marketingmmf@ptmmf.co.id
                        <br>
                        Website : www.ptmmf.co.id
                    </td>
                    <td width="45%" valign="middle" align="center">
                        <h1 style="font-size:40px;">INVOICE<br>
                            <span style="font-size:12px;font-weight: none;">Invoice No:{{$invoice->transactionnumber}}</h1>
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <footer>
        <div class="container">
            <div class="form_number">Form No : F02-0601</div>
            <table width="100%">
                {{-- <tr>
                    <td style="text-align: right; padding-top: 3cm"></td> --}}
                    <!-- {{-- <td><b>Form No : F02-1234</b></td> --}} --> {{-- created by hanya muncul di print yg copy --}}
                    <!-- <td>  <span style="margin-left:6px;">Created By : {{ @$invoice->created_by }} ; </span> </td> -->
                    {{-- <td style="text-align:right">
                        <i>
                            Original
                        </i>
                    </td> --}}
                {{-- </tr> --}}
                <tr>
                  <td>
                    <span style="margin-left:6px;">
                      Created By : {{$invoice->created_by}} &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;
                      Approved By : {{$invoice->approved_by}} &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;
                      Printed By :  {{Auth::user()->name.' '.date('d-m-Y H:i:s')}}
                    </span>
                  </td>
                </tr>
            </table>
        </div>
        <img src="./vendor/courier/img/form/invoice/Footer-Invoice.png" width="100%" alt="" >
    </footer>

    <div id="content">
        <div class="container">
            <table width="100%" cellpadding="4" style="padding-top:10px">
                <tr>
                    <td valign="top" width="18%">Customer Name</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">{{$invoice->customer->name}}</td>
                    <td valign="top" width="18%">Invoice Date</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">{{date('d-m-Y', strtotime($invoice->transactiondate))}}</td>
                </tr>
                <tr>
                    <td valign="top" width="18%">Address</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">
                        {{@$invoice->customer->addresses()->first()->address}}
                    </td>
                    <td valign="top" width="18%">Quotation No.</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">
                        {{$invoice->quotations->number}}
                    </td>
                </tr>
                <tr>
                    <td valign="top" width="18%">Phone</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">
                        {{@$invoice->customer->phones()->first()->number}}
                    </td>
                    <td valign="top" width="18%">Currency</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%" style="text-transform:uppercase">
                        {{$invoice->currencies->code}}
                    </td>
                </tr>
                <tr>
                    <td valign="top" width="18%">Attn</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">
                        {{$invoice->attention}}
                    </td>
                    <td valign="top" width="18%">Rate</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">
                        Rp. {{number_format(memfisRound($invoice->currencies->code, $invoice->exchangerate), 2, ',', '.')}}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div id="content2">
        <div class="container">
            <table width="100%" cellpadding="4" border="1" page-break-inside: auto;>
                <thead>
                    <tr style="background:#49535c; color:white">
                        <td width="10%"></td>
                        <td width="65%" align="center" colspan="2"><b>Detail</b></td>
                        <td width="23%" align="center" colspan="2"><b>Amount</b></td>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="5" height="20">
                       <span style="font-size: 14px; font-weight: bold;padding:15px">
                            Subject : {{$invoice->quotations->title}}
                        </span>
                    </td>
                </tr>
                @for ($a=0; $a < count($invoice->quotations->workpackages); $a++)
                    @php
                        $workpackage_row = $invoice->quotations->workpackages[$a];
                    @endphp
                    <tr>
                        <td width="10%" rowspan="{{ ($workpackage_row->is_template != 'htcrr') ? 4: 3}}" align="center" valign="top">{{$a+1}}</td>

                        <td width="65%" valign="top" style="border-bottom:none" colspan="2">
                            <b>{{$workpackage_row->title}}</b>
                        </td>

                        <td width="1%" style="border-right:none;border-bottom:none;"></td>

                        <td width="24%" align="right" valign="top" style="border-left:none;border-bottom:none; padding-right:8px;"></td>
                    </tr>
                    @if ($workpackage_row->is_template != 'htcrr')
                        <tr>
                            <td width="65%" valign="top" style="border-top:none;padding-left:12px;" colspan="2">
                                Facility
                            </td>

                            <td width="1%" style="border-right:none;border-top:none">{{strtoupper($invoice->currencies->code)}}</td>

                            <td width="24%"  align="right" valign="top" style="border-left:none;border-top:none; padding-right:8px;">
                                {{
                                    number_format(
                                        memfisRound($invoice->currencies->code, $workpackage_row->facility)
                                        , 2
                                        , ','
                                        , '.'
                                    )
                                }}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td width="65%" valign="top" style="border-top:none;padding-left:12px;" colspan="2">
                            Material Need {{number_format(memfisRound($invoice->currencies->code, $workpackage_row->material_item), 2, ',', '.')}} Item(s)
                        </td>

                        <td width="1%" style="border-right:none;border-top:none">{{strtoupper($invoice->currencies->code)}}</td>

                        <td width="24%"  align="right" valign="top" style="border-left:none;border-top:none; padding-right:8px;">
                            {{
                                number_format(
                                    memfisRound($invoice->currencies->code, $workpackage_row->mat_tool_price)
                                    , 2
                                    , ','
                                    , '.'
                                )
                            }}
                        </td>
                    </tr>
                    <tr>
                        <td width="65%" valign="top" style="border-top:none; border-bottom:none;padding-left:12px;" colspan="2">
                            Total {{number_format(memfisRound($invoice->currencies->code, count($workpackage_row->taskcards)), 2, ',', '.')}} Taskcard(s) - {{
                                ($workpackage_row->is_template == 'htcrr')
                                ? @$workpackage_row->data_htcrr['total_manhours_with_performance_factor']
                                : @$workpackage_row->pivot->manhour_total
                            }} Manhours
                        </td>

                        <td width="1%" style="border-bottom:none;border-right:none;border-top:none;text-transform:uppercase">
                            {{strtoupper($invoice->currencies->code)}}
                        </td>

                        <td width="24%"  align="right" valign="top" style="border-left:none;border-top:none;border-bottom:none; padding-right:8px;">
                            @php
                                if ($workpackage_row->is_template == 'htcrr') {
                                    echo number_format(
                                        memfisRound($invoice->currencies->code, (float) $workpackage_row->data_htcrr['total_manhours_with_performance_factor']
                                        * (float) $workpackage_row->data_htcrr['manhour_rate_amount']
                                        * $invoice->multiple)
                                        , 2
                                        , ','
                                        , '.'
                                    );
                                }else{
                                    echo number_format(
                                        memfisRound($invoice->currencies->code, @$workpackage_row->pivot->manhour_total * @$workpackage_row->pivot->manhour_rate_amount * $invoice->multiple)
                                        , 2
                                        , ','
                                        , '.'
                                    );
                                }
                            @endphp
                        </td>
                    </tr>
                @endfor
                <tr>
                    <td width="10%" rowspan="{{($invoice->currencies->code != 'idr')? '7': '6'}}" align="center" valign="top"></td>

                    <td width="35%" style="border-bottom:none;color:red;border-right:none;"></td>

                    <td width="30%" valign="top" style="border-bottom:none;border-left:none;">
                        {{-- jika scheduled payment 1x --}}
                        @if(1==1)
                            Subtotal
                        @else
                            {{-- jika scheduled payment lebih dari 2x --}}
                            <span style="color:red;"><b>DUE PAYMENT AMOUNT</b></span>
                        @endif
                    </td>

                    <td width="1%" style="border-right:none;border-bottom:none;">{{strtoupper($invoice->currencies->code)}}</td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;border-bottom:none; padding-right:8px;">
                        {{
                            number_format(
                                memfisRound($invoice->currencies->code, $invoice->subtotal)
                                , 2
                                , ','
                                , '.'
                            )
                        }}
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="border-top:none; border-bottom:none;border-right:none;"></td>

                    <td width="30%" valign="top" style="border-top:none; border-bottom:none;border-left:none;">Discount</td>

                    <td width="1%" style="border-bottom:none;border-right:none;border-top:none;text-transform:uppercase">
                        {{$invoice->currencies->code}}
                    </td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;border-top:none;border-bottom:none; padding-right:8px;">
                        {{
                            number_format(
                                memfisRound($invoice->currencies->code, ($invoice->discountvalue * -1))
                                , 2
                                , ','
                                , '.'
                            )
                        }}
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="border-top:none; border-bottom:none;border-right:none;"></td>

                    <td width="30%" valign="top" style="border-top:none; border-bottom:none;border-left:none;">Total before tax</td>

                    <td width="1%" style="border-bottom:none;border-right:none;border-top:none;text-transform:uppercase">
                        {{$invoice->currencies->code}}
                    </td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;border-top:none;border-bottom:none; padding-right:8px;">
                        {{
                            number_format(
                                memfisRound($invoice->currencies->code, $invoice->total)
                                , 2
                                , ','
                                , '.'
                            )
                        }}
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="border-top:none; border-bottom:none;border-right:none;"></td>

                    <td width="30%" valign="top" style="border-top:none; border-bottom:none;border-left:none;">VAT ({{$invoice->quotations->taxes[0]->TaxPaymentMethod->code}})</td>

                    <td width="1%" style="border-bottom:none;border-right:none;border-top:none;text-transform:uppercase">
                        {{$invoice->currencies->code}}
                    </td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;border-top:none;border-bottom:none; padding-right:8px;">
                        {{
                            number_format(
                                memfisRound($invoice->currencies->code, $invoice->ppnvalue)
                                , 2
                                , ','
                                , '.'
                            )
                        }}
                    </td>
                </tr>
                <tr>
                    <td width="35%" style="border-top:none; border-bottom:none;border-right:none;"></td>

                    <td width="30%" valign="top" style="border-top:none; border-bottom:none;border-left:none;">Other</td>

                    <td width="1%" style="border-bottom:none;border-right:none;border-top:none;text-transform:uppercase">
                        {{$invoice->currencies->code}}
                    </td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;border-top:none;border-bottom:none; padding-right:8px;">
                        {{
                            number_format(
                                memfisRound($invoice->currencies->code, $invoice->other_price)
                                , 2
                                , ','
                                , '.'
                            )
                        }}
                    </td>
                </tr>

                @if ($invoice->currencies->code != 'idr')
                  <tr>
                      <td width="35%" style="border-top:none;border-bottom:none;border-right:none;"></td>

                      <td width="30%" valign="top" style="border-top:none;border-bottom:none;border-left:none;text-transform:uppercase"><b>
                          Total in {{$invoice->currencies->code}}
                      </b></td>

                      <td width="1%" style="border-right:none;border-bottom:none;border-top:none;text-transform:uppercase">
                          <b>{{$invoice->currencies->code}}</b>
                      </td>

                      <td width="24%"  align="right" valign="top" style="border-left:none;border-top:none;border-bottom:none; padding-right:8px;">
                          <b>
                              {{
                                  number_format(
                                      memfisRound($invoice->currencies->code, $invoice->grandtotalforeign)
                                      , 2
                                      , ','
                                      , '.'
                                  )
                              }}
                          </b>
                      </td>
                  </tr>
                @endif

                <tr>
                    <td width="35%" style="border-top:none;border-right:none;"></td>

                    <td width="30%" valign="top" style="border-top:none;border-left:none;"><b>Total in IDR</b></td>

                    <td width="1%" style="border-right:none;border-top:none"><b>IDR</b></td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;border-top:none; padding-right:8px;">
                        <b>
                            {{
                                number_format(
                                    memfisRound($invoice->currencies->code, $invoice->grandtotal)
                                    , 2
                                    , ','
                                    , '.'
                                )
                            }}
                        </b>
                    </td>
                </tr>
                {{-- Terbilang --}}
                {{-- <tr>
                    <td colspan="5" align="center" valign="top" style="color:#134678"><b><i>THIRTY THOUSAND DOLLARS</i></b></td>
                </tr> --}}
            </tbody>
            </table>
        </div>
    </div>

    <div id="content3">
        <div class="container">
            <table width="100%">
                <tr>
                    <td>
                        <fieldset>
                            <legend style="color:#3b98f5;font-weight: bold; font-size:14px;">Bank Account Information</legend>
                          {!! $bank_segment !!}
                        </fieldset>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div id="content4">
        <div class="container">
            <table width="100%">
                <tr>
                    <td width="50%" valign="top">
                        <table width="100%">
                            <tr>
                                <td><b>Term & Condition :</b></td>
                            </tr>
                            <tr>
                                <td height="40" valign="top">
                                    {!!$invoice->term_and_condition!!}
                                </td>
                            </tr>
                            <tr>
                                <td><b>Remark :</b></td>
                            </tr>
                            <tr>
                                <td height="40" valign="top">
                                    {!! $invoice->description !!}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%" valign="top">
                        <table width="100%">
                            <tr>
                                <td width="100%" valign="top" align="center">{{$invoice->location.', '.date('M d, Y', strtotime($invoice->transactiondate))}}</td>
                            </tr>
                            <tr>
                                <td width="100%" height="85"></td>
                            </tr>
                            <tr>
                                <td width="100%" valign="top" align="center"><b>{{$invoice->presdir}}</b></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
