<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use memfisfa\Finac\Model\AReceive;
use memfisfa\Finac\Model\AReceiveA;
use memfisfa\Finac\Model\Coa;
use memfisfa\Finac\Model\Invoice;
use memfisfa\Finac\Request\AReceiveUpdate;
use memfisfa\Finac\Request\AReceiveStore;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Currency;
use memfisfa\Finac\Model\TrxJournal;
use App\Models\Approval;
use App\Models\Department;
use DataTables;
use DB;
use Illuminate\Support\Facades\Auth;

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
            'description' => $request->ar_description
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

    public function datatables()
    {
        $data = AReceive::orderBy('id', 'desc')
            ->with([
                'customer',
                'ara',
                'coa',
            ])
            ->select('a_receives.*');

        return DataTables::of($data)
            ->addColumn('transactionnumber_link', function($row) {
                $html = '<a href="'.route('areceive.show', $row->uuid).'">'.$row->transactionnumber.'</a>';

                return $html;
            })
            ->addColumn('created_by', function($row) {
                return $row->audits()->first()->user->name ?? null;
            })
            ->addColumn('status', function($row) {
                return $row->status;
            })
            ->addColumn('url_edit', function($row) {
                return route('areceive.edit', $row->uuid);
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function coaDatatables()
    {
        function filterArray($array, $allowed = [])
        {
            return array_filter(
                $array,
                function ($val, $key) use ($allowed) { // N.b. $val, $key not $key, $val
                    return isset($allowed[$key]) && ($allowed[$key] === true || $allowed[$key] === $val);
                },
                ARRAY_FILTER_USE_BOTH
            );
        }

        function filterKeyword($data, $search, $field = '')
        {
            $filter = '';
            if (isset($search['value'])) {
                $filter = $search['value'];
            }
            if (!empty($filter)) {
                if (!empty($field)) {
                    if (strpos(strtolower($field), 'date') !== false) {
                        // filter by date range
                        $data = filterByDateRange($data, $filter, $field);
                    } else {
                        // filter by column
                        $data = array_filter($data, function ($a) use ($field, $filter) {
                            return (bool) preg_match("/$filter/i", $a[$field]);
                        });
                    }
                } else {
                    // general filter
                    $data = array_filter($data, function ($a) use ($filter) {
                        return (bool) preg_grep("/$filter/i", (array) $a);
                    });
                }
            }

            return $data;
        }

        function filterByDateRange($data, $filter, $field)
        {
            // filter by range
            if (!empty($range = array_filter(explode('|', $filter)))) {
                $filter = $range;
            }

            if (is_array($filter)) {
                foreach ($filter as &$date) {
                    // hardcoded date format
                    $date = date_create_from_format('m/d/Y', stripcslashes($date));
                }
                // filter by date range
                $data = array_filter($data, function ($a) use ($field, $filter) {
                    // hardcoded date format
                    $current = date_create_from_format('m/d/Y', $a[$field]);
                    $from    = $filter[0];
                    $to      = $filter[1];
                    if ($from <= $current && $to >= $current) {
                        return true;
                    }

                    return false;
                });
            }

            return $data;
        }

        $columnsDefault = [
            'name'     => true,
            'id' => true,
            'code'     => true,
            'type'  => true,
            'description' => true,
            'uuid'      => true,
            'Actions'      => true,
        ];

        if (isset($_REQUEST['columnsDef']) && is_array($_REQUEST['columnsDef'])) {
            $columnsDefault = [];
            foreach ($_REQUEST['columnsDef'] as $field) {
                $columnsDefault[$field] = true;
            }
        }

        // get all raw data
        $coa  = Coa::where('description', 'Detail')->get();


        $alldata = json_decode($coa, true);

        $data = [];
        // internal use; filter selected columns only from raw data
        foreach ($alldata as $d) {
            $data[] = filterArray($d, $columnsDefault);
        }

        // count data
        $totalRecords = $totalDisplay = count($data);

        // filter by general search keyword
        if (isset($_REQUEST['search'])) {
            $data         = filterKeyword($data, $_REQUEST['search']);
            $totalDisplay = count($data);
        }

        if (isset($_REQUEST['columns']) && is_array($_REQUEST['columns'])) {
            foreach ($_REQUEST['columns'] as $column) {
                if (isset($column['search'])) {
                    $data         = filterKeyword($data, $column['search'], $column['data']);
                    $totalDisplay = count($data);
                }
            }
        }

        // sort
        if (isset($_REQUEST['order'][0]['column']) && $_REQUEST['order'][0]['dir']) {
            $column = $_REQUEST['order'][0]['column'];
            $dir    = $_REQUEST['order'][0]['dir'];
            usort($data, function ($a, $b) use ($column, $dir) {
                $a = array_slice($a, $column, 1);
                $b = array_slice($b, $column, 1);
                $a = array_pop($a);
                $b = array_pop($b);

                if ($dir === 'asc') {
                    return $a > $b ? true : false;
                }

                return $a < $b ? true : false;
            });
        }

        // pagination length
        if (isset($_REQUEST['length'])) {
            $data = array_splice($data, $_REQUEST['start'], $_REQUEST['length']);
        }

        // return array values only without the keys
        if (isset($_REQUEST['array_values']) && $_REQUEST['array_values']) {
            $tmp  = $data;
            $data = [];
            foreach ($tmp as $d) {
                $data[] = array_values($d);
            }
        }

        $secho = 0;
        if (isset($_REQUEST['sEcho'])) {
            $secho = intval($_REQUEST['sEcho']);
        }

        $result = [
            'iTotalRecords'        => $totalRecords,
            'iTotalDisplayRecords' => $totalDisplay,
            'sEcho'                => $secho,
            'sColumns'             => '',
            'aaData'               => $data,
        ];

        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

        echo json_encode($result, JSON_PRETTY_PRINT);
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

        return DataTables::of($data)
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

                $detail[] = (object) [
                    'coa_detail' => $ara_row->coa->id,
                    'credit' => $ara_row->credit_idr - $substract,
                    'debit' => 0,
                    '_desc' => 'Payment From : ' . $ara_row->transactionnumber 
                        . ' '
                        . $ara_row->ar->customer->name,
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
                        . $ara_row->ar->customer->name,
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
                        . $ara_row->ar->customer->name,
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
        $ar = AReceive::where('uuid', $request->uuid)->first();

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
                '_desc' => $ara_row->description,
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
                '_desc' => $y->description,
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
        ];

        $pdf = \PDF::loadView('formview::ar', $data);
        return $pdf->stream();
    }
}
