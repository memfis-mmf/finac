<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use memfisfa\Finac\Model\AReceive;
use memfisfa\Finac\Model\AReceiveA;
use memfisfa\Finac\Model\Coa;
use memfisfa\Finac\Model\Invoice;
use App\Http\Controllers\Controller;
use App\Models\AdvancePaymentBalance;
use App\Models\Customer;
use App\Models\Currency;
use memfisfa\Finac\Model\TrxJournal;
use App\Models\Approval;
use App\Models\CashAdvanceReturn;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

//use for export
use memfisfa\Finac\Model\Exports\ARExport;
use Maatwebsite\Excel\Facades\Excel;

class ARController extends Controller
{
    public function index()
    {
        return view('accountreceivableview::index');
    }

    public function show($ar_uuid)
    {
        $data['data'] = AReceive::where(
            'uuid',
            $ar_uuid
        )->with([
            'currencies',
            'project',
        ])->first();

        $data['department'] = Department::with('type', 'parent')->get();

        $data['customer'] = Customer::all();
        $data['currency'] = Currency::selectRaw(
            'code, CONCAT(name, " (", symbol ,")") as full'
        )->whereIn('code', ['idr', 'usd'])
            ->get();

        $data['credit_total_amount'] = Invoice::where(
            'id_customer',
            $data['data']->id_customer
        )
            ->where('approve', true)
            ->sum('grandtotal');

        $areceive = AReceive::where('id_customer', $data['data']->id_customer)
            ->where('approve', true)
            ->get();

        $payment_total_amount = 0;
        for ($i = 0; $i < count($areceive); $i++) {
            $x = $areceive[$i];

            for ($j = 0; $j < count($x->ara); $j++) {
                $y = $x->ara[$j];

                $payment_total_amount += $y->credit_idr;
            }
        }

        $data['payment_total_amount'] = $payment_total_amount;
        $credit_balance = abs(($data['credit_total_amount'] - $data['payment_total_amount']));

        $class = 'danger';
        if ($credit_balance > $data['credit_total_amount']) {
            $class = 'success';
        }

        $data['credit_balance'] = "<span class='text-$class'>Rp " . number_format($credit_balance, 0, ',', '.') . "</span>";
        $data['page_type'] = 'show';

        return view('accountreceivableview::edit', $data);
    }

    public function create()
    {
        $data['customer'] = Customer::all();
        $data['department'] = Department::with('type', 'parent')->get();
        return view('accountreceivableview::create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_type' => 'required|in:bank,cash',
            'transactiondate' => 'required',
            'id_customer' => 'required',
            'accountcode' => 'required',
            'currency' => 'required',
            'exchangerate' => 'required'
        ]);

        $customer = Customer::where('id', $request->id_customer)->first();
        if (!$customer) {
            return [
                'errors' => 'Customer not found'
            ];
        }

        $request->merge([
            'id_customer' => $customer->id
        ]);

        $code = 'CRCJ';
        if ($request->payment_type == 'bank') {
            $code = 'BRCJ';
        }

        $request->merge([
            'approve' => 0,
            'transactionnumber' => AReceive::generateCode($code),
            'transactiondate' => Carbon::createFromFormat('d-m-Y', $request->transactiondate)
        ]);

