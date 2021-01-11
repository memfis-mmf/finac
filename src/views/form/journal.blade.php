<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$journal->voucher_no}} - Journal</title>
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
            top:8px;
            left: 220px;
            position: absolute;
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
            margin-bottom:30px;
        }

        #content2 #journal_table tr td{
            border-left:  1px solid  #d4d7db;
            border-right:  1px solid  #d4d7db;
            border-top:  1px solid  #d4d7db;
            border-bottom:  1px solid  #d4d7db;
        }

        #content2 table .kredit-debet{
            border-left:  2px solid  #d4d7db;
            border-right:  2px solid  #d4d7db;
            border-top:  2px solid  #d4d7db;
            border-bottom:  2px solid  #d4d7db;
        }

        .page_break {
            page-break-before: always;
        }

        footer .num:after { 
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
                    <td width="55%" valign="middle" style="font-size:12px;line-height:20px;">
                        Juanda International Airport, Surabaya Indonesia
                        <br>
                        Phone : 031-8686482 &nbsp;&nbsp;&nbsp; Fax : 031-8686500
                        <br>
                        Email : marketing@ptmmf.co.id
                        <br>
                        Website : www.ptmmf.co.id
                    </td>
                    <td width="45%" valign="top" align="center">
                        <h1 style="font-size:26px;">JOURNAL</h1>
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <footer>
        <img src="./vendor/courier/img/form/journal/Footer.png" width="100%" alt="" >
        <div class="footer-container">
            <div id="footer">
                <table width="100%">
                    <tr>
                        <td>  <span style="margin-left:6px;">Created By : {{ @$journal->created_by->name }} ;  &nbsp;&nbsp;&nbsp; Approved By : {{ @$journal->approved_by->name }} ; </span> </td>
                        <td align="right">Page <span class="num"></span></td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>

    <div id="content">
        <div class="container">
            <table width="100%" cellpadding="4" style="font-size:12px;">
                <tr>
                    <td valign="top" width="20%">Date</td>
                    <td valign="top"width="1%">:</td>
                    <td valign="top" width="29%">{{ $journal->transaction_date }}</td>
                    <td valign="top" width="20%">Ref. Doc</td>
                    <td valign="top"width="1%">:</td>
                    <td valign="top" width="29%">{{ $journal->ref_no }}</td>
                </tr>
                <tr>
                    <td valign="top" width="20%">Transaction No.</td>
                    <td valign="top"width="1%">:</td>
                    <td valign="top" width="29%">{{ $journal->voucher_no }}</td>
                    <td valign="top" width="20%"></td>
                    <td valign="top"width="1%"></td>
                    <td valign="top" width="29%"></td>
                </tr>
            </table>
        </div>
    </div>

    <div id="content2">
        <div class="container">
            <table width="100%" cellpadding="6" id="journal_table" page-break-inside: auto;>
                <thead>
                    <tr style="background:#72829c;color:white;">
                        <th valign="top" align="center" width="4%">No</th>
                        <th valign="top" align="center" width="13%">Account Code</th>
                        <th valign="top" align="center" width="19%">Account Description</th>
                        <th valign="top" align="center" width="24%">Description</th>
                        <th valign="top" align="center" width="20%">Debit</th>
                        <th valign="top" align="center" width="20%">Credit</th>
                    </tr>
                </thead>
                <tbody>
								@for ($i=0; $i < count($journala); $i++)
									@php
										$x = $journala[$i];
									@endphp
	                <tr>
	                    <td valign="top" align="center" width="4%">{{ $i+1 }}</td>
	                    <td valign="top" align="center" width="13%">{{ $x->coa->code }}</td>
	                    <td valign="top" width="19%">{{ $x->coa->name }}</th>
	                    <td valign="top"  width="24%">{{ $x->description }}</td>
	                    <td valign="top" align="right" width="20%">{{ ($x->debit == 0)? '': "Rp. ".number_format($x->debit * $journal->exchange_rate, 0, ',', '.').",-" }}</td>
	                    <td valign="top" align="right" width="20%">{{ ($x->credit == 0)? '': "Rp. ".number_format($x->credit * $journal->exchange_rate, 0, ',', '.').",-" }}</td>
	                </tr>
                                @endfor
                </tbody>
            </table>
            <table width="100%" cellpadding="6">
                <tr>
                    <td valign="top" align="right" width="60%"><b>Total</b></td>
                    <td valign="top" align="right" width="" colspan="2" class="kredit-debet">Rp. {{ number_format($debit * $journal->exchange_rate, 0, ',', '.') }},-</td>
                </tr>
            </table>
        </div>
    </div>

</body>
</html>
