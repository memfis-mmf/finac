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
use Modules\Workshop\Entities\QuotationWorkshop\QuotationWorkshop;
use Modules\Workshop\Http\Controllers\InvoiceWorkshop\InvoiceWorkshopController;

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

        $date = explode(' - ', $request->daterange);

        $start_date = Carbon::createFromFormat('d/m/Y', $date[0])->endOfDay();
        $end_date = Carbon::createFromFormat('d/m/Y', $date[1])->endOfDay();

        if ($start_date > $end_date) {
            return redirect()->back();
        }

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
                },
                'invoice_workshop' => function($invoice_workshop) use ($request) {
                    $invoice_workshop->where('status_inv', 'Approved');

                    if ($request->customer) {
                        $invoice_workshop = $invoice_workshop->where('id_customer', $request->customer);
                    }

                    if ($request->location) {
                        $invoice_workshop = $invoice_workshop->where('location', $request->location);
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
            ->orWhereHas('invoice_workshop', function($invoice_workshop) use ($request) {
                $invoice_workshop->where('status_inv', 'Approved');

                if ($request->customer) {
                    $invoice_workshop = $invoice_workshop->where('customer_id', $request->customer);
                }

                if ($request->location) {
                    $invoice_workshop = $invoice_workshop->where('location', $request->location);
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

    /**
     * @param collection $customer
     * @param date $start_date
     * @param date $end_date
     * 
     * @return array [customer, total (in IDR)]
     */
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
            $begining_balance = $customer_row->invoice()
                ->where('approve', true)
                ->where('transactiondate', '<=', $start_date)
                ->sum('grandtotal');

            $invoice_workshop = $customer_row->invoice_workshop()
                ->where('status_inv', 'Approved')
                ->where('updated_atupdated_at', '<=', $start_date)
                ->get();

            foreach ($invoice_workshop as $invoice_workshop_row) {
                $invoice_workshop_controller = new InvoiceWorkshopController();
                $qn_workshop = QuotationWorkshop::where('quotation_no', $invoice_workshop_row->ref_quo)->first();

                if ($qn_workshop->type === "Service") {
                    $summary = $invoice_workshop_controller->summaryService($invoice_workshop_row)['value_cost'];
                } else {
                    $summary = $invoice_workshop_controller->summarySale($invoice_workshop_row)['value_cost'];
                }

                $begining_balance += $summary->grand_total_rupiah;
            }

            $customer_row->begining_balance = $begining_balance;

            /**
             * set debit
             */
            $debit = $customer_row->invoice()
                ->where('approve', true)
                ->where('updated_atupdated_at', '>', $start_date)
                ->where('updated_atupdated_at', '<', $end_date)
                ->sum('grandtotal');

            $invoice_workshop = $customer_row->invoice_workshop()
                ->where('status_inv', 'Approved')
                ->where('updated_at', '>', $start_date)
                ->where('updated_at', '<', $end_date)
                ->get();

            foreach ($invoice_workshop as $invoice_workshop_row) {
                $invoice_workshop_controller = new InvoiceWorkshopController();
                $qn_workshop = QuotationWorkshop::where('quotation_no', $invoice_workshop_row->ref_quo)->first();

                if ($qn_workshop->type === "Service") {
                    $summary = $invoice_workshop_controller->summaryService($invoice_workshop_row)['value_cost'];
                } else {
                    $summary = $invoice_workshop_controller->summarySale($invoice_workshop_row)['value_cost'];
                }

                $debit += $summary->grand_total_rupiah;
            }

            $customer_row->debit = $debit;

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

        $date = explode(' - ', $request->daterange);

        $start_date = Carbon::createFromFormat('d/m/Y', $date[0])->endOfDay();
        $end_date = Carbon::createFromFormat('d/m/Y', $date[1])->endOfDay();

        if ($start_date > $end_date) {
            return redirect()->back();
        }

        $data = $this->getData($request);

        $name = 'Customer Trial Balance';
        
        $name .= ' '.str_replace('/', '-', $request->daterange);

        return Excel::download(new CustomerTBExport($data), $name.'.xlsx');
    }

}
