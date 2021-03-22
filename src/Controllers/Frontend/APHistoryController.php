<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Vendor;
use App\Models\Department;
use Illuminate\Support\Carbon;

//use for export
use memfisfa\Finac\Model\Exports\APHistoryExport;
use Maatwebsite\Excel\Facades\Excel;

class APHistoryController extends Controller
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

        $vendor = Vendor::with([
                'supplier_invoice' => function($supplier_invoice) {
                    $supplier_invoice->where('approve', true);
                }
            ])
            ->whereHas('supplier_invoice', function($supplier_invoice) use($request, $department, $date) {
                $supplier_invoice->where('approve', true)
                    ->whereBetween('transaction_date', $date);

                if ($request->vendor) {
                    $supplier_invoice = $supplier_invoice->where('id_supplier', $request->vendor);
                }

                if ($request->currency) {
                    $supplier_invoice = $supplier_invoice->where('currency', $request->currency);
                }
            })
            ->get()
            ->transform(function($row) {
                $supplier_invoice_currency = [];

                foreach ($row->supplier_invoice as $supplier_invoice_row) {

                    if (isset($supplier_invoice_currency[$supplier_invoice_row->currencies->code])) {
                        $supplier_invoice_currency_current = $supplier_invoice_currency[$supplier_invoice_row->currencies->code];

                        $arr_tmp = [
                            'currency' => $supplier_invoice_row->currencies,
                            'discount_total' =>
                                $supplier_invoice_currency_current['discount_total'] 
                                + $supplier_invoice_row->discount_total,
                            'vat_total' =>
                                $supplier_invoice_currency_current['vat_total'] 
                                + $supplier_invoice_row->ppn_value, 
                            'invoice_total' =>
                                $supplier_invoice_currency_current['invoice_total'] 
                                + $supplier_invoice_row->grandtotal_foreign, 
                            'paid_amount_total' =>
                                $supplier_invoice_currency_current['paid_amount_total'] 
                                + $supplier_invoice_row->ap_amount['debit'], 
                            'ending_balance_total' =>
                                $supplier_invoice_currency_current['ending_balance_total'] 
                                + $supplier_invoice_row->ending_balance['amount'], 
                            'ending_balance_total_idr' =>
                                $supplier_invoice_currency_current['ending_balance_total_idr'] 
                                + $supplier_invoice_row->ending_balance['amount_idr'], 
                        ];

                        $supplier_invoice_currency[$supplier_invoice_row->currencies->code] = $arr_tmp;
                    } else {
                        $supplier_invoice_currency[$supplier_invoice_row->currencies->code] = [
                            'currency' => $supplier_invoice_row->currencies,
                            'discount_total' => $supplier_invoice_row->discount_total,
                            'vat_total' => $supplier_invoice_row->ppn_value, 
                            'invoice_total' => $supplier_invoice_row->grandtotal_foreign, 
                            'paid_amount_total' => $supplier_invoice_row->ap_amount['debit'], 
                            'ending_balance_total' => $supplier_invoice_row->ending_balance['amount'], 
                            'ending_balance_total_idr' => $supplier_invoice_row->ending_balance['amount_idr'],                     
                        ];
                    }

                }

                $row->total = $supplier_invoice_currency;

                return $row;
            });

        $data = [
            'vendor' => $vendor,
            'date' => $date,
            'request' => $request,
            'department' => $department->name ?? NULL,
            'currency' => $currency->name ?? NULL
        ];

        return $data;
    }

    public function apHistory(Request $request)
    {
        if (
            !$request->daterange 
        ) {
            return redirect()->back();
        }

        $data = $this->getArHistory($request);
        $data['export'] = route('fa-report.ap-history-export', $request->all());
        $data['print'] = route('fa-report.ap-history-print', $request->all());
        $data['controller'] = new Controller();
        
        return view('apreport-accountrhview::index', $data);
    }

    public function apHistoryPrint(Request $request)
    {
        if (
            !$request->daterange 
        ) {
            return redirect()->back();
        }

        $data = $this->getArHistory($request);
        $data['carbon'] = Carbon::class;
        
        $pdf = \PDF::loadView('formview::ap-history', $data);
        return $pdf->stream();
    }

    public function apHistoryExport(Request $request)
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

		return Excel::download(new APHistoryExport($data), "AP History $startDate - $endDate.xlsx");
    }

}
