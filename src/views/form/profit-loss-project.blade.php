<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profit Loss Project</title>
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
            margin-bottom: 1cm;
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

        .container{
            width: 100%;
            margin: 0 36px;
        }

        .barcode{
            margin-left:70px;
            margin-top:12px;
        }

        #content{
            color:blue;
            font-weight: 700;
            margin-bottom:20px;
        }

        #content2 .total-left{
            padding-left:30px;
            font-weight: bold;
        }

        #content2 .total-right{
            padding-right:30px;
            font-weight: bold;
        }

        #content3{
            margin-top:15px;
            color:red;
            font-weight: bold;
            font-size: 16px;
        }

        #content3 table{
            text-align: right;
        }

        #additional-project{
            margin-bottom: 15px;
        }

        #additional-project legend{
            font-weight: bold; 
            color:red; 
            font-size: 14px;
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
        <img src="./vendor/courier/img/form/printoutfa/HeaderFA-A4-Potrait.png" alt=""width="100%">
        <div id="head">
            <table width="95%">
                <tr>
                    <td valign="top" align="center">
                        <h1 style="font-size:24px;">
                            PROFIT & LOSS PROJECT
                        </h1>
                    </td>
                </tr>
            </table>
        </div>
    </header>

    <footer>
        <div class="container" style="margin-bottom:6px;">
            <table width="100%">
                <tr>
                    <td>Print on March 25 2020 18.53</td>
                    <td align="right">Page <span class="num"></span></td>
                </tr>
            </table>
        </div>

        <img src="./vendor/courier/img/form/printoutfa/FooterFA-A4-Potrait.png" width="100%" alt="" >
    </footer>

    <div id="content">
        <div class="container">
            <table width="100%">
                <tr>
                    <td width="50%" valign="top">
                        <table width="100%" cellpadding="4">
                            <tr>
                                <td valign="top" width="30%">Project Title</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">{{ $main_project->title }}</td>
                            </tr>
                            <tr>
                                <td valign="top" width="30%">Project No.</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">{{ $main_project->code }}</td>
                            </tr>
                            <tr>
                                <td valign="top" width="30%">Quotation No.</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">{{ $quotation->number }}</td>
                            </tr>
                            <tr>
                                <td valign="top" width="30%">Work Order No.</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">{{ $main_project->no_wo }}</td>
                            </tr>
                            <tr>
                                <td valign="top" width="30%">Invoice No.</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">{{ $invoice->transactionnumber ?? '-' }}</td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%" valign="top">
                        <table width="100%" cellpadding="4">
                            <tr>
                                <td valign="top" width="30%">A/C Type</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">{{ $main_project->aircraft->code }}</td>
                            </tr>
                            <tr>
                                <td valign="top" width="30%">A/C Reg</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">{{ $main_project->aircraft_register }}</td>
                            </tr>
                            <tr>
                                <td valign="top" width="30%">A/C Serial No.</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">{{ $main_project->aircraft_sn }}</td>
                            </tr>
                            {{-- <tr>
                                <td valign="top" width="30%">Start Date</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">generated</td>
                            </tr>
                            <tr>
                                <td valign="top" width="30%">End Date</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">generated</td>
                            </tr> --}}
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    @if (count($additional_project) > 0)
    <div id="additional-project">
        <div class="container">
            <fieldset style="padding:15px;">
                <legend>Additional Project Information</legend>
                    <table width="100%" cellpadding="4" page-break-inside: auto;>
                        <thead style="background:#ededed;">
                            <tr>
                                <td align="center" width="25%">Additional Project No.</td>
                                <td align="center" width="25%">Additional Quotation No.</td>
                                <td align="center" width="20%">Invoice No.</td>
                                {{-- <td align="center" width="15%">Start Date</td>
                                <td align="center" width="15%">End Date</td> --}}
                            </tr>
                        </thead>
                        <tbody style="font-size: 10px">
                            @foreach ($additional_project as $additional_project_row)
                                <tr>
                                    <td valign="top">{{ $additional_project_row->number }}</td>
                                    <td valign="top">{{ $additional_project_row->quotation->number }}</td>
                                    <td valign="top">{{ $additional_project_row->invoice->transactionnumber }}</td>
                                    {{-- <td valign="top" align="center">2020/01/02</td>
                                    <td valign="top" align="center">2020/01/02</td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </fieldset>
        </div>
    </div>
    @endif

    <div id="content2">
        <div class="container">
            <table cellpadding="4" width="100%" page-break-inside: auto;>
                <thead style="background:#ededed;">
                    <tr>
                        <td width="40%" height="20" valign="middle" style="padding-left:102px"><b>Description</b></td>
                        <td width="60%" height="20" valign="middle" align="right" style="padding-right:80px"><b>Amount</b></td>
                    </tr>
                </thead>
                <tbody>

                    {{-- REVENUE --}}
                    @foreach ($revenue as $revenue_row)
                        <tr>
                            <td style="padding-left:30px">{{ $revenue_row->name }}</td>
                            <td align="right" style="padding-right:30px">Rp {{ number_format($revenue_row->value, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr style="background:#7ee1f7;">
                        <td height="14" valign="middle" class="total-left">Total Revenue</td>
                        <td height="14" valign="middle" align="right" class="total-right">Rp {{ number_format($total_revenue, 2, ',', '.') }}</td>
                    </tr>


                    {{-- EXPENSE --}}
                    @foreach ($expense as $expense_row)
                        <tr>
                            <td style="padding-left:30px">{{ $expense_row->name }}</td>
                            <td align="right" style="padding-right:30px">Rp {{ number_format($expense_row->value, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr style="background:#7ee1f7;">
                        <td height="14" valign="middle" class="total-left">Total Expense</td>
                        <td height="14" valign="middle" align="right" class="total-right">Rp {{ number_format($total_expense, 2, ',', '.') }}</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <div id="content3">
        <div class="container">
            <table width="100%">
                <tr>
                    <td width="70%">TOTAL NET PROFIT</td>
                    <td width="30%" style="padding-right:30px;">Rp {{ number_format($total_revenue - $total_expense, 2, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
