<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    html,body{
      padding: 0;
      margin: 0;
      font-size: 10px;
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
      height: 2.4cm;
    }
    ul li{
      display: inline-block;
    }

    table{
      border-collapse: collapse;
    }

    #head{
        top:55px;
        left: 340px;
        position: absolute;
        color:white;
    }

    .container{
      width: 100%;
      margin: 0 20px;
    }

    .barcode{
      margin-left:70px;
    }

    .content{
        width: 100%;
        margin-top:90px;
        border-bottom: 1px solid #242424;
    }

    .content table tr td,
    .content2 table tr td,
    .content3 table tr td,
    .content4 table tr td{
        font-size: 12px;
    }

    .content2, .content3{
        width: 100%;
        border-bottom: 1px solid #242424;
    }

     .content4{
        width: 100%;
        height: 240px;
        border-bottom: 1px solid #242424;
    }

    .content5{
        width: 100%;
        margin-top: -8px;
    }

    .page_break {
        page-break-before: always;
    }
</style>
<body>

    <header>
        <div style="width:100%; min-height:90px; border-bottom: 1px solid #242424">
            <table width="100%" cellpadding="8">
                <tr>
                    <td width="25%" align="center" height="55">
                        <img src="./vendor/courier/img/LogoMMF.png" alt="logo" height="60px">
                    </td>
                    <td width="35%" style="font-size:12px; line-height: 1.2;">
                        Juanda International Airport, Surabaya Indonesia <br>
                        Phone : 031-8686482 <span style="margin-left:12px">Fax : 031-8686500</span> <br>
                        Email : marketing@ptmmf.co.id <br>
                        Website : wwww.ptmmf.co.id
                    </td>
                    <td width="40%" align="center">
                        <h1>AR/AP</h1>
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <footer>
        <table width="100%" cellpadding="8" border="1">
            <tr style="font-size:12px">
                <td align="center" valign="top" width="25%" height="900"><b>Accountancy</b></td>
                <td align="center" valign="top" width="25%" height="900"><b>Acknowledge By</b></td>
                <td align="center" valign="top" width="25%" height="900"><b>Approve By</b></td>
                <td align="center" valign="top" width="25%" height="900"><b>Cashier</b></td>
                <td align="center" valign="top" width="25%" height="900"><b>Received By</b></td>
            </tr>
        </table>
    </footer>

    <div class="content">
        <div class="container">
            <table width="100%" cellpadding="4">
                <tr>
                    <td valign="top" width="16%"><b>Transaction No.</b></td>
                    <td valign="top" width="1%">:</td>
										<td valign="top" width="44%">{{ $data->transactionnumber }}</td>
                    <td valign="top" width="13%"><b>Payment To</b></td>
										<td valign="top" width="1%">{{ $to->name }}</td>
                    <td valign="top" width="25%">Lorem ipsum dolor</td>
                </tr>
                <tr>
                    <td valign="top" width="16%"><b>Date</b></td>
                    <td valign="top" width="1%">:</td>
										<td valign="top" width="44%">{{ $data->transactiondate }}</td>
                    <td valign="top" width="13%"></td>
                    <td valign="top" width="1%"></td>
                    <td valign="top" width="25%"></td>
                </tr>
                <tr>
                    <td valign="top" width="16%"><b>Ref No.</b></td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="44%">{{ $data->refno }}</td>
                    <td valign="top" width="13%"></td>
                    <td valign="top" width="1%"></td>
                    <td valign="top" width="25%"></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="content2">
        <div class="container">
            <table width="100%" cellpadding="4">
                <tr>
                    <td valign="top" width="16%"><b>Currency</b></td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="44%">{{ $data->currency }}</td>
                    <td valign="top" width="13%"><b>Exchange Rate</b></td>
                    <td valign="top" width="1%">:</td>
                    <td valign="top" width="25%">{{ number_format($data->exchangerate) }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="content3">
        <div class="container">
            <table width="100%" cellpadding="4">
                <tr>
                    <td valign="top" width="12%"><b>Account Code</b></td>
                    <td valign="top" width="17%"><b>Account Name</b></td>
                    <td valign="top" width="31%"><b>Account Description</b></td>
                    <td valign="top" width="20%"><b>Debit</b></td>
                    <td valign="top" width="20%"><b>Credit</b></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="content4">
        <div class="container">
            <table width="100%" cellpadding="4">

								@for ($a=0; $a < count($data_child[0]); $a++)
									@php
										$x = $data_child[0][$a];
									@endphp
									<tr>
										<td valign="top" width="12%">{{ @$x->coa->code }}</td>
										<td valign="top" width="17%">{{ @$x->coa->name }}</td>
										<td valign="top" width="31%">{{ @$x->coa->description }}</td>
										<td valign="top" width="20%">{{ $data->currencies->symbol.' '.number_format(@$x->debit, 0, 0, '.') }}</td>
										<td valign="top" width="20%">{{ $data->currencies->symbol.' '.number_format(@$x->credit, 0, 0, '.') }}</td>
									</tr>
								@endfor

            </table>
        </div>
    </div>

    <div class="content5">
        <div class="container">
            <p style="font-size:12px">Terbilang dalam Rupiah maupun Dollar</p>
        </div>
    </div>

		@if(count($data_child) > 1)
        @for ($i = 1; $i < $count($data_child); $i++)
            <div class="page_break">
                <div class="content">
                    <div class="container">
											<table width="100%" cellpadding="4">
													<tr>
															<td valign="top" width="16%"><b>Transaction No.</b></td>
															<td valign="top" width="1%">:</td>
															<td valign="top" width="44%">{{ $data->transactionnumber }}</td>
															<td valign="top" width="13%"><b>Payment To</b></td>
															<td valign="top" width="1%">{{ $to->name }}</td>
															<td valign="top" width="25%">Lorem ipsum dolor</td>
													</tr>
													<tr>
															<td valign="top" width="16%"><b>Date</b></td>
															<td valign="top" width="1%">:</td>
															<td valign="top" width="44%">{{ $data->transactiondate }}</td>
															<td valign="top" width="13%"></td>
															<td valign="top" width="1%"></td>
															<td valign="top" width="25%"></td>
													</tr>
													<tr>
															<td valign="top" width="16%"><b>Ref No.</b></td>
															<td valign="top" width="1%">:</td>
															<td valign="top" width="44%">{{ $data->refno }}</td>
															<td valign="top" width="13%"></td>
															<td valign="top" width="1%"></td>
															<td valign="top" width="25%"></td>
													</tr>
											</table>
                    </div>
                </div>

                <div class="content2">
                    <div class="container">
											<table width="100%" cellpadding="4">
													<tr>
															<td valign="top" width="16%"><b>Currency</b></td>
															<td valign="top" width="1%">:</td>
															<td valign="top" width="44%">{{ $data->currency }}</td>
															<td valign="top" width="13%"><b>Exchange Rate</b></td>
															<td valign="top" width="1%">:</td>
															<td valign="top" width="25%">{{ number_format($data->exchangerate) }}</td>
													</tr>
											</table>
                    </div>
                </div>

                <div class="content3">
                    <div class="container">
                        <table width="100%" cellpadding="4">
                            <tr>
                                <td valign="top" width="12%"><b>Account Code</b></td>
                                <td valign="top" width="17%"><b>Account Name</b></td>
                                <td valign="top" width="31%"><b>Account Description</b></td>
                                <td valign="top" width="20%"><b>Debit</b></td>
                                <td valign="top" width="20%"><b>Credit</b></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="content4">
                    <div class="container">
                        <table width="100%" cellpadding="4">
													@for ($a=0; $a < count($data_child[$i]); $a++)
														@php
															$x = $data_child[$i][$a];
														@endphp
														<tr>
															<td valign="top" width="12%">{{ @$x->coa->code }}</td>
															<td valign="top" width="17%">{{ @$x->coa->name }}</td>
															<td valign="top" width="31%">{{ @$x->coa->description }}</td>
															<td valign="top" width="20%">{{ number_format(@$x->debit, 0, 0, '.') }}</td>
															<td valign="top" width="20%">{{ number_format(@$x->credit, 0, 0, '.') }}</td>
														</tr>
													@endfor
                        </table>
                    </div>
                </div>

                <div class="content5">
                    <div class="container">
                        <p style="font-size:12px">Terbilang dalam Rupiah maupun Dollar</p>
                    </div>
                </div>
            </div>
        @endfor
    @endif
</body>
</html>
