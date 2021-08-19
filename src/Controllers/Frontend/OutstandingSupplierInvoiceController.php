<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Vendor;
use App\Models\Department;
use Illuminate\Support\Carbon;

//use for export
use memfisfa\Finac\Model\Exports\OutstandingSupplierInvoiceExport;
use Maatwebsite\Excel\Facades\Excel;

class OutstandingSupplierInvoiceController extends Controller
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

        $vendor = Vendor::with([
                'supplier_invoice' => function($supplier_invoice) use ($request, $department, $date, $currency) {
                    $supplier_invoice
                        ->where('approve', true)
                        ->whereDate('transaction_date', '<=', $date);

                    if ($request->vendor) {
                        $supplier_invoice = $supplier_invoice->whereIn('id_supplier', $request->vendor);
                    }

                    if ($request->department) {
                        $supplier_invoice = $supplier_invoice->where('company_department', $department->name);
                    }
                    
                    if ($request->location) {
                        $supplier_invoice = $supplier_invoice->where('location', $request->location);
                    }

                    if ($request->currency) {
                        $supplier_invoice = $supplier_invoice->where('currency', $currency->code);
                    }
                },
            ])
            ->whereHas('supplier_invoice', function($supplier_invoice) use($request, $department, $date, $currency) {
                $supplier_invoice->where('approve', true)
                    ->whereDate('transaction_date', '<=', $date);

                if ($request->vendor) {
                    $supplier_invoice = $supplier_invoice->whereIn('id_supplier', $request->vendor);
                }

                if ($request->department) {
                    $supplier_invoice = $supplier_invoice->where('company_department', $department->name);
                }
                
                if ($request->location) {
                    $supplier_invoice = $supplier_invoice->where('location', $request->location);
                }

                if ($request->currency) {
                    $supplier_invoice = $supplier_invoice->where('currency', $currency->code);
                }
            });

        if ($request->vendor) {
            $vendor = $vendor->whereIn('id', $request->vendor);
        }

        $vendor = $vendor
            ->get();

        foreach ($vendor as $vendor_row) {
            $arr = [];

            // looping sebanyak inovice HM
            foreach ($vendor_row->supplier_invoice as $supplier_invoice_row) {
                $currency_code = $supplier_invoice_row->currencies->code;

                $due_date = ($supplier_invoice_row->due_date != '-')? Carbon::parse($supplier_invoice_row->due_date): Carbon::parse($supplier_invoice_row->transactiondate);
                $now = Carbon::now();

                $style = '';
                if ($now > $due_date) {
                    $style = 'color:red';
                }

                $due_date_formated = $due_date->format('d F Y');

                $supplier_invoice_row->due_date_formated = '<span style="'.$style.'">'.$due_date_formated.'</span>';
                $supplier_invoice_row->due_date = $due_date;

                // jika currency belum masuk arr
                if (@count($arr[$currency_code]) < 1) {
                    $arr[$currency_code] = [
                        'symbol' => $supplier_invoice_row->currencies->symbol,
                        'grandtotal_foreign' => $supplier_invoice_row->grandtotal_foreign,
                        'ppnvalue' => $supplier_invoice_row->ppnvalue,
                        'ending_value' => $supplier_invoice_row->ending_balance['amount_idr'],
                    ];
                } else {
                    $current = $arr[$currency_code];

                    $arr[$currency_code] = [
                        'symbol' => $supplier_invoice_row->currencies->symbol,
                        'grandtotal_foreign' => $current['grandtotal_foreign'] + $supplier_invoice_row->grandtotal_foreign,
                        'ppnvalue' => $current['ppnvalue'] + $supplier_invoice_row->ppnvalue,
                        'ending_value' => $current['ending_value'] + $supplier_invoice_row->ending_balance['amount_idr'],
                    ];
                }

            }

            $vendor_row->sum_total = $arr;
        }

        $data = [
            'vendor' => $vendor,
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
        $data['export'] = route('fa-report.outstanding-supplier-invoice-export', $request->all());
        $data['print'] = route('fa-report.outstanding-supplier-invoice-print', $request->all());

        // dd($data['vendor'][0]->supplier_invoice[0]);
        
        return view('arreport-outstandingview::index-ap', $data);
    }

    public function outStandingInvoiceExport(Request $request)
    {
        $data = $this->getOutstandingInvoice($request);
        $date = str_replace('/', '-', $request->date);

        // return view('arreport-accountrhview::export', $data);
		return Excel::download(new OutstandingSupplierInvoiceExport($data), "Outstanding Supplier Invoice $date.xlsx");
    }

    public function outstandingInvoicePrint(Request $request)
    {
        $data = $this->getOutstandingInvoice($request);

        $pdf = \PDF::loadView('formview::outstanding-invoices-ap', $data);
        return $pdf->stream();
    }

}
