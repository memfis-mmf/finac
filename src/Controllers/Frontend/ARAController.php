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

        if ($AR->approve) {
            return abort(404);
        }

        $invoice = Invoice::where('uuid', $request->data_uuid)->first();

        $ARA = AReceiveA::where(
            'ar_id',
            $AR->id
        )->first();

        $currency = Currency::find($invoice->currency)->code;

        if ($ARA) {
            if ($currency != $ARA->currency) {
                return response()->json([
                    'errors' => 'Currency not consistent'
                ]);
            }
        }

        $cek = AReceiveA::where('id_invoice', $invoice->id)
            ->where('ar_id', $AR->id)
            ->first();

        if ($cek) {
            return response()->json([
                'errors' => 'Invoice already exist'
            ]);
        }

        $request->request->add([
            'description' => '',
            'transactionnumber' => $AR->transactionnumber,
            'ar_id' => $AR->id,
            'id_invoice' => $invoice->id,
            'currency' => $currency,
            'exchangerate' => $invoice->exchangerate,
            'code' => $invoice->customer->coa->first()->code,
        ]);

        $areceivea = AReceiveA::create($request->all());
        return response()->json($areceivea);
    }

    public function edit(AReceiveA $areceivea)
    {
        $ar = $areceivea->ar;
        if ($ar->approve) {
            return abort(404);
        }

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
                    'gap' => round(
                        $amount_to_pay - $idr_amount_to_pay_invoice_rate,
                        2
                    ),
                    'credit' => round($foreign_amount_to_pay, 2),
                    'credit_idr' => round($amount_to_pay, 2),
                ];
            } else { //jika ar IDR dan invoice IDR
                $result = [
                    'gap' => 0,
                    'credit' => round($amount_to_pay, 2),
                    'credit_idr' => round($amount_to_pay, 2),
                ];
            }
        }

        // jika header ar currency nya Foreign
        if ($ar->currencies->code != 'idr') {
            // jik currency ar Foreign dan invoice IDR
            if ($ar->currencies->code != $invoice->currencies->code) {

                $idr_amount_to_pay = $amount_to_pay * $ar->exchangerate;

                // jika belum pembayaran terakhir
                if (!$request->is_clearing) {
                    $gap = 0;
                } else { //jika pembayaran terakhir
                    $all_invoice = AReceiveA::select(
                        'sum(credit) as total_credit',
                        'sum(credit_idr) as total_credit_idr',
                    )
                        ->where('id_invoice', $invoice->id)
                        ->first();

                    $total_credit_idr =
                        $all_invoice->total_credit_idr + $idr_amount_to_pay;

                    $gap = $idr_amount_to_pay -
                        ($invoice->grandtotal - $total_credit_idr);
                }

                $credit = $amount_to_pay;
                $credit_idr = $idr_amount_to_pay;

                $result = [
                    'gap' => $gap,
                    'credit' => $credit,
                    'credit_idr' => $credit_idr,
                ];
            } else { //jika ar Foreign dan invoice Foreign
                $new_rate = $ar->exchangerate - $invoice->exchangerate;

                $result = [
                    'gap' => ($new_rate * $amount_to_pay),
                    'credit' => $amount_to_pay,
                    'credit_idr' => $amount_to_pay * $ar->exchangerate,
                ];
            }
        }

        return (object) $result;
    }

    public function checkAmount($ara, $request)
    {
        $amount_to_pay = $request->credit;

        $invoice = $ara->invoice;
        $invoice_amount = $invoice->grandtotalforeign;

        // get all receive amount invoice
        $query = AReceiveA::where('id_invoice', $invoice->id)
            ->where('id', '!=', $ara->id);

        // jika invoice foreign
        if ($invoice->currencies->code != 'idr') {
            $total_invoice_receive_amount = $query->sum('credit');
        } else { //jika invoice idr
            $total_invoice_receive_amount = $query->sum('credit_idr');
        }

        $total_invoice_receive_amount += $amount_to_pay;

        // jika currency ar dan invoice sama
        if ($ara->ar->currencies->code == $invoice->currencies->code) {
            if ($total_invoice_receive_amount > $invoice_amount) {
                return (object)[
                    'status' => false,
                    'message' => 'Total amount receive is more than invoice amount',
                ];
            }
        }

        return (object)[
            'status' => true,
            'message' => ''
        ];

    }

    public function update(AReceiveAUpdate $request, AReceiveA $areceivea)
    {
        $ar = $areceivea->ar;
        if ($ar->approve) {
            return abort(404);
        }

        DB::beginTransaction();
        try {

            $calculation = $this->calculateAmount($areceivea, $request);
            $check_amount = $this->checkAmount($areceivea, $request);

            if (!$check_amount->status) {
                return response()->json([
                    'errors' => $check_amount->message
                ]);
            }

            $request->merge([
                'credit' => $calculation->credit,
                'credit_idr' => $calculation->credit_idr,
            ]);

            $areceivea->update($request->all());

            $ara = $areceivea;

            $arc = $ara->arc;

            $arc_debit = 0;
            $arc_credit = 0;
            if ($calculation->gap > 0) {
                $arc_credit = $calculation->gap;
            } else {
                $arc_debit = $calculation->gap;
            }

            if ($arc) {
                AReceiveC::where('id', $arc->id)->update([
                    'debit' => $arc_debit,
                    'credit' => $arc_credit,
                ]);
            } else {
                AReceiveC::create([
                    'ara_id' => $ara->id,
                    'ar_id' => $ara->ar->id,
                    'transactionnumber' => $ara->transactionnumber,
                    'id_invoice' => $ara->id_invoice,
                    'code' => '81112003',
                    'debit' => $arc_debit,
                    'credit' => $arc_credit,
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
        $ar = $areceivea->ar;
        if ($ar->approve) {
            return abort(404);
        }
        AReceiveC::where('ara_id', $areceivea->id)->forceDelete();
        $areceivea->forceDelete();

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

    public function countPaidAmount($ara_tmp)
    {
        $invoice = $ara_tmp->invoice;
        // ambil semua data pembayaran invoice ini
        $ara = AReceiveA::where('id_invoice', $invoice->id)
            ->get();

        $paid_amount = 0;
        foreach ($ara as $ara_row) {
            if ($invoice->currencies->code != 'idr') {
                $paid_amount += $ara_row->credit;
            } else {
                $paid_amount += $ara_row->credit_idr;
            }
        }

        return $paid_amount;
    }

    public function datatables(Request $request)
    {
        $AR = AReceive::where('uuid', $request->ar_uuid)->first();
        $ARA = AReceiveA::where('ar_id', $AR->id)
            ->with([
                'ar',
                'arc',
                'ar.currencies',
                'currencies'
            ])
            ->get();

        for ($ara_index = 0; $ara_index < count($ARA); $ara_index++) {
            $ara_row = $ARA[$ara_index];

            $ARA[$ara_index]->_transaction_number = $ara_row->id_invoice;
            $ARA[$ara_index]->invoice = $this->getDataInvoice($ara_row);
            $ARA[$ara_index]->paid_amount = $this->countPaidAmount($ara_row);
            if ($AR->currencies->code == 'idr') {
                $ARA[$ara_index]->credit = $ARA[$ara_index]->credit_idr;
            }
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
