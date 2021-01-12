<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Auth;
use Illuminate\Http\Request;
use memfisfa\Finac\Model\APayment;
use memfisfa\Finac\Model\APaymentA;
use memfisfa\Finac\Model\Coa;
use memfisfa\Finac\Model\TrxPayment;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Currency;
use memfisfa\Finac\Model\TrxJournal;
use App\Models\Approval;
use App\Models\GoodsReceived;
use DataTables;
use DB;

class APController extends Controller
{
    public function index()
    {
        return view('accountpayableview::index');
    }

    public function create()
    {
        $data['vendor'] = Vendor::all();
        return view('accountpayableview::create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_type' => 'required|in:bank,cash',
            'transactiondate' => 'required',
            'id_supplier' => 'required',
            'accountcode' => 'required',
            'currency' => 'required',
            'exchangerate' => 'required'
        ]);

        $vendor = Vendor::where('id', $request->id_supplier)->first();
        if (!$vendor) {
            return [
                'errors' => 'Vendor not found'
            ];
        }

        $request->merge([
            'id_supplier' => $vendor->id
        ]);

        $request->request->add([
            'approve' => 0,
            'transactionnumber' => '-',
        ]);

        $apayment = APayment::create($request->all());
        return response()->json($apayment);
    }

    public function edit(Request $request)
    {
        $data['data'] = APayment::where(
            'uuid',
            $request->apayment
        )->with([
            'currencies',
            'project',
        ])->first();

        //if data already approved
        if ($data['data']->approve) {
            return abort(404);
        }

        $data['vendor'] = Vendor::all();
        $data['currency'] = Currency::selectRaw(
            'code, CONCAT(name, " (", symbol ,")") as full'
        )->whereIn('code', ['idr', 'usd'])
            ->get();

        $data['debt_total_amount'] = TrxPayment::where(
            'id_supplier',
            $data['data']->id_supplier
        )
            ->where('x_type', 'NON GRN')
            ->where('approve', true)
            ->sum('grandtotal');
        
        $x = $data['debt_total_amount'];

        $si_grn = TrxPayment::where(
            'id_supplier',
            $data['data']->id_supplier
        )
            ->where('x_type', 'GRN')
            ->where('approve', true)
            ->first();

        if ($si_grn) {
            foreach ($si_grn->trxpaymenta as $tpa_row) {
                $data['debt_total_amount'] += $tpa_row->total_idr;
            }
        }

        $apayment = APayment::where('id_supplier', $data['data']->id_supplier)
            ->where('approve', true)
            ->get();

        $payment_total_amount = 0;
        for ($i = 0; $i < count($apayment); $i++) {
            $x = $apayment[$i];

            for ($j = 0; $j < count($x->apa); $j++) {
                $y = $x->apa[$j];

                $payment_total_amount += $y->credit_idr;
            }
        }

        $data['payment_total_amount'] = $payment_total_amount;
        $debt_balance = abs(($data['debt_total_amount'] - $data['payment_total_amount']));

        $class = 'danger';
        if ($debt_balance > $data['debt_total_amount']) {
            $class = 'success';
        }

        $data['debt_balance'] = "<span class='text-$class'>Rp " . number_format($debt_balance, 0, ',', '.') . "</span>";

        return view('accountpayableview::edit', $data);
    }

    public function update(Request $request, APayment $apayment)
    {
        if ($apayment->approve) {
            return abort(404);
        }

        $request->validate([
            'payment_type' => 'required|in:bank,cash',
            'transactiondate' => 'required',
            'id_supplier' => 'required',
            'accountcode' => 'required',
            'currency' => 'required',
            'exchangerate' => 'required'
        ]);

        $request->merge([
            'description' => $request->ar_description
        ]);

        $apayment->update($request->all());

        return response()->json($apayment);
    }

    public function destroy(APayment $apayment)
    {
        if ($apayment->approve) {
            return abort(404);
        }
        $apayment->delete();

        return response()->json($apayment);
    }

    public function api()
    {
        $areceivedata = APayment::all();

        return json_encode($areceivedata);
    }

    public function apidetail(APayment $apayment)
    {
        return response()->json($apayment);
    }

    public function datatables()
    {
        $data = APayment::orderBy('id', 'desc')->with([
            'vendor',
            'apa',
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

    public function countPaidAmount($si_uuid, $type)
    {
        
        if ($type == 'GRN') {
            $data = GoodsReceived::where('uuid', $si_uuid)->first();
        }else{
            $data = TrxPayment::where('uuid', $si_uuid)->first();
        }

        $apa = APaymentA::where('id_payment', $data->id)
            ->where('type', $type)
            ->get();

        if (!count($apa)) {
            return 0;
        }

        $payment_total_amount = 0;

        for ($j = 0; $j < count($apa); $j++) {
            $y = $apa[$j];

            $payment_total_amount += $y->debit_idr;
        }

        return $payment_total_amount;
    }

    public function SIModalDatatables(Request $request)
    {
        $trxpayment_grn = TrxPayment::where('id_supplier', $request->id_vendor)
            ->where('x_type', 'GRN')
            ->where('approve', 1)
            ->get();

        $arr = [];
        $index_arr = 0;

        // looping sebanyak supplier invoice
        for ($i = 0; $i < count($trxpayment_grn); $i++) {
            $x = $trxpayment_grn[$i];

            // looping sebanyak GRN
            for ($j = 0; $j < count($x->trxpaymenta); $j++) {
                $z = $x->trxpaymenta[$j];

                $arr[$index_arr] = json_decode($x);
                $arr[$index_arr]->transaction_number = $z->grn->number;
                $arr[$index_arr]->uuid = $z->grn->uuid;
                $arr[$index_arr]->grandtotal_foreign = $z->total;
                $arr[$index_arr]->grandtotal = $z->total_idr;
                $arr[$index_arr]->currencies = $x->currencies;
                $index_arr++;
            }
        }

        $trxpayment_non_grn = TrxPayment::where('id_supplier', $request->id_vendor)
            ->where('x_type', 'NON GRN')
            ->where('approve', 1)
            ->with(['currencies'])
            ->get();

        $si = array_merge($arr, json_decode($trxpayment_non_grn));

        for (
            $si_index = 0;
            $si_index < count($si);
            $si_index++
        ) {
            $si[$si_index]->paid_amount = 
                $this->countPaidAmount($si[$si_index]->uuid, $si[$si_index]->x_type);
        }

        $data = $alldata = $si;

        $datatable = array_merge([
            'pagination' => [], 'sort' => [], 'query' => []
        ], $_REQUEST);

        $filter = isset($datatable['query']['generalSearch']) &&
            is_string($datatable['query']['generalSearch']) ?
            $datatable['query']['generalSearch'] : '';

        if (!empty($filter)) {
            $data = array_filter($data, function ($a) use ($filter) {
                return (bool) preg_grep("/$filter/i", (array) $a);
            });

            unset($datatable['query']['generalSearch']);
        }

        $query = isset($datatable['query']) &&
            is_array($datatable['query']) ? $datatable['query'] : null;

        if (is_array($query)) {
            $query = array_filter($query);

            foreach ($query as $key => $val) {
                $data = $this->list_filter($data, [$key => $val]);
            }
        }

        $sort  = !empty($datatable['sort']['sort']) ?
            $datatable['sort']['sort'] : 'asc';
        $field = !empty($datatable['sort']['field']) ?
            $datatable['sort']['field'] : 'RecordID';

        $meta    = [];
        $page    = !empty($datatable['pagination']['page']) ?
            (int) $datatable['pagination']['page'] : 1;
        $perpage = !empty($datatable['pagination']['perpage']) ?
            (int) $datatable['pagination']['perpage'] : -1;

        $pages = 1;
        $total = count($data);

        usort($data, function ($a, $b) use ($sort, $field) {
            if (!isset($a->$field) || !isset($b->$field)) {
                return false;
            }

            if ($sort === 'asc') {
                return $a->$field > $b->$field ? true : false;
            }

            return $a->$field < $b->$field ? true : false;
        });

        if ($perpage > 0) {
            $pages  = ceil($total / $perpage);
            $page   = max($page, 1);
            $page   = min($page, $pages);
            $offset = ($page - 1) * $perpage;

            if ($offset < 0) {
                $offset = 0;
            }

            $data = array_slice($data, $offset, $perpage, true);
        }

        $meta = [
            'page'    => $page,
            'pages'   => $pages,
            'perpage' => $perpage,
            'total'   => $total,
        ];

        if (
            isset($datatable['requestIds']) &&
            filter_var($datatable['requestIds'], FILTER_VALIDATE_BOOLEAN)
        ) {
            $meta['rowIds'] = array_map(function ($row) {
                return $row->RecordID;
            }, $alldata);
        }

        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

        $result = [
            'meta' => $meta + [
                'sort'  => $sort,
                'field' => $field,
            ],
            'data' => $data,
        ];

        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function approve(Request $request)
    {
        DB::beginTransaction();
        try {

            $ar_tmp = APayment::where('uuid', $request->uuid);
            $ap = $ar_tmp->first();

            $code = 'CPYJ';

            if ($ap->payment_type == 'bank') {
                $code = 'BPYJ';
            }

            $transaction_number = APayment::generateCode($code);

            $ar_tmp->update([
                'transactionnumber' => $transaction_number
            ]);

            $ap->approvals()->save(new Approval([
                'approvable_id' => $ap->id,
                'is_approved' => 0,
                'conducted_by' => Auth::id(),
            ]));

            $apa = $ap->apa;
            $apb = $ap->apb;
            $apc = $ap->apc;

            $header = (object) [
                'voucher_no' => $ap->transactionnumber,
                // 'transaction_date' => $date_approve,
                'transaction_date' => $ap->transactiondate,
                'coa' => $ap->coa->id,
            ];

            $total_credit = 0;
            $total_debit = 0;

            $detail = [];

            // looping sebenayak invoice
            for ($a = 0; $a < count($apa); $a++) {
                $x = $apa[$a];

                if ($x->credit == 0 and $x->debit == 0) {
                    continue;
                }

                $si = $x->getSI();

                $currency_code = $si->currencies->code;

                // jika invoice nya foreign
                if ($currency_code != 'idr') {
                    $credit = $x->credit * $x->si->exchange_rate;
                } else {
                    $credit = $x->credit_idr;
                }

                $detail[] = (object) [
                    'coa_detail' => $x->coa->id,
                    'credit' => $credit,
                    'debit' => 0,
                    '_desc' => 'Payment From : ' . $x->transactionnumber . ' '
                        . $x->ap->vendor->name,
                ];

                $total_credit += $detail[count($detail) - 1]->credit;
                $total_debit += $detail[count($detail) - 1]->debit;
            }

            // looping sebanyak adjustment
            for ($a = 0; $a < count($apb); $a++) {
                $y = $apb[$a];

                if ($y->credit == 0 and $y->debit == 0) {
                    continue;
                }

                $detail[] = (object) [
                    'coa_detail' => $y->coa->id,
                    'credit' => $y->credit,
                    'debit' => $y->debit,
                    '_desc' => 'Payment From : ' . $x->transactionnumber . ' '
                        . $x->ap->vendor->name,
                ];

                $total_credit += $detail[count($detail) - 1]->credit;
                $total_debit += $detail[count($detail) - 1]->debit;
            }

            // looping sebanyak gap
            for ($a = 0; $a < count($apc); $a++) {
                $z = $apc[$a];

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
                        . $x->ap->vendor->name,
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
                ($ap->payment_type == 'bank')? 'BAPJ': 'CAPJ',
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

            return response()->json($ap);
        } catch (\Exception $e) {

            DB::rollBack();

            $data['errors'] = $e;

            return response()->json($data);
        }
    }

    function print(Request $request)
    {
        $ar_tmp = APayment::where('uuid', $request->uuid);
        $ap = $ar_tmp->first();

        $apa = $ap->apa;
        $apb = $ap->apb;
        $apc = $ap->apc;

        $ar_approval = $ap->approvals->first();

        if ($ar_approval) {
            $date_approve = $ar_approval->created_at->toDateTimeString();
        } else {
            $date_approve = '-';
        }

        $header = (object) [
            'voucher_no' => $ap->transactionnumber,
            'transaction_date' => $date_approve,
            'coa_code' => $ap->coa->code,
            'coa_name' => $ap->coa->name,
            'description' => $ap->description,
        ];

        $total_credit = 0;
        $total_debit = 0;
        $detail = [];

        // looping sebenayak invoice
        foreach ($apa as $apa_row) {

            $si = $apa_row->getSI();

            // jika invoice nya foreign
            if ($si->currencies->code != 'idr') {
                $debit = $apa_row->debit * $si->exchange_rate;
            } else {
                $debit = $apa_row->debit_idr;
            }

            $detail[] = (object) [
                'coa_code' => $apa_row->coa->code,
                'coa_name' => $apa_row->coa->name,
                'credit' => 0,
                'debit' => $debit,
                '_desc' => $apa_row->description,
            ];

            $total_credit += $detail[count($detail) - 1]->credit;
            $total_debit += $detail[count($detail) - 1]->debit;
        }

        // looping sebanyak adjustment
        for ($a = 0; $a < count($apb); $a++) {
            $y = $apb[$a];

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
        for ($a = 0; $a < count($apc); $a++) {
            $z = $apc[$a];

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
                'credit' => $total_debit - $total_credit,
                'debit' => 0,
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

        if (strpos(strtolower($ap->coa->name), 'bank') !== false) {
            $header_title = 'Bank';
        }

        $to = $ap->vendor;

        $data = [
            'data' => $ap,
            'data_child' => $data_detail,
            'to' => $to,
            'total' => $_total_debit,
            'header_title' => $header_title,
            'header' => $header,
        ];

        $pdf = \PDF::loadView('formview::ap', $data);
        return $pdf->stream();
    }
}
