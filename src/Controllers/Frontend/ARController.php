<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Auth;
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
use DataTables;
use DB;

class ARController extends Controller
{
    public function index()
    {
        return view('accountreceivableview::index');
    }

    public function create()
    {
        $data['customer'] = Customer::all();
        return view('accountreceivableview::create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
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

        $coa = Coa::where('code', $request->accountcode)->first();

        $code = 'CCPJ';

        if (strpos($coa->name, 'Bank') !== false) {
            $code = 'CBPJ';
        }

        $request->request->add([
            'approve' => 0,
            'transactionnumber' => '-',
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

        //if data already approved
        if ($data['data']->approve) {
            return abort(404);
        }

        $data['customer'] = Customer::all();
        $data['currency'] = Currency::selectRaw(
            'code, CONCAT(name, " (", symbol ,")") as full_name'
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

        $data['credit_balance'] = "<span class='text-$class'>Rp " . number_format($credit_balance, 0, 0, '.') . "</span>";

        return view('accountreceivableview::edit', $data);
    }

    public function update(Request $request, AReceive $areceive)
    {
        if ($areceive->approve) {
            return abort(404);
        }

        $request->validate([
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
        $data = AReceive::orderBy('id', 'desc')->with([
            'customer',
            'ara',
            'coa',
        ]);

        return DataTables::of($data)
            ->addColumn('status', function($row) {
                return $row->status;
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
            ->with('coas')
            ->where('approve', 1);

        if (count($ar->ara)) {
            $invoice = $invoice->where(
                    'currency',
                    Currency::where('code', $ar->ara[0]->currency)->first()->id
                );
        }

        $data = $invoice;

        return DataTables::of($data)
            ->addColumn('paid_amount', function($row) {
                return $this->countPaidAmount($row->id);
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

            $coa = Coa::where('code', $ar->accountcode)->first();

            $code = 'CCPJ';

            if (strpos($coa->name, 'Bank') !== false) {
                $code = 'CBPJ';
            }

            $transaction_number = AReceive::generateCode($code);

            $ar_tmp->update([
                'transactionnumber' => $transaction_number
            ]);

            $ar->approvals()->save(new Approval([
                'approvable_id' => $ar->id,
                'is_approved' => 0,
                'conducted_by' => Auth::id(),
            ]));

            $ara = $ar->ara;
            $arb = $ar->arb;
            $arc = $ar->arc;

            $date_approve = $ar->approvals->first()
                ->created_at->toDateTimeString();

            $header = (object) [
                'voucher_no' => $transaction_number,
                // 'transaction_date' => $date_approve,
                'transaction_date' => $ar->transactiondate,
                'coa' => $ar->coa->id,
            ];

            $total_credit = 0;
            $total_debit = 0;

            $detail = [];

            // looping sebenayak invoice
            for ($a = 0; $a < count($ara); $a++) {
                $x = $ara[$a];

                if ($x->credit == 0 and $x->debit == 0) {
                    continue;
                }

                // jika invoice nya foreign
                if ($x->invoice->currencies->code != 'idr') {
                    $credit = $x->credit * $x->invoice->exchangerate;
                } else {
                    $credit = $x->credit_idr;
                }

                $detail[] = (object) [
                    'coa_detail' => $x->coa->id,
                    'credit' => $credit,
                    'debit' => 0,
                    '_desc' => 'Payment From : ' . $x->transactionnumber . ' '
                        . $x->ar->customer->name,
                ];

                $total_credit += $detail[count($detail) - 1]->credit;
                $total_debit += $detail[count($detail) - 1]->debit;
            }

            // looping sebanyak adjustment
            for ($a = 0; $a < count($arb); $a++) {
                $y = $arb[$a];

                if ($y->credit == 0 and $y->debit == 0) {
                    continue;
                }

                $detail[] = (object) [
                    'coa_detail' => $y->coa->id,
                    'credit' => $y->credit,
                    'debit' => $y->debit,
                    '_desc' => 'Payment From : ' . $x->transactionnumber . ' '
                        . $x->ar->customer->name,
                ];

                $total_credit += $detail[count($detail) - 1]->credit;
                $total_debit += $detail[count($detail) - 1]->debit;
            }

            // looping sebanyak gap
            for ($a = 0; $a < count($arc); $a++) {
                $z = $arc[$a];

                if ($z->credit == 0 and $z->debit == 0) {
                    continue;
                }

                $side = 'credit';
                $x_side = 'debit';
                $val = $z->difference;

                // jika difference bernilai minus
                if ($z->difference < 0) {
                    $side = 'debit';
                    $x_side = 'credit';
                    $val = $z->difference * (-1);
                }

                $detail[] = (object) [
                    'coa_detail' => $z->coa->id,
                    $side => $val,
                    $x_side => 0,
                    '_desc' => 'Payment From : ' . $x->transactionnumber . ' '
                        . $x->ar->customer->name,
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
                'CBRJ',
                'BRJ'
            );

            if ($autoJournal['status']) {

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

        $header = (object) [
            'voucher_no' => $ar->transactionnumber,
            'transaction_date' => $date_approve,
            'coa_code' => $ar->coa->code,
            'coa_name' => $ar->coa->name,
            'description' => $ar->description,
        ];

        $total_credit = 0;
        $total_debit = 0;
        $detail = [];

        // looping sebenayak invoice
        foreach ($ara as $ara_row) {

            // jika invoice nya foreign
            if ($ara_row->invoice->currencies->code != 'idr') {
                $credit = $ara_row->credit * $ara_row->invoice->exchangerate;
            } else {
                $credit = $ara_row->credit_idr;
            }

            $detail[] = (object) [
                'coa_code' => $ara_row->coa->code,
                'coa_name' => $ara_row->coa->name,
                'credit' => $credit,
                'debit' => 0,
                '_desc' => $ara_row->description,
            ];

            $total_credit += $detail[count($detail) - 1]->credit;
            $total_debit += $detail[count($detail) - 1]->debit;
        }

        // looping sebanyak adjustment
        for ($a = 0; $a < count($arb); $a++) {
            $y = $arb[$a];

            $detail[] = (object) [
                'coa_code' => $y->coa->code,
                'coa_name' => $y->coa->name,
                'credit' => $y->credit,
                'debit' => $y->debit,
                '_desc' => $y->description,
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
                'coa_code' => $z->coa->code,
                'coa_name' => $z->coa->name,
                $side => $val,
                $x_side => 0,
                '_desc' => $z->description,
            ];

            $total_credit += $detail[count($detail) - 1]->credit;
            $total_debit += $detail[count($detail) - 1]->debit;
        }

        // add object in first array $detai
        array_unshift(
            $detail,
            (object) [
                'coa_code' => $header->coa_code,
                'coa_name' => $header->coa_name,
                'credit' => 0,
                'debit' => $total_credit - $total_debit,
                '_desc' => $header->description,
            ]
        );

        $total_credit += $detail[count($detail) - 1]->credit;
        $total_debit += $detail[count($detail) - 1]->debit;

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

        if (strpos(strtolower($ar->coa->name), 'bank') !== false) {
            $header_title = 'Bank';
        }

        $to = $ar->customer;

        $data = [
            'data' => $ar,
            'data_child' => $data_detail,
            'to' => $to,
            'total' => $_total_debit,
            'header_title' => $header_title,
            'header' => $header,
        ];

        $pdf = \PDF::loadView('formview::ar', $data);
        return $pdf->stream();
    }
}
