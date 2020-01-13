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
            height: 1.8cm;
        }
        ul li{
            display: inline-block;
        }

        table{
            border-collapse: collapse;
        }

        #head{
            top:20px;
            left: 550px;
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
            margin-top:155px;
            margin-bottom:34px;
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

    </style>
</head>
<body>
    <header>
        <img src="./vendor/courier/img/form/journal/Header.png" alt=""width="100%">
        <div id="head">
            <div style="margin-right:20px;text-align:left;">
                <h1 style="font-size:34px;">JOURNAL</h1>
            </div>
        </div>
    </header>

    <footer>
        <table width="100%">
            <tr>
                <td>  <span style="margin-left:6px;">Created By :  ;  &nbsp;&nbsp;&nbsp; Approved By :  ; </span> </td>
            </tr>
        </table>
        <img src="./vendor/courier/img/form/journal/Footer.png" width="100%" alt="" >
    </footer>

    <div id="content">
        <div class="container">
            <table width="100%" cellpadding="4" style="font-size:15px;">
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
            <table width="100%" cellpadding="6" id="journal_table">
                <tr style="background:#72829c;color:white;">
                    <th valign="top" align="center" width="6%">No</th>
                    <th valign="top" align="center" width="15%">Account Code</th>
                    <th valign="top" align="center" width="27%">Account Description</th>
                    <th valign="top" align="center" width="20%">Description</th>
                    <th valign="top" align="center" width="16%">Debet</th>
                    <th valign="top" align="center" width="16%">Kredit</th>
                </tr>
								@for ($i=0; $i < count($journala); $i++)
									@php
										$x = $journala[$i];
									@endphp
	                <tr>
	                    <td valign="top" align="center" width="6%">{{ $i+1 }}</td>
	                    <td valign="top" align="center" width="15%">{{ $x->coa->code }}</td>
	                    <td valign="top" width="27%">{{ $x->coa->description }}</th>
	                    <td valign="top"  width="20%">{{ $x->description }}</td>
	                    <td valign="top" align="right" width="16%">{{ ($v = $x->debit < 0)? "Rp. ".number_format($v, 0, 0, '.').",-": '' }}</td>
	                    <td valign="top" align="right" width="16%">{{ ($v = $x->credit < 0)? "Rp. ".number_format($v, 0, 0, '.').",-": '' }}</td>
	                </tr>
								@endfor
            </table>
            <table width="100%" cellpadding="6">
                <tr>
                    <td valign="top" align="right" width="68%"><b>Total</b></td>
                    <td valign="top" align="right" width="" colspan="2" class="kredit-debet">Rp. {{ number_format($debit, 0, 0, '.') }},-</td>
                </tr>
            </table>
        </div>
    </div>

</body>
</html>
