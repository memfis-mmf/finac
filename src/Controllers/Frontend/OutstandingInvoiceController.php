<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Department;
use Illuminate\Support\Carbon;

//use for export
use memfisfa\Finac\Model\Exports\OutstandingInvoiceExport;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Workshop\Http\Controllers\InvoiceWorkshop\InvoiceWorkshopController;

class OutstandingInvoiceController extends Controller
{
	public function convertDate($param)
	{
		$date = Carbon::createFromFormat('d-m-Y', $param)->format('Y-m-d');

		return $date;
    }

    public function getOutstandingInvoice($request)
    {
        $date = $this->convertDate($request->date);

        $department = Department::where('uuid', $request->department)->first();

        $currency = Currency::find($request->currency);

        $customer = Customer::with([
                'invoice' => function($invoice) use ($request, $department, $date) {
                    $invoice
                        ->with([
                            'quotations:id,number,term_of_payment'
                        ])
                        ->where('approve', true)
                        ->whereDate('transactiondate', '<=', $date);
                        // ->whereHas('ara.ar', function($ar) {
                        //     $ar->where('approve', true);
                        // });

                    if ($request->customer) {
                        $invoice = $invoice->where('id_customer', $request->customer);
                    }

                    if ($request->department) {
                        $invoice = $invoice->where('company_department', $department->name);
                    }
                    
                    if ($request->location) {
                        $invoice = $invoice->where('location', $request->location);
                    }

                    if ($request->currency) {
                        $invoice = $invoice->where('currency', $request->currency);
                    }
                },
                'invoice_workshop' => function($invoice_workshop) use ($request, $date) {
                    $invoice_workshop
                        ->where('status_inv', 'Approved')
                        ->whereDate('date', '<=', $date);

                    if ($request->customer) {
                        $_customer = Customer::whereIn('id', $request->customer)->get()->pluck('uuid');
                        $invoice_workshop = $invoice_workshop->whereIn('general_ori->>uuid', $_customer);
                    }

                    if ($request->location) {
                        $invoice_workshop = $invoice_workshop->where('location', $request->location);
                    }

                    if ($request->currency) {
                        $invoice_workshop = $invoice_workshop->where('currency_id', $request->currency);
                    }
                }
            ])
            ->whereHas('invoice', function($invoice) use($request, $department, $date) {
                $invoice->where('approve', true)
                    ->whereDate('transactiondate', '<=', $date);
                    // ->whereHas('ara.ar', function($ar) {
                    //     $ar->where('approve', true);
                    // });

                if ($request->customer) {
                    $invoice = $invoice->where('id_customer', $request->customer);
                }

                if ($request->department) {
                    $invoice = $invoice->where('company_department', $department->name);
                }
                
                if ($request->location) {
                    $invoice = $invoice->where('location', $request->location);
                }

                if ($request->currency) {
                    $invoice = $invoice->where('currency', $request->currency);
                }
            })
            ->orWhereHas('invoice_workshop', function($invoice_workshop) use($request, $date) {
                $invoice_workshop->where('status_inv', 'Approved')
                    ->whereDate('date', '<=', $date);

                if ($request->customer) {
                    $_customer = Customer::whereIn('id', $request->customer)->get()->pluck('uuid');
                    $invoice_workshop = $invoice_workshop->whereIn('general_ori->>uuid', $_customer);
                }

                if ($request->location) {
                    $invoice_workshop = $invoice_workshop->where('location', $request->location);
                }

                if ($request->currency) {
                    $invoice_workshop = $invoice_workshop->where('currency_id', $request->currency);
                }
            });

        if ($request->customer) {
            $customer = $customer->whereIn('id', $request->customer);
        }
            
        $customer = $customer->get()
            ->transform(function($row) {
                $arr = [];

                $invoice_from_workshop = [];
                foreach ($row->invoice_workshop as $invoice_workshop_row) {
                    $invoice_workshop_class = new InvoiceWorkshopController();

                    //jika invoice service
                    if ($invoice_workshop_row->quotation->type == 'Service') {
                        $invoice_total = $invoice_workshop_class->summaryService($invoice_workshop_row)['value_cost'];
                    }

                    //jika invoice sale
                    if ($invoice_workshop_row->quotation->type == 'Sales') {
                        $invoice_total = $invoice_workshop_class->summarySale($invoice_workshop_row)['value_cost'];
                    }

                    $invoice_from_workshop[] = (object)[
                        'transactionnumber' => $invoice_workshop_row->invoice_no,
                        'transactiondate' => $invoice_workshop_row->date,
                        'due_date' => $invoice_workshop_row->due_date,
                        'quotations' => $invoice_workshop_row->quotation,
                        'currencies' => $invoice_workshop_row->currency,
                        'exchangerate' => $invoice_workshop_row->exchange_rate,
                        'grandtotalforeign' => $invoice_total->grand_total,
                        'ppnvalue' => $invoice_total->vat_total,
                        'ending_balance' => [
                            'amount' => $invoice_total->grand_total - $invoice_workshop_row->ar_amount['credit'],
                            'amount_idr' => $invoice_total->grand_total_rupiah - $invoice_workshop_row->ar_amount['credit_idr'],
                        ]
                    ];
                }

                if (count($row->invoice) > 0) {
                    $row->invoice->concat(collect($invoice_from_workshop));
                } else {
                    $row->invoice = $invoice_from_workshop;
                }

                // looping sebanyak invoice HM
                foreach ($row->invoice as $invoice_row) {
                    $currency_code = $invoice_row->currencies->code;

                    $due_date = ($invoice_row->due_date != '-')? Carbon::parse($invoice_row->due_date): Carbon::parse($invoice_row->transactiondate);
                    $now = Carbon::now();

                    $style = '';
                    if ($now > $due_date) {
                        $style = 'color:red';
                    }

                    $due_date_formated = $due_date->format('d F Y');

                    $invoice_row->due_date_formated = '<span style="'.$style.'">'.$due_date_formated.'</span>';
                    $invoice_row->due_date = $due_date;

                    // jika currency belum masuk arr
                    if (@count($arr[$currency_code]) < 1) {

                        $arr[$currency_code] = [
                            'symbol' => $invoice_row->currencies->symbol,
                            'grandtotalforeign' => $invoice_row->grandtotalforeign,
                            'ppnvalue' => $invoice_row->ppnvalue,
                            'ending_value' => $invoice_row->ending_balance['amount'],
                        ];
                    } else {
                        $current = $arr[$currency_code];

                        $arr[$currency_code] = [
                            'symbol' => $invoice_row->currencies->symbol,
                            'grandtotalforeign' => $current['grandtotalforeign'] + $invoice_row->grandtotalforeign,
                            'ppnvalue' => $current['ppnvalue'] + $invoice_row->ppnvalue,
                            'ending_value' => $current['ending_value'] + $invoice_row->ending_balance['amount'],
                        ];
                    }

                }

                $row->sum_total = $arr;

                return $row;

            });

        $data = [
            'customer' => $customer,
            'date' => $date,
            'request' => $request,
            'department' => $department->name ?? NULL,
            'currency' => $currency->name ?? NULL
        ];

        return $data;
    }

    public function outstandingInvoice(Request $request)
    {
        if (
            !$request->date
        ) {
            return redirect()->back();
        }

        $data = $this->getOutstandingInvoice($request);
        $data['export'] = route('fa-report.outstanding-invoice-export', $request->all());
        $data['print'] = route('fa-report.outstanding-invoice-print', $request->all());

        // dd($data);
        
        return view('arreport-outstandingview::index', $data);
    }

    public function outStandingInvoiceExport(Request $request)
    {
        $data = $this->getOutstandingInvoice($request);
        $date = str_replace('/', '-', $request->date);

        // return view('arreport-accountrhview::export', $data);
		return Excel::download(new OutstandingInvoiceExport($data), "Outstanding Invoice $date.xlsx");
    }

    public function outstandingInvoicePrint(Request $request)
    {
        $data = $this->getOutstandingInvoice($request);

        $pdf = \PDF::loadView('formview::outstanding-invoices', $data);
        return $pdf->stream();
    }

}
