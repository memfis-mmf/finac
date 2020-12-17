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

class OutstandingInvoiceController extends Controller
{
	public function convertDate($date)
	{
		$tmp_date = explode('-', $date);

		$start = new Carbon(str_replace('/', "-", trim($tmp_date[0])));
		$startDate = $start->format('Y-m-d');

		$end = new Carbon(str_replace('/', "-", trim($tmp_date[1])));
		$endDate = $end->format('Y-m-d');

		return [
			$startDate,
			$endDate
		];
    }

    public function getOutstandingInvoice($request)
    {
        $date = $this->convertDate($request->daterange);

        $department = Department::where('uuid', $request->department)->first();

        $currency = Currency::find($request->currency);

        $customer = Customer::with([
                'invoice' => function($invoice) use ($request, $department, $date) {
                    $invoice
                        ->with([
                            'quotations:id,number'
                        ])
                        ->where('approve', true)
                        ->whereBetween('transactiondate', $date);

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
                    ->whereBetween('transactiondate', $date);

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

        $data = [
            'customer' => $customer,
            'date' => $date,
            'request' => $request,
            'department' => $department->name ?? NULL,
            'currency' => $currency->name ?? NULL
        ];

        return $data;
    }

    public function arHistory(Request $request)
    {
        if (
            !$request->daterange 
        ) {
            return redirect()->back();
        }

        $data = $this->getOutstandingInvoice($request);
        $data['export'] = route('fa-report.ar-history-export', $request->all());
        
        return view('arreport-accountrhview::index', $data);
    }

    public function arHistoryExport(Request $request)
    {
        $data = $this->getOutstandingInvoice($request);

        $startDate = Carbon::parse($data['date'][0])->format('d F Y');
        $endDate = Carbon::parse($data['date'][1])->format('d F Y');

        // return view('arreport-accountrhview::export', $data);
		return Excel::download(new OutstandingInvoiceExport($data), "Invoice Outstanding $startDate - $endDate.xlsx");
    }

}
