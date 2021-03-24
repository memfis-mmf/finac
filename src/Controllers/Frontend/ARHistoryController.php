<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Department;
use Illuminate\Support\Carbon;

//use for export
use memfisfa\Finac\Model\Exports\ARHistoryExport;
use Maatwebsite\Excel\Facades\Excel;

class ARHistoryController extends Controller
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

    public function getArHistory($request)
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
            ->get()
            ->transform(function($row) {
                $invoice_currency = [];

                foreach ($row->invoice as $invoice_row) {

                    $total_profit = $invoice_row->totalprofit;
                    $discount = $total_profit->where('type', 'discount')->first();
                    $ppn = $total_profit->where('type', 'ppn')->first();

                    $discount_value = $discount->amount ?? 0;
                    $ppn_value = $ppn->amount ?? 0;

                    if (isset($invoice_currency[$invoice_row->currencies->code])) {
                        $invoice_currency_current = $invoice_currency[$invoice_row->currencies->code];

                        $arr_tmp = [
                            'currency' => $invoice_row->currencies,
                            'discount_total' =>
                                $invoice_currency_current['discount_total'] 
                                + $discount_value,
                            'vat_total' =>
                                $invoice_currency_current['vat_total'] 
                                + $ppn_value, 
                            'invoice_total' =>
                                $invoice_currency_current['invoice_total'] 
                                + $invoice_row->grandtotalforeign, 
                            'paid_amount_total' =>
                                $invoice_currency_current['paid_amount_total'] 
                                + $invoice_row->ar_amount['credit'], 
                            'ending_balance_total' =>
                                $invoice_currency_current['ending_balance_total'] 
                                + $invoice_row->ending_balance['amount'], 
                            'ending_balance_total_idr' =>
                                $invoice_currency_current['ending_balance_total_idr'] 
                                + $invoice_row->ending_balance['amount_idr'], 
                        ];

                        $invoice_currency[$invoice_row->currencies->code] = $arr_tmp;
                    } else {
                        $invoice_currency[$invoice_row->currencies->code] = [
                            'currency' => $invoice_row->currencies,
                            'discount_total' => $discount_value,
                            'vat_total' => $ppn_value, 
                            'invoice_total' => $invoice_row->grandtotalforeign, 
                            'paid_amount_total' => $invoice_row->ar_amount['credit'], 
                            'ending_balance_total' => $invoice_row->ending_balance['amount'], 
                            'ending_balance_total_idr' => $invoice_row->ending_balance['amount_idr'],                     
                        ];
                    }

                }

                $row->total = $invoice_currency;

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

    public function arHistory(Request $request)
    {
        if (
            !$request->daterange 
        ) {
            return redirect()->back();
        }

        $data = $this->getArHistory($request);
        $data['export'] = route('fa-report.ar-history-export', $request->all());
        $data['print'] = route('fa-report.ar-history-print', $request->all());
        $data['controller'] = new Controller();
        
        return view('arreport-accountrhview::index', $data);
    }

    public function arHistoryPrint(Request $request)
    {
        if (
            !$request->daterange 
        ) {
            return redirect()->back();
        }

        $data = $this->getArHistory($request);
        $data['carbon'] = Carbon::class;
        $data['controller'] = new Controller();
        
        $pdf = \PDF::loadView('formview::ar-history', $data);
        return $pdf->stream();
    }

    public function arHistoryExport(Request $request)
    {
        if (
            !$request->daterange 
        ) {
            return redirect()->back();
        }

        $data = $this->getArHistory($request);

        $startDate = Carbon::parse($data['date'][0])->format('d F Y');
        $endDate = Carbon::parse($data['date'][1])->format('d F Y');

        $data['carbon'] = Carbon::class;
        $data['controller'] = new Controller();

        // return view('arreport-accountrhview::export', $data);
		return Excel::download(new ARHistoryExport($data), "AR History $startDate - $endDate.xlsx");
    }

}
