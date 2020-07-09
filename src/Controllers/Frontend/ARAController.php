<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use memfisfa\Finac\Model\Invoice;
use memfisfa\Finac\Model\InvoiceA;
use memfisfa\Finac\Model\AReceive;
use memfisfa\Finac\Model\AReceiveA;
use memfisfa\Finac\Model\AReceiveC;
use memfisfa\Finac\Request\AReceiveAUpdate;
use memfisfa\Finac\Request\AReceiveAStore;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\GoodsReceived as GRN;
use DB;

class ARAController extends Controller
{
    public function index()
    {
        return redirect()->route('areceivea.create');
    }

    public function create()
    {
        return view('areceiveaview::index');
    }

    public function store(Request $request)
    {
        $AR = AReceive::where('uuid', $request->ar_uuid)->first();

        $invoice = Invoice::where('uuid', $request->data_uuid)->first();

        $ARA = AReceiveA::where(
            'transactionnumber',
            $AR->transactionnumber
        )->first();

        $currency = Currency::find($invoice->currency)->code;
        @$code = ($v = $invoice->customer->coa->first()->code) ? $v : '';

        if ($ARA) {
            if ($currency != $ARA->currency) {
                return response()->json([
                    'errors' => 'Currency not consistent'
                ]);
            }
        }

        $request->request->add([
            'description' => '',
            'transactionnumber' => $AR->transactionnumber,
            'id_invoice' => $invoice->id,
            'currency' => $currency,
            'exchangerate' => $invoice->exchangerate,
            'code' => $code,
        ]);

        $areceivea = AReceiveA::create($request->all());
        return response()->json($areceivea);
    }

    public function edit(AReceiveA $areceivea)
    {
        return response()->json($areceivea);
    }

    public function calculateAmount($ara, $request)
    {
        $amount_to_pay = $request->credit;
        $invoice = $ara->invoice;
        $ar = $ara->ar;

        // jika header ar currency nya idr
        if ($ar->currencies->code == 'idr') {
            // jik currency ar IDR dan invoice foreign
            if ($ar->currencies->code != $invoice->currencies->code) {
                // mencari foreign amount to pay, 
                // dengan cara membagi amount to pay dengan rate ar
                $foreign_amount_to_pay = $amount_to_pay / $ar->exchangerate;
                // mencari nilai rupiah dengan rate invoice 
                // dari nilai usd ar yang sudah dihitung sblmnya
                $idr_amount_to_pay_invoice_rate =
                    $foreign_amount_to_pay * $invoice->exchangerate;

                $result = [
                    // amount to pay idr dari ar dikurangi hasil rupiah
                    // dari usd ar dikali dengan rate invoice
                    'gep' => round(
                        $amount_to_pay - $idr_amount_to_pay_invoice_rate,
                        2
                    ),
                    'credit' => round($foreign_amount_to_pay, 2),
                    'credit_idr' => round($amount_to_pay, 2),
                ];
            } else { //jika ar IDR dan invoice IDR
                $result = [
                    'gep' => 0,
                    'credit' => round($amount_to_pay, 2),
                    'credit_idr' => round($amount_to_pay, 2),
                ];
            }
        }

        if ($ar->currencies->code != 'idr') {
            // jik currency ar Foreign dan invoice IDR
            if ($ar->currencies->code != $invoice->currencies->code) {
                // jika belum pembayaran terakhir
                if (!$request->is_clearing) {

                    $gep = 0;
                    $credit = $amount_to_pay;
                    $credit_idr = $amount_to_pay * $ar->exchangerate;
                } else {
                    $all_invoice = AReceiveA::select(
                        'sum(credit) as total_credit',
                        'sum(credit_idr) as total_credit_idr',
                    )
                        ->where('id_invoice', $invoice->id)
                        ->first();
                    $total_credit = $all_invoice->total_credit + $amount_to_pay;
                    $total_credit_idr =
                        $all_invoice->total_credit_idr + ($amount_to_pay * $ar->exchangerate);
                }

                $result = [
                    'gep' => $gep,
                    'credit' => $credit,
                    'credit_idr' => $credit_idr,
                ];
            } else { //jika ar Foreign dan invoice Foreign

            }
        }
    }

    public function update(AReceiveAUpdate $request, AReceiveA $areceivea)
    {

        DB::beginTransaction();
        try {

            $calculation = $this->calculateCredit($areceivea, $request);

            $request->merge([
                'credit' => $calculation->credit
            ]);

            $areceivea->update($request->all());

            $ara = $areceivea;
            $ar = $ara->ar;

            $arc = AReceiveC::where('id_invoice', $ara->id_invoice)
                ->where('transactionnumber', $ara->transactionnumber)
                ->first();

            $difference =
                ($ara->credit * $ar->exchangerate) -
                ($ara->credit * $ara->exchangerate);

            if ($arc) {
                AReceiveC::where('id', $arc->id)->update([
                    'difference' => $difference
                ]);
            } else {
                AReceiveC::create([
                    'transactionnumber' => $ara->transactionnumber,
                    'id_invoice' => $ara->id_invoice,
                    'code' => '81112003',
                    'difference' => $difference,
                ]);
            }

            DB::commit();

            return response()->json($areceivea);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json($e->getMessage());
        }
    }

    public function destroy(AReceiveA $areceivea)
    {
        $areceivea->delete();

        return response()->json($areceivea);
    }

    public function api()
    {
        $areceiveadata = AReceiveA::all();

        return json_encode($areceiveadata);
    }

    public function apidetail(AReceiveA $areceivea)
    {
        return response()->json($areceivea);
    }

    public function getDataInvoice($x)
    {
        $result = Invoice::where(
            'id',
            $x->id_invoice
        )
            ->with('currencies')
            ->first();

        return $result;
    }

    public function old_countPaidAmount($x)
    {
        $ara = AReceiveA::where(
            'transactionnumber',
            $x->transactionnumber
        )->get();

        $total = 0;
        for ($i = 0; $i < count($ara); $i++) {
            $y = $ara[$i];

            // check if this AR is approved or not
            if ($y->ar->approve) {
                $total += $y->debit;
            }
        }

        return $total;
    }

    public function countPaidAmount($x)
    {
        $ara_tmp = AReceiveA::where(
            'transactionnumber',
            $x->transactionnumber
        )->first();

        $ar = $ara_tmp->ar;
        $ara = AReceiveA::where('id_invoice', $ara_tmp->id_invoice)
            ->get();

        $data['debt_total_amount'] = Invoice::where(
            'id_customer',
            $ar->customer->id
        )->sum('grandtotal');

        $payment_total_amount = 0;

        for ($j = 0; $j < count($ara); $j++) {
            $y = $ara[$j];

            $payment_total_amount += ($y->credit * $ar->exchangerate);
        }

        return $payment_total_amount;
    }

    public function datatables(Request $request)
    {
        $AR = AReceive::where('uuid', $request->ar_uuid)->first();
        $ARA = AReceiveA::where('transactionnumber', $AR->transactionnumber)
            ->with([
                'ar',
                'ar.currencies',
                'currencies'
            ])
            ->get();

        for ($i = 0; $i < count($ARA); $i++) {
            $x = $ARA[$i];

            $ARA[$i]->_transaction_number = $x->id_invoice;
            $ARA[$i]->invoice = $this->getDataInvoice($x);
            $ARA[$i]->paid_amount = $this->countPaidAmount($x);
        }

        $data = $alldata = json_decode(
            $ARA
        );

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
}