        $areceive = AReceive::create($request->all());
        return response()->json($areceive);
    }

    public function edit(Request $request)
    {
        $data['data'] = AReceive::where(
            'uuid',
            $request->areceive
        )->with([
            'currencies',
            'project',
        ])->first();

        $data['department'] = Department::with('type', 'parent')->get();

        //if data already approved
        if ($data['data']->approve) {
            return abort(404);
        }

        $data['customer'] = Customer::all();
        $data['currency'] = Currency::selectRaw(
            'code, CONCAT(name, " (", symbol ,")") as full'
        )->whereIn('code', ['idr', 'usd'])
            ->get();

        $data['credit_total_amount'] = Invoice::where(
            'id_customer',
            $data['data']->id_customer
        )
            ->where('approve', true)
            ->sum('grandtotal');

        $areceive = AReceive::where('id_customer', $data['data']->id_customer)
            ->where('approve', true)
            ->get();

        $payment_total_amount = 0;
        for ($i = 0; $i < count($areceive); $i++) {
            $x = $areceive[$i];

            for ($j = 0; $j < count($x->ara); $j++) {
                $y = $x->ara[$j];

                $payment_total_amount += $y->credit_idr;
            }
        }

        $data['payment_total_amount'] = $payment_total_amount;
        $credit_balance = abs(($data['credit_total_amount'] - $data['payment_total_amount']));

        $class = 'danger';
        if ($credit_balance > $data['credit_total_amount']) {
            $class = 'success';
        }

        $data['credit_balance'] = "<span class='text-$class'>Rp " . number_format($credit_balance, 0, ',', '.') . "</span>";

        return view('accountreceivableview::edit', $data);
    }

    public function update(Request $request, AReceive $areceive)
    {
        if ($areceive->approve) {
            return abort(404);
        }

        $request->validate([
            'payment_type' => 'required|in:bank,cash',
            'transactiondate' => 'required',
            'id_customer' => 'required',
            'accountcode' => 'required',
            'currency' => 'required',
            'exchangerate' => 'required'
        ]);

        $request->merge([
            'description' => $request->ar_description,
            'transactiondate' => Carbon::createFromFormat('d-m-Y', $request->transactiondate)
        ]);

        $areceive->update($request->all());

        return response()->json($areceive);
    }

    public function destroy(AReceive $areceive)
    {
        if ($areceive->approve) {
            return abort(404);
        }

        $areceive->delete();

        return response()->json($areceive);
    }

    public function api()
    {
        $areceivedata = AReceive::all();

        return json_encode($areceivedata);
    }

    public function apidetail(AReceive $areceive)
    {
        return response()->json($areceive);
    }

    public function datatables(Request $request)
    {
        $data = AReceive::with([
                'customer',
                'ara',
                'coa',
            ])
            ->select('a_receives.*');

        if ($request->status and $request->status != 'all') {

            $status = [
                'open' => 0,
                'approved' => 1,
            ];

            $data = $data->where('approve', $status[$request->status]);
        }

        return datatables($data)
            ->filterColumn('transactiondate', function($query, $search) {
                datatables_search_date('transactiondate', $search, $query);
            })
            ->filterColumn('approved_by', function($query, $search) {
                datatables_search_approved_by($search, $query);
            })
            ->filterColumn('created_by', function($query, $search) {
                datatables_search_audits($search, $query);
            })
            ->filterColumn('updated_by', function($query, $search) {
                datatables_search_audits($search, $query);
            })
            ->addColumn('transactiondate_formated', function($row) {
                return $row->transactiondate->format('d-m-Y');
            })
            ->addColumn('transactionnumber_link', function($row) {
                $html = '<a href="'.route('areceive.show', $row->uuid).'">'.$row->transactionnumber.'</a>';

                return $html;
            })
            ->addColumn('created_by', function($row) {
                return $row->created_by;
            })
            ->addColumn('status', function($row) {
                return $row->status;
            })
            ->addColumn('url_edit', function($row) {
                return route('areceive.edit', $row->uuid);
            })
            ->addColumn('url_export', function($row) {
                return route('areceive.export')."?uuid={$row->uuid}";
            })
            ->addColumn('can_approve_fa', function($row) {
                return $this->canApproveFa();
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function coaDatatables()
    {
        $data = Coa::where('description', '=', 'Detail');

        return datatables()->of($data)->escapeColumns()->make();
    }

    public function countPaidAmount($id_invoice)
    {
        $ara = AReceiveA::where('id_invoice', $id_invoice)->get();

        if (!count($ara)) {
            return 0;
        }

        $payment_total_amount = 0;

        for ($j = 0; $j < count($ara); $j++) {
            $y = $ara[$j];

            $payment_total_amount += $y->credit_idr;
        }

        return $payment_total_amount;
    }

    public function InvoiceModalDatatables(Request $request)
    {
        $ar = AReceive::where('uuid', $request->ar_uuid)->first();

        $invoice = Invoice::where('id_customer', $request->id_customer)
            ->with([
                'coas',
                'currencies'
            ])
            ->where('approve', 1)
            ->where('transaction_status', 2); //mengambil invoice yang statusnya approve

        if (count($ar->ara)) {
            $invoice = $invoice->where(
                    'currency',
                    Currency::where('code', $ar->ara[0]->currency)->first()->id
                );
        }

        $data = $invoice;

        return datatables($data)
            ->addColumn('date_formated', function($row) {
                return Carbon::parse($row->transactiondate)->format('d-m-Y');
            })
            ->addColumn('due_date_formated', function($row) {
                if ($row->due_date == '-') {
                    return '-';
                }

                return Carbon::parse($row->due_date)->format('d-m-Y');
            })
            ->addColumn('total_amount_idr', function($row) {
                return $this->countPaidAmount($row->id);
            })
            ->addColumn('paid_amount', function($row) {
                return $this->countPaidAmount($row->id);
            })
            ->addColumn('exchange_rate_gap', function($row) use($ar) {
                return $ar->exchangerate - $row->exchangerate;
            })
            ->addColumn('due_date', function($row) {
                return $row->due_date;
            })
            ->escapeColumns([])
            ->make();
    }

    public function approve(Request $request)
    {
        DB::beginTransaction();
        try {

            $ar_tmp = AReceive::where('uuid', $request->uuid);
            $ar = $ar_tmp->first();

            if ($ar->approve) {
                return abort(404);
            }

            if (count($ar->ara) < 1) {
                return response()->json([
                    'errors' => 'Invoice not selected yet'
                ]);
            }

            $transaction_number = $ar->transactionnumber;

            $ar->approvals()->save(new Approval([
                'approvable_id' => $ar->id,
                'is_approved' => 0,
                'conducted_by' => Auth::id(),
            ]));

            $ara = $ar->ara;
            $arb = $ar->arb;
            $arc = $ar->arc;

            $header = (object) [
                'voucher_no' => $transaction_number,
                // 'transaction_date' => $date_approve,
                'transaction_date' => $ar->transactiondate,
                'coa' => $ar->coa->id,
            ];

            $total_credit = 0;
            $total_debit = 0;

            $detail = [];

            foreach ($ara as $ara_row) {

                $arc_first = $ara_row->arc;

                $substract = 0;
                if ($arc_first->gap ?? null > 0) {
                    $substract = $arc_first->gap;
                }

                $desc = 'Payment From : ' . $ara_row->transactionnumber 
                    . ' '
                    . $ara_row->ar->customer->name
                    . " ({$ara_row->invoice->transactionnumber})";

                if ($ara_row->description) {
                    $desc = $ara_row->description;
                }

                $detail[] = (object) [
                    'coa_detail' => $ara_row->coa->id,
                    'credit' => $ara_row->credit_idr - $substract,
                    'debit' => 0,
                    '_desc' => $desc,
                ];

                $total_credit += $detail[count($detail) - 1]->credit;
                $total_debit += $detail[count($detail) - 1]->debit;
            }

            // looping sebanyak adjustment
            for ($a = 0; $a < count($arb); $a++) {
                $y = $arb[$a];

                $detail[] = (object) [
                    'coa_detail' => $y->coa->id,
                    'credit' => $y->credit_idr,
                    'debit' => $y->debit_idr,
                    '_desc' => 'Payment From : ' . $ara_row->transactionnumber . ' '
                        . $ara_row->ar->customer->name." (ADJ)",
                ];

                $total_credit += $detail[count($detail) - 1]->credit;
                $total_debit += $detail[count($detail) - 1]->debit;
            }

            // looping sebanyak gap
            for ($a = 0; $a < count($arc); $a++) {
                $z = $arc[$a];

                $side = 'credit';
                $x_side = 'debit';
                $val = $z->gap;

                // jika gap bernilai minus
                if ($z->gap < 0) {
                    $side = 'debit';
                    $x_side = 'credit';
                    $val = $z->gap * (-1);
                }

                $detail[] = (object) [
                    'coa_detail' => $z->coa->id,
                    $side => $val,
                    $x_side => 0,
                    '_desc' => 'Payment From : ' . $ara_row->transactionnumber . ' '
                        . $ara_row->ar->customer->name. " (GAP)",
                ];

                $total_credit += $detail[count($detail) - 1]->credit;
                $total_debit += $detail[count($detail) - 1]->debit;
            }

            // add object in first array $detai
            array_unshift(
                $detail,
                (object) [
                    'coa_detail' => $header->coa,
                    'credit' => 0,
                    'debit' => $total_credit - $total_debit,
                    '_desc' => 'Receive From : ' . $header->voucher_no
                ]
            );

            $total_credit += $detail[0]->credit;
            $total_debit += $detail[0]->debit;

            $ar_tmp->update([
                'approve' => 1
            ]);

            $autoJournal = TrxJournal::autoJournal(
                $header,
                $detail,
                ($ar->payment_type == 'bank')? 'BARJ': 'CARJ',
                'BRJ'
            );

            if ($autoJournal['status']) {

                $update_invoice_status = $this->ARUpdateInvoiceStatus($ar);

                if (!$update_invoice_status['status']) {
                    return [
                        'errors' => $update_invoice_status['message'] ?? 'Failed Update Invoice Status'
                    ];
                }

                DB::commit();
            } else {

                DB::rollBack();
                return response()->json([
                    'errors' => $autoJournal['message']
                ]);
            }

            return response()->json($ar);
        } catch (\Exception $e) {

            DB::rollBack();

            $data['errors'] = $e;

            return response()->json($data);
        }
    }

    function print(Request $request)
    {
        $ar = AReceive::where('uuid', $request->uuid)->firstOrFail();

        $ara = $ar->ara;
        $arb = $ar->arb;
        $arc = $ar->arc;

        $ar_approval = $ar->approvals->first();

        if ($ar_approval) {
            $date_approve = $ar_approval->created_at->toDateTimeString();
        } else {
            $date_approve = '-';
        }

        if (count($ar->ara) < 1) {
            return redirect()->route('areceive.index')->with(['errors' => 'Invoice not selected yet']);
        }

        $header = (object) [
            'voucher_no' => $ar->transactionnumber,
            'transaction_date' => $date_approve,
            'coa_code' => $ar->coa->code,
            'coa_name' => $ar->coa->name,
            'description' => $ar->description,
        ];

        $invoice_sample = ($ara->first())? $ara->first()->invoice: null;
        //jika sama" idr
        if ($ar->currencies->code == 'idr' and $ar->currencies->code == $invoice_sample->currencies->code) {
            $ar_rate = ($ar->currency == 'idr')? 1: $ar->exchangerate;
        } else {
            $ar_rate = $ar->exchangerate;
        }

        $total_credit = 0;
        $total_debit = 0;
        $total_credit_foreign = 0;
        $total_debit_foreign = 0;
        $detail = [];

        // looping sebenayak invoice
        foreach ($ara as $ara_row) {

            $arc_first = $ara_row->arc;

            $substract = 0;
            if ($arc_first->gap ?? null > 0) {
                $substract = $arc_first->gap;
            }

            $detail[] = (object) [
                'coa_code' => $ara_row->coa->code,
                'coa_name' => $ara_row->coa->name,
                'credit' => $ara_row->credit_idr - $substract,
                'credit_foreign' => ($ara_row->credit_idr / $ar_rate),
                'debit' => 0,
                'debit_foreign' => 0,
                '_desc' => "{$ara_row->description} <b>({$ara_row->invoice->transactionnumber})</b>",
            ];

            $total_credit += $detail[count($detail) - 1]->credit;
            $total_debit += $detail[count($detail) - 1]->debit;

            $total_credit_foreign += $detail[count($detail) - 1]->credit_foreign;
            $total_debit_foreign += $detail[count($detail) - 1]->debit_foreign;
        }

        // looping sebanyak adjustment
        for ($a = 0; $a < count($arb); $a++) {
            $y = $arb[$a];

            $detail[] = (object) [
                'coa_code' => $y->coa->code,
                'coa_name' => $y->coa->name,
                'credit' => $y->credit_idr,
                'credit_foreign' => $y->credit_idr / $ar_rate,
                'debit' => $y->debit_idr,
                'debit_foreign' => $y->debit_idr / $ar_rate,
                '_desc' => "{$y->description} (ADJ)",
            ];

            $total_credit += $detail[count($detail) - 1]->credit;
            $total_debit += $detail[count($detail) - 1]->debit;

            $total_credit_foreign += $detail[count($detail) - 1]->credit_foreign;
            $total_debit_foreign += $detail[count($detail) - 1]->debit_foreign;
        }

        // looping sebanyak gap
        for ($a = 0; $a < count($arc); $a++) {
            $z = $arc[$a];

            $side = 'credit';
            $x_side = 'debit';
            $val = $z->gap;

            // jika gap bernilai minus
            if ($z->gap < 0) {
                $side = 'debit';
                $x_side = 'credit';
                $val = $z->gap * (-1);
            }

            $detail[] = (object) [
                'coa_code' => $z->coa->code,
                'coa_name' => $z->coa->name,
                $side => $val,
                $side.'_foreign' => 0,
                $x_side => 0,
                $x_side.'_foreign' => 0,
                '_desc' => 'Exchange rate gap from <br><b>'.$z->ara->invoice->transactionnumber.'</b>',
            ];

            $total_credit += $detail[count($detail) - 1]->credit;
            $total_debit += $detail[count($detail) - 1]->debit;

            $total_credit_foreign += $detail[count($detail) - 1]->credit_foreign;
            $total_debit_foreign += $detail[count($detail) - 1]->debit_foreign;
        }

        // add object in first array $detai
        array_unshift(
            $detail,
            (object) [
                'coa_code' => $header->coa_code,
                'coa_name' => $header->coa_name,
                'credit' => 0,
                'credit_foreign' => 0,
                'debit' => $total_credit - $total_debit,
                'debit_foreign' => $total_credit_foreign - $total_debit_foreign,
                '_desc' => $header->description,
            ]
        );

        $total_credit += $detail[0]->credit;
        $total_debit += $detail[0]->debit;

        $total_credit_foreign += $detail[0]->credit_foreign;
        $total_debit_foreign += $detail[0]->debit_foreign;

        $data_detail = [];
        $_total_debit = 0;

        for ($i = 0; $i < count($detail); $i++) {

            $x = $detail[$i];

            if ($x->debit != 0 || $x->credit != 0) {

                $data_detail[] = $x;
            }

            $_total_debit += $x->debit;
        }

        $header_title = 'Cash';

        if ($ar->payment_type == 'bank') {
            $header_title = 'Bank';
        }

        $to = $ar->customer;

        if ($ar->currencies->code == 'idr' and $ar->currencies->code == $invoice_sample->currencies->code) {
            $total_credit_foreign = 0;
        }

        $data = [
            'data' => $ar,
            'invoice_sample' => $invoice_sample,
            'data_child' => $data_detail,
            'to' => $to,
            'total' => $_total_debit,
            'total_foreign' => $total_credit_foreign,
            'header_title' => $header_title,
            'header' => $header,
            'controller' => new Controller()
        ];

        $pdf = \PDF::loadView('formview::ar', $data);
        return $pdf->stream();
    }

    public function export(Request $request)
    {
        $invoice = Invoice::has('ara');

        if ($request->uuid) {
            $invoice = $invoice->whereHas('ara.ar', function($ar) use($request) {
                $ar->where('uuid', $request->uuid);
            });
        }

        $invoice = $invoice
            ->get()
            ->filter(function($row) {

                foreach ($row->ara as $ara_row) {
                    $ar = null;
                    if ($ara_row->ar_id != 0) {
                        $ar = $ara_row->ar;
                    }
                }

                if ($ar) {
                    $row->ar = $ar;
                    $row->ar->gap = $row->ar->arc->sum(function($arc) {
                        return $arc->debit - $arc->credit;
                    });
                    return $row;
                }
            });

        $data = [
            'controller' => new Controller(),
            'invoice' => $invoice,
            'carbon' => Carbon::class
        ];

        $prefix = '';
        // $prefix = 'All';
        // if ($request->uuid) {
        //     $prefix = str_replace('/', '-', $invoice->first()->ara->ar->transactionnumber);
        // }

        $now = Carbon::now()->format('d-m-Y');
        $name = "Account Receivable {$now}";

        $name .= " {$prefix}";

        return Excel::download(new ARExport($data), "{$name}.xlsx");
    }

    // function ini belum kepakek
    public function generate_ar($invoice)
    {
        $amount = $invoice->grantotal_foreign;
        $count_cash_advance = $invoice->cash_advance()->count();

        DB::beginTransaction();

        // generate ar as much as cash advance
        foreach ($invoice->cash_advance ?? [] as $cash_advance) {
            $request = new Request();

            $request->merge([
                'payment_type' => 'cash',
                'transactiondate' => now()->format('d-m-Y'),
                'id_customer' => $invoice->customer->id,
                'accountcode' => $cash_advance->coad,
                'currency' => $cash_advance->currency->code,
                'exchangerate' => $cash_advance->rate
            ]);

            $store = $this->store($request)->getData();
            $ar = AReceive::where('uuid', $store->uuid)->first();

            $request = new Request();

            $request->merge([
                'ar_uuid' => $ar->uuid,
                'data_uuid' => $invoice->uuid,
                'description' => "Auto Generated From {$cash_advance->transaction_number} - {$invoice->transactionnumber} - {$invoice->customer->name}",
            ]);

            $advance_payment_balance = new AdvancePaymentBalance();
            $update_amount = $advance_payment_balance->update_amount($cash_advance, $amount, $count_cash_advance);

            $request = new Request();
            $request->merge([
                'credit' => $update_amount['diff_balance']
            ]);

            $ara_controller = new ARAController();
            $ara_controller->store($request);

            $request = new Request();
            $request->merge([
                'uuid' => $ar->uuid
            ]);

            $this->approve($request);

            $amount = $update_amount['current_amount'];
            $count_cash_advance--;
                        
            if ($amount < 1) {
                break;
            }
        }

        DB::commit();
    }

    public function generateAR(CashAdvanceReturn $cash_advance_return)
    {
        $transaction_invoice = $cash_advance_return
            ->transactionInvoice()
            ->where('invoice_type', (new Invoice())->getTable())
            ->get();

        $request = new Request();

        // $request->merge([
        //     'payment_type' => 'cash',
        //     'transactiondate' => now()->format('d-m-Y'),
        //     'id_customer' => $cash_advance_return->id_ref, // id customer
        //     'accountcode' => $cash_advance->coad,
        //     'currency' => $cash_advance->currency->code,
        //     'exchangerate' => $cash_advance->rate
        // ]);
    }
}
