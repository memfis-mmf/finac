<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Department;
use Carbon\Carbon;
use memfisfa\Finac\Model\TrxJournalA;

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

        $start_date = Carbon::createFromFormat('d/m/Y', $date[0])->addDay();
        $end_date = Carbon::createFromFormat('d/m/Y', $date[1]);

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

        $get_amount = $this->getAmount($customer, [$start_date, $end_date]);

        $data['customer'] = $get_amount['customer'];
        $data['total'] = $get_amount['total'];
        $data['start_date'] = Carbon::createFromFormat('d/m/Y', $date[0])->format('d F Y');
        $data['end_date'] = Carbon::createFromFormat('d/m/Y', $date[1])->format('d F Y');
        $data['department'] = $department->name ?? NULL;
        $data['current_date'] = date('d F Y H:i');
        $data['request'] = $request;

        return $data;
    }

    public function getAmount($customer, $date)
    {
        $begining_balance_total = 0;
        $journal_debit_total = 0;
        $journal_credit_total = 0;
        $ending_balance_total = 0;

        foreach ($customer as $customer_row) {
            $invoice_number = $customer_row
                ->invoice
                ->pluck('transactionnumber')
                ->all();

            // get begining balance
            $begining_debit = TrxJournalA::whereHas('journal', function($journal) use($invoice_number, $date) {
                    $journal->whereIn('ref_no', $invoice_number)
                        ->where('approve', 1)
                        ->where('transaction_date', '<', $date[0]);
                })
                ->get()
                ->sum(function($row) {
                    return $row->debit * $row->journal->exchange_rate;
                });

            $begining_credit = TrxJournalA::whereHas('journal', function($journal) use($invoice_number, $date) {
                    $journal->whereIn('ref_no', $invoice_number)
                        ->where('approve', 1)
                        ->where('transaction_date', '<', $date[0]);
                })
                ->get()
                ->sum(function($row) {
                    return $row->credit * $row->journal->exchange_rate;
                });

            $customer_row->begining_balance = $begining_debit - $begining_credit;

            $begining_balance_total += $customer_row->begining_balance;

            // get debit and credit in journal
            $customer_row->journal_debit = TrxJournalA::whereHas('journal', function($journal) use($invoice_number, $date) {
                    $journal->whereIn('ref_no', $invoice_number)
                        ->where('approve', 1)
                        ->whereBetween('transaction_date', $date);
                })
                ->get()
                ->sum(function($row) {
                    return $row->debit * $row->journal->exchange_rate;
                });

            $journal_debit_total += $customer_row->journal_debit;

            $customer_row->journal_credit = TrxJournalA::whereHas('journal', function($journal) use($invoice_number, $date) {
                    $journal->whereIn('ref_no', $invoice_number)
                        ->where('approve', 1)
                        ->whereBetween('transaction_date', $date);
                })
                ->get()
                ->sum(function($row) {
                    return $row->credit * $row->journal->exchange_rate;
                });

            $journal_credit_total += $customer_row->journal_credit;

            $customer_row->ending_balance = $customer_row->begining_balance - ($customer_row->journal_debit - $customer_row->journal_credit);

            $ending_balance_total += $customer_row->ending_balance;
        }

        return [
            'customer' => $customer,
            'total' => (object) [
                'begining_balance_total' => $begining_balance_total,
                'journal_debit_total' => $journal_debit_total,
                'journal_credit_total' => $journal_credit_total,
                'ending_balance_total' => $ending_balance_total,
            ]
        ];

    }

}
