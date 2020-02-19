<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        html,body{
            padding: 0;
            margin: 0;
            font-size: 12px;
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
            height: 46px;
        }

        ul li{
            display: inline-block;
        }

        table{
            border-collapse: collapse;
        }

        #head{
            top:20px;
            left: 510px;
            position: absolute;
            color: #5c5b5b;
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
            margin-top:135px;
            padding-bottom: 20px;
            height: 125px;
            background: #ccdfe8;
        }

        #content2{
            margin-top:10px;
        }

        #content2 table tr td{
            border-left:  1px solid  #d4d7db;
            border-right:  1px solid  #d4d7db;
            border-top:  1px solid  #d4d7db;
            border-bottom:  1px solid  #d4d7db;
        }


        .page_break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{url('')}}/vendor/courier/img/form/invoice/Header.png" alt=""width="100%">
        <div id="head">
            <div style="margin-right:20px;text-align:center;">
                <h3 style="font-size:40px;">INVOICE <br> <span style="font-size:16px;">{{$invoice->transactionnumber}}</span></h3>
            </div>
        </div>
    </header>

    <footer>
        <div class="container">
            <table width="100%">
                <tr>
                    <!-- {{-- <td><b>Form No : F02-1234</b></td> --}} -->
		                <td>  <span style="margin-left:6px;">Created By : {{ @$invoice->created_by->name }} ; </span> </td>
										<td style="text-align:right">
											<i>
												Original
											</i>
										</td>
                </tr>
            </table>
        </div>
        <img src="{{url('')}}/vendor/courier/img/form/invoice/Footer-Invoice.png" width="100%" alt="" >
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
                    <td valign="top" width="31%">{{date('d/m/Y', strtotime($invoice->transactiondate))}}</td>
                </tr>
                <tr>
                    <td valign="top" width="18%">Address</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">
											{{$invoice->customer->addresses()->first()->address}}
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
											{{$invoice->customer->phones()->first()->number}}
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
											{{json_decode($invoice->customer->attention)[0]->name}}
										</td>
                    <td valign="top" width="18%">Rate</td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="31%">
											Rp. {{number_format($invoice->exchangerate, 0, 0, '.')}}
										</td>
                </tr>
            </table>
        </div>
    </div>

    <div id="content2">
        <div class="container">
            <table width="100%" cellpadding="4" border="1">
                <tr style="background:#49535c; color:white">
                    <td width="10%"></td>
                    <td width="65%" align="center" colspan="2"><b>Detail</b></td>
                    <td width="23%" align="center" colspan="2"><b>Amount</b></td>
                </tr>
                <tr>
                    <td colspan="5" height="20">
                       <span style="font-size: 14px; font-weight: bold;padding:15px">
												 Subject : {{$invoice->quotations->title}}
											 </span>
                    </td>
                </tr>
								@for ($a=0; $a < count($invoice->quotations->workpackages); $a++)
									@php
										$x = $invoice->quotations->workpackages[$a];
									@endphp
	                <tr>
	                    <td width="10%" rowspan="{{ ($x->is_template != 'htcrr') ? 4: 3}}" align="center" valign="top">{{$a+1}}</td>

	                    <td width="65%" valign="top" style="border-bottom:none" colspan="2">
												<b>{{$x->title}}</b> {{ $x->is_template }}
											</td>

	                    <td width="1%" style="border-right:none;border-bottom:none;"></td>

	                    <td width="24%" align="right" valign="top" style="border-left:none;border-bottom:none; padding-right:8px;"></td>
	                </tr>
									@if ($x->is_template != 'htcrr')
		                <tr>
		                    <td width="65%" valign="top" style="border-top:none;padding-left:12px;" colspan="2">
													Facility
												</td>

		                    <td width="1%" style="border-right:none;border-top:none">{{strtoupper($invoice->currencies->code)}}</td>

		                    <td width="24%"  align="right" valign="top" style="border-left:none;border-top:none; padding-right:8px;">
													{{
														number_format(
															$x->facility
															, 0
															, 0
															, '.'
														)
													}}
												</td>
		                </tr>
									@endif
	                <tr>
	                    <td width="65%" valign="top" style="border-top:none;padding-left:12px;" colspan="2">
												Material Need {{number_format($x->material_item, 0, 0, '.')}} Item(s)
											</td>

	                    <td width="1%" style="border-right:none;border-top:none">{{strtoupper($invoice->currencies->code)}}</td>

	                    <td width="24%"  align="right" valign="top" style="border-left:none;border-top:none; padding-right:8px;">
												{{
													number_format(
														$x->mat_tool_price
														, 0
														, 0
														, '.'
													)
												}}
											</td>
	                </tr>
	                <tr>
	                    <td width="65%" valign="top" style="border-top:none; border-bottom:none;padding-left:12px;" colspan="2">
												Total {{number_format(count($x->taskcards), 0, 0, '.')}} Taskcard(s) - {{number_format(@$x->pivot->manhour_total)}} Manhours
											</td>

	                    <td width="1%" style="border-bottom:none;border-right:none;border-top:none;text-transform:uppercase">
												{{strtoupper($invoice->currencies->code)}}
											</td>

	                    <td width="24%"  align="right" valign="top" style="border-left:none;border-top:none;border-bottom:none; padding-right:8px;">
												@php
													if ($x->is_template == 'htcrr') {
														echo number_format(
															(float) $x->data_htcrr['total_manhours_with_performance_factor'] * (float) $x->data_htcrr['manhour_rate_amount']
															, 0
															, 0
															, '.'
														);
													}else{
														echo number_format(
															@$x->pivot->manhour_total * @$x->pivot->manhour_rate_amount
															, 0
															, 0
															, '.'
														);
													}
												@endphp
											</td>
	                </tr>
								@endfor
                {{-- Others&Disc --}}
                <tr>
                    <td width="10%" align="center" valign="top"></td>

                    <td width="65%" valign="top" style="padding-left:12px;" colspan="2">Others</td>

                    <td width="1%" style="border-right:none;text-transform:uppercase">
											{{strtoupper($invoice->currencies->code)}}
										</td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;padding-right:8px;">
											{{
												number_format(
													$other_workpackage->priceother
													, 0
													, 0
													, '.'
												)
											}}
										</td>
                </tr>
                <tr>
                    <td width="10%" align="center" valign="top"></td>

                    <td width="65%" valign="top" style="padding-left:12px;" colspan="2">Disc</td>

                    <td width="1%" style="border-right:none;text-transform:uppercase">
											{{$invoice->currencies->code}}
										</td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;padding-right:8px;">
											{{
												number_format(
													$invoice->discountvalue
													, 0
													, 0
													, '.'
												)
											}}
										</td>
                </tr>
                 {{-- TheOthers --}}
                <tr>
                    <td width="10%" rowspan="4" align="center" valign="top"></td>

                    <td width="35%" style="border-bottom:none;color:red;border-right:none;"></td>

                    <td width="30%" valign="top" style="border-bottom:none;border-left:none;">
                        {{-- jika scheduled payment 1x --}}
                        @if(1==1)
                            Sub Total
                        @else
                            {{-- jika scheduled payment lebih dari 2x --}}
                            <span style="color:red;"><b>DUE PAYMENT AMOUNT</b></span>
                        @endif
                    </td>

                    <td width="1%" style="border-right:none;border-bottom:none;">{{strtoupper($invoice->currencies->code)}}</td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;border-bottom:none; padding-right:8px;">
											{{
												number_format(
													($invoice->grandtotalforeign - $invoice->other_price) / 1.1
													, 0
													, 0
													, '.'
												)
											}}
										</td>
                </tr>
                <tr>
                    <td width="35%" style="border-top:none; border-bottom:none;border-right:none;"></td>

                    <td width="30%" valign="top" style="border-top:none; border-bottom:none;border-left:none;">VAT 10% (included)</td>

                    <td width="1%" style="border-bottom:none;border-right:none;border-top:none;text-transform:uppercase">
											{{$invoice->currencies->code}}
										</td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;border-top:none;border-bottom:none; padding-right:8px;">
											{{
												number_format(
													($invoice->grandtotalforeign - $invoice->other_price) / 1.1 * 0.1
													, 0
													, 0
													, '.'
												)
											}}
										</td>
                </tr>
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
														$invoice->grandtotalforeign
														, 0
														, 0
														, '.'
													)
												}}
											</b>
										</td>
                </tr>
                <tr>
                    <td width="35%" style="border-top:none;border-right:none;"></td>

                    <td width="30%" valign="top" style="border-top:none;border-left:none;"><b>Total in IDR</b></td>

                    <td width="1%" style="border-right:none;border-top:none"><b>IDR</b></td>

                    <td width="24%"  align="right" valign="top" style="border-left:none;border-top:none; padding-right:8px;"><b>
												{{
													number_format(
														$invoice->grandtotalforeign * $invoice->exchangerate
														, 0
														, 0
														, '.'
													)
												}}
										</b></td>
                </tr>
                {{-- Terbilang --}}
                <tr>
                    {{-- <td colspan="5" align="center" valign="top" style="color:#134678"><b><i>THIRTY THOUSAND DOLLARS</i></b></td> --}}
                </tr>
            </table>
        </div>
    </div>

    <div id="content3">
        <div class="container">
            <fieldset>
                <legend style="color:#3b98f5;font-weight: bold; font-size:14px;">Bank Account Information</legend>
                <table width="100%" cellpadding="4" style="padding-top:10px">
                        <tr>
                            <td valign="top" width="18%">Bank Name</td>
                            <td valign="top" width="1%">:</td>
                            <td valign="top" width="31%">
															{{$invoice->bank->bank->name}}
														</td>
                            {{-- <td valign="top" width="18%">Bank Name</td>
                            <td valign="top" width="1%">:</td>
                            <td valign="top" width="31%">Bank BNI Graha Pengeran</td> --}}
                        </tr>
                        <tr>
                            <td valign="top" width="18%">Bank Account Name</td>
                            <td valign="top" width="1%">:</td>
                            <td valign="top" width="31%">{{$invoice->bank->name}}</td>
                            {{-- <td valign="top" width="18%">Bank Account Name</td>
                            <td valign="top" width="1%">:</td>
                            <td valign="top" width="31%">PT. Merpaty Maintance Facility</td> --}}
                        </tr>
                        <tr>
                            <td valign="top" width="18%">Bank Account Number</td>
                            <td valign="top" width="1%">:</td>
                            <td valign="top" width="31%">{{$invoice->bank->number}}</td>
                            {{-- <td valign="top" width="18%">Bank Account Number</td>
                            <td valign="top" width="1%">:</td>
                            <td valign="top" width="31%">888123232</td> --}}
                        </tr>
                        <tr>
                            <td valign="top" width="18%">Currency</td>
                            <td valign="top" width="1%">:</td>
                            <td valign="top" width="31%" style="text-transform:uppercase">{{$invoice->currencies->code}}</td>
                            {{-- <td valign="top" width="18%">Currency</td>
                            <td valign="top" width="1%">:</td>
                            <td valign="top" width="31%">IDR</td> --}}
                        </tr>
                        <tr>
													@if ($invoice->bank->swift_code)
                            <td valign="top" width="18%">Swift Code</td>
                            <td valign="top" width="1%">:</td>
                            <td valign="top" width="31%">{{$invoice->bank->swift_code}}</td>
													@else
                            <td valign="top" width="18%"></td>
                            <td valign="top" width="1%"></td>
                            <td valign="top" width="31%"></td>
													@endif
                            {{-- <td valign="top" width="18%">Swift Code</td>
                            <td valign="top" width="1%">:</td>
                            <td valign="top" width="31%">BNNIDIAXXX</td> --}}
                        </tr>
                    </table>
            </fieldset>
        </div>
    </div>

    <div id="content4">
			{{-- @if (@$invoice->approved_by->name) --}}
        <div class="container">
            <table width="100%" cellpadding="4">
                <tr>
                    <td colspan="2"><b>Term & Condition :</b></td>
                </tr>
                <tr>
                    <td width="60%" height="70" valign="top">
                        <i>PAYMENT SHOULD BE RECEIVED IN FULL AMOUNT</i>
												<br>
												{!!$invoice->quotations->term_of_condition!!}
                    </td>
                    <td width="40%" valign="top" align="center">
											{{
												// $invoice->location.', '.date('M d, Y', strtotime($invoice->approvals->first()->updated_at))
												$invoice->location.', '.date('M d, Y', strtotime($invoice->transactiondate))
											}}
										</td>
                    {{-- <td width="40%" valign="top" align="center">
											Approved By : {{@$invoice->approved_by->name}}
										</td> --}}
                </tr>
                <tr>
                    <td width="60%"><b>Remark :</b></td>
                    <td width="40%"></td>
                </tr>
                <tr>
                    <td width="60%" height="60" valign="top">
											{{$invoice->description}}
                    </td>
                    <td width="40%" valign="top" align="center">
											<b>
												{{-- {{$invoice->approved_by->role}}<br> --}}
												{{$invoice->presdir}}
												{{-- Rowin H. Mangkoesoebroto --}}
											</b>
										</td>
                </tr>
            </table>
        </div>
			{{-- @endif --}}
    </div>
</body>
</html>
