<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$cashbook->transactionnumber}}</title>
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
            height: 1.8cm;
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
                    <td width="55%" valign="top" align="center" style="padding-top:-16px">
                        <h1 style="font-size:24px;">{{$type_header}}<br> 
                        <span style="font-size:18px;">(Cashbook)</span></h1>
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <footer>
        <div class="container">
            <table width="100%">
                <tr>
                    <td>  
                      <span style="margin-left:6px;">
                        Created By : {{$cashbook->created_by}} &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;
                        Approved By : {{$cashbook->approved_by}} &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp; 
                        Printed By :  {{Auth::user()->name.' '.date('Y-m-d H:i:s')}} 
                      </span> 
                    </td>
                </tr>
            </table>
        </div>
        <img src="./vendor/courier/img/form/trial-balance/Footer.png" width="100%" alt="" >
    </footer>

    <div id="content">
        <div class="container">
            <table width="100%" cellpadding="4">
                <tr>
                    <td valign="top" width="18%">Transaction No.</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">{{$cashbook->transactionnumber}}</td>
                    <td valign="top" width="18%">
											@if ($type == 'rj')
												Receive From
											@else
												Payment To
											@endif
										</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">{{$cashbook->personal}}</td>
                </tr>
                <tr>
                    <td valign="top" width="18%">Date</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">{{$carbon::parse($cashbook->transactiondate)->format('d-m-Y')}}</td>
                    <td valign="top" width="18%">Currency</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">{{$cashbook->currency}}</td>
                </tr>
                <tr>
                    <td valign="top" width="18%">Ref No.</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">{{$cashbook->refno}}</td>
                    <td valign="top" width="18%">Exchange Rate</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">{{number_format($cashbook->exchangerate, 2, ',', '.')}}</td>
                </tr>
                <tr>
                    <td valign="top" width="18%">Cashbook Ref.</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">{{$cashbook->cashbook_ref}}</td>
                    <td valign="top" width="18%"></td>
                    <td valign="top" width="1%"></td>
                    <td valign="top" width="31%"></td>
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
                        @for($a = 0 ; $a<count($detail); $a++)
													@php
														$arr = $detail[$a];
													@endphp
                            <tr>
                                <td width="15%" align="center">{{$arr->coa_detail}}</td>
                                <td width="20%" align="left">{{$arr->coa_name}}</td>
                                <td width="31%" align="left">{{$arr->_desc}}</td>
                                <td width="17%" align="right">
																	@if ($arr->debit != 0)
																		{{$arr->symbol.' '.$controller::currency_format($arr->debit, 2)}}
                                    @if ($arr->second_debit)
                                      <p>
                                        {{ "({$cashbook->second_currencies->symbol} {$controller::currency_format($arr->second_debit, 2)})" }}
                                      </p>
                                    @endif
																	@endif
																</td>
                                <td width="17%" align="right">
																	@if ($arr->credit != 0)
																		{{$arr->symbol.' '.$controller::currency_format($arr->credit, 2)}}
                                    @if ($arr->second_credit)
                                      <p>
                                        {{ "({$cashbook->second_currencies->symbol} {$controller::currency_format($arr->second_credit, 2)})" }}
                                      </p>
                                    @endif
																	@endif
																</td>
                            </tr>
                        @endfor
                    </tbody>
                    <tr style="background:#d3e9f5;">
                        <td colspan="3">
                          {{-- <i> Terbilang total amount </i> --}}
                        </td>
                        <td style="background:#e6eef2" align="right"><b>{{$detail[0]->symbol}}. {{$controller::currency_format($total_debit, 2)}}</b></td>
                        <td style="background:#e6eef2" align="right"><b>{{$detail[0]->symbol}}. {{$controller::currency_format($total_credit, 2)}}</b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div id="content3" style="margin-top: 20px;">
        <div class="container">
            <table width="100%" border="1">
                <tr>
                    <td align="center" rowspan="2">Ordered By</td>
                    <td align="center"  rowspan="2">Approved By <br><span style="font-size: 10px;"><b><i>President Director</i></b></span></td>
                    <td align="center" colspan="3">FINANCE & ACCOUNTING</td>
                    <td align="center"  rowspan="2"  width="15%">
											@if ($type == 'rj')
                        Received From
											@else
                        Received By
											@endif
                    </td>
                </tr>
                <tr>
                    <td align="center">Recorded By <br><span style="font-size: 10px;"><b><i>Accounting</i></b> </span></td>
                    <td align="center">Checked By <br><span style="font-size: 10px;"><b><i>Finance Manager</i></b> </span></td>
                    <td align="center">Processed By<br><span style="font-size: 10px;"><b><i>Cashier</i></b></span> </td>
                </tr>
                <tr>
                    <td height="50"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
