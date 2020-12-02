<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inventory Expense Report</title>
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
            margin-bottom: 1.5cm;
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


        #content2 thead tr td{
            border-bottom: 2px solid black;
            font-weight: bold;
        }
        #content2 tbody tr td{
            border-bottom: 1px solid grey;
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
                            INVENTORY EXPENSE DETAILS
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

    <div id="content2">
        <div class="container">
            <table cellpadding="4" width="100%" page-break-inside: auto;>
                <thead>
                    <tr>
                        <td align="center" width="1%">No.</td>
                        <td align="center">Transaction No.</td>
                        <td align="center">Part Number</td>
                        <td align="center" width="20%">Items Name</td>
                        <td align="center" width="8%">Qty</td>
                        <td align="center" width="8%">Unit</td>
                        <td align="center">Amount</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($main_project->items as $item_index => $item_row)
                        <tr>
                            <td align="center" valign="top">{{ $item_index + 1 }}</td>
                            <td valign="top">{{ $item_row->transaction_number }}</td>
                            <td align="center" valign="top">{{ $item_row->code }}</td>
                            <td valign="top">{{ $item_row->name }}</td>
                            <td align="center" valign="top">{{ $item_row->quantity }}</td>
                            <td align="center" valign="top">{{ $item_row->unit->name }}</td>
                            <td align="right" valign="top">Rp {{ number_format($item_row->price, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if (count($additional_project) > 0)
    @foreach ($additional_project as $additional_project_row)
     <div id="content" style="margin-top: 20px">
        <div class="container">
            <table width="100%">
                <tr>
                    <td width="50%" valign="top">
                        <table width="100%" cellpadding="4">
                            <tr>
                                <td valign="top" width="30%">Project No.</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">{{ $additional_project_row->code }}</td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%" valign="top">
                        <table width="100%" cellpadding="4">
                            <tr>
                                <td valign="top" width="30%">Quotation No.</td>
                                <td valign="top" width="1%">:</td>
                                <td valign="top" width="69%">{{ $additional_project_row->number }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div id="content2">
        <div class="container">
            <table cellpadding="4" width="100%" page-break-inside: auto;>
                <thead>
                    <tr>
                        <td align="center" width="1%">No.</td>
                        <td align="center">Transaction No.</td>
                        <td align="center">Part Number</td>
                        <td align="center" width="20%">Items Name</td>
                        <td align="center" width="8%">Qty</td>
                        <td align="center" width="8%">Unit</td>
                        <td align="center">Amount</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($additional_project_row->items as $item_index => $item_row)
                        <tr>
                            <td align="center" valign="top">{{ $item_index + 1 }}</td>
                            <td valign="top">{{ $item_row->transaction_number }}</td>
                            <td align="center" valign="top">{{ $item_row->code }}</td>
                            <td valign="top">{{ $item_row->name }}</td>
                            <td align="center" valign="top">{{ $item_row->quantity }}</td>
                            <td align="center" valign="top">{{ $item_row->unit->name }}</td>
                            <td align="right" valign="top">Rp {{ number_format($item_row->price, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>   
    @endforeach
    
    @endif

</body>
</html>
