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
use memfisfa\Finac\Model\Invoice;

class OutstandingInvoiceController extends Controller
{
	public function convertDate($param)
	{
		$tmp_date = new Carbon($param);
		$date = $tmp_date->format('Y-m-d');

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
                        ->whereDate('transactiondate', '<=', $date)
                        ->whereHas('ara.ar', function($ar) {
                            $ar->where('approve', true);
                        });

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
                }
            ])
            ->whereHas('invoice', function($invoice) use($request, $department, $date) {
                $invoice->where('approve', true)
                    ->whereDate('transactiondate', '<=', $date)
                    ->whereHas('ara.ar', function($ar) {
                        $ar->where('approve', true);
                    });

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
            ->get();

        foreach ($customer as $customer_row) {
            $arr = [];
            foreach ($customer_row->invoice as $invoice_row) {
                $currency_code = $invoice_row->currencies->code;

                $due_date = Carbon::parse($invoice_row->due_date);
                $now = Carbon::now();

                $style = '';
                if ($now > $due_date) {
                    $style = 'color:red';
                }

                $invoice_row->due_date_formated = '<span style="'.$style.'">'.Carbon::parse($invoice_row->due_date)->format('d F Y').'</span>';

                // jika currency belum masuk arr
                if (@count($customer_row->sum_total[$currency_code]) < 1) {
                    $arr[$currency_code] = [
                        'symbol' => $invoice_row->currencies->symbol,
                        'grandtotalforeign' => $invoice_row->grandtotalforeign,
                        'ppnvalue' => $invoice_row->ppnvalue,
                        'ending_value' => $invoice_row->ending_balance['amount_idr'],
                    ];
                } else {
                    $current = $arr[$currency_code];

                    $arr[$currency_code] = [
                        'grandtotalforeign' => $current['grandtotalforeign'] + $invoice_row->grandtotalforeign,
                        'ppnvalue' => $current['ppnvalue'] + $invoice_row->ppnvalue,
                        'ending_value' => $current['ending_value'] + $invoice_row->ending_balance['amount_idr'],
                    ];
                }

            }

            $customer_row->sum_total = $arr;
        }

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
