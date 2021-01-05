<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Department;
use Carbon\Carbon;
use memfisfa\Finac\Model\AReceiveA;

//use for export
use App\Models\Export\CustomerTBExport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerTrialBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function print(Request $request)
    {
        $request->validate([
            'daterange'=> 'required'
        ]);

        $data = $this->getData($request);

        $pdf = \PDF::loadView('formview::customer-tb', $data);
        return $pdf->stream();
    }

    public function getData($request)
    {
        $date = explode(' - ', $request->daterange);

        $start_date = Carbon::createFromFormat('d/m/Y', $date[0])->endOfDay();
        $end_date = Carbon::createFromFormat('d/m/Y', $date[1])->endOfDay();

        $department = Department::where('uuid', $request->department)->first();

        $customer = Customer::with([
                'invoice' => function($invoice) use ($request, $department) {
                    $invoice->where('approve', 1);

                    if ($request->customer) {
                        $invoice = $invoice->where('id_customer', $request->customer);
                    }

                    if ($request->department) {
                        $invoice = $invoice->where('company_department', $department->name);
                    }
                    
                    if ($request->location) {
                        $invoice = $invoice->where('location', $request->location);
                    }
                }
            ])
            ->whereHas('invoice', function($invoice) use ($request, $department) {
                $invoice->where('approve', 1);

                if ($request->customer) {
                    $invoice = $invoice->where('id_customer', $request->customer);
                }

                if ($request->department) {
                    $invoice = $invoice->where('company_department', $department->name);
                }
                
                if ($request->location) {
                    $invoice = $invoice->where('location', $request->location);
                }
            })
            ->get();

        $get_amount = $this->getAmount($customer, $start_date, $end_date);

        $data['customer'] = $get_amount['customer'];
        $data['total'] = $get_amount['total'];
        $data['start_date'] = Carbon::createFromFormat('d/m/Y', $date[0])->format('d F Y');
        $data['end_date'] = Carbon::createFromFormat('d/m/Y', $date[1])->format('d F Y');
        $data['department'] = $department->name ?? NULL;
        $data['current_date'] = date('d F Y H:i');
        $data['request'] = $request;

        return $data;
    }

    public function getAmount($customer, $start_date, $end_date)
    {
        $total = [
            'begining_balance' => 0,
            'debit' => 0,
            'credit' => 0,
            'ending_balance' => 0,
        ];

        foreach ($customer as $customer_row) {
            /**
             * mengambil grandtotal IDR dari invoice
             */
            $customer_row->begining_balance = $begining_balance = $customer_row->invoice()
                ->where('approve', true)
                ->where('updated_at', '<=', $start_date)
                ->sum('grandtotal');

            $customer_row->debit = $debit = $customer_row->invoice()
                ->where('approve', true)
                ->where('updated_at', '>', $start_date)
                ->where('updated_at', '<', $end_date)
                ->sum('grandtotal');

            $customer_row->credit = $credit = AReceiveA::whereHas('ar', function($ar) use($customer_row) {
                    $ar->where('id_customer', $customer_row->id);
                })
                ->sum('credit_idr');

            $customer_row->ending_balance = $ending_balance = $begining_balance + $debit - $credit;

            $total['begining_balance'] += $begining_balance;
            $total['debit'] += $debit;
            $total['credit'] += $credit;
            $total['ending_balance'] += $ending_balance;

        }

        return [
            'customer' => $customer,
            'total' => (object) $total
        ];
    }

    public function export(Request $request)
    {
        $request->validate([
            'daterange'=> 'required'
        ]);

        $data = $this->getData($request);

        $name = 'Customer Trial Balance';
        
        if ($request->uuid) {
            $name .= ' '.str_replace('/', '-', $request->daterange);
        }

        return Excel::download(new CustomerTBExport($data), $name.'.xlsx');
    }

}
