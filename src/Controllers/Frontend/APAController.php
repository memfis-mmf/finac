<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use memfisfa\Finac\Model\TrxPayment;
use memfisfa\Finac\Model\TrxPaymentA;
use memfisfa\Finac\Model\APayment;
use memfisfa\Finac\Model\APaymentA;
use memfisfa\Finac\Model\APaymentB;
use memfisfa\Finac\Model\APaymentC;
use memfisfa\Finac\Request\APaymentAUpdate;
use memfisfa\Finac\Request\APaymentAStore;
use App\Http\Controllers\Controller;
use App\Models\GoodsReceived as GRN;
use App\Models\GoodsReceived;
use Illuminate\Support\Str;
use DB;

class APAController extends Controller
{
    public function index()
    {
        return redirect()->route('apaymenta.create');
    }

    public function create()
    {
        return view('apaymentaview::index');
    }

    public function store(Request $request)
    {
        $AP = APayment::where('uuid', $request->ap_uuid)->first();
        if ($AP->approve) {
            return abort(404);
        }

        $APA = $AP->apa->first();

        // cek type
        if ($request->type == "GRN") {
            $grn = GRN::where('uuid', $request->data_uuid)->first();
            $trxpaymenta = TrxPaymentA::where('id_grn', $grn->id)->first();

            // jika data yang sudah terinput itu GRN
            if ($APA) {
                if ($APA->type != 'GRN') {
                    return [
                        'errors' => 'Data detail must not GRN'
                    ];
                }
            }
            $si = $trxpaymenta->si;
            $id = $grn->id;
        } else {
            $si = TrxPayment::where('uuid', $request->data_uuid)->first();
            $id = $si->id;
            // jika data yang sudah terinput itu GRN
            if ($APA) {
                if ($APA->type == 'GRN') {
                    return [
                        'errors' => 'Data detail must be GRN'
                    ];
                }
            }
        }

        // cek currency
        // jika currency inputan pertama berbeda dengan currency inputan ke dua
        if ($APA) {
            if ($APA->currency != $si->currency) {
                return [
                    'errors' => 'Currency not consistent'
                ];
            }
        }

        $duplicate_check = $AP->apa()->where('type', $request->type)
            ->where('id_payment', $id)
            ->first();

        if ($duplicate_check) {
            return [
                'errors' => 'Data Already exist'
            ];
        }

        $request->request->add([
            'description' => '',
            'transactionnumber' => $AP->transactionnumber,
            'ap_id' => $AP->id,
            'id_payment' => $id,
            'currency' => $si->currency,
            'exchangerate' => $si->exchange_rate,
            'code' => $si->vendor->coa->first()->code,
            'type' => $request->type,
        ]);

        $apaymenta = APaymentA::create($request->all());
        return response()->json($apaymenta);
    }

    public function edit(APaymentA $apaymenta)
    {
        $ap = $apaymenta->ap;
        if ($ap->approve) {
            return abort(404);
        }
        return response()->json($apaymenta);
    }

    public function calculateAmount($apa, $request)
    {
        $amount_to_pay = $request->debit;
        $si = $apa->getSI();
        $ap = $apa->ap;

        if ($apa->type == 'GRN') {
            $grn = GRN::where('id', $apa->id_payment)->first();
            $trxpaymenta = TrxPaymentA::where('id_grn', $grn->id)->first();

            $si->grandtotal_foreign = $trxpaymenta->total;
            $si->grandtotal = $trxpaymenta->total_idr;
        }

        // jika header ap currency nya idr
        if ($ap->currencies->code == 'idr') {
            // jik currency ap IDR dan si foreign
            if ($ap->currencies->code != $si->currencies->code) {
                // mencari foreign amount to pay, 
                // dengan cara membagi amount to pay dengan rate ar
                $foreign_amount_to_pay = $amount_to_pay / $ap->exchangerate;
                // mencari nilai rupiah dengan rate si 
                // dari nilai usd ap yang sudah dihitung sblmnya
                $idr_amount_to_pay_si_rate =
                    $foreign_amount_to_pay * $si->exchange_rate;

                $result = [
                    // amount to pay idr dari ap dikurangi hasil rupiah
                    // dari usd ap dikali dengan rate si
                    'gap' => round(
                        $amount_to_pay - $idr_amount_to_pay_si_rate,
                        2
                    ),
                    'debit' => round($foreign_amount_to_pay, 2),
                    'debit_idr' => round($amount_to_pay, 2),
                ];
            } else { //jika ap IDR dan si IDR
                $result = [
                    'gap' => 0,
                    'debit' => round($amount_to_pay, 2),
                    'debit_idr' => round($amount_to_pay, 2),
                ];
            }
        }

        // jika header ap currency nya Foreign
        if ($ap->currencies->code != 'idr') {
            // jik currency ap Foreign dan si IDR
            if ($ap->currencies->code != $si->currencies->code) {

                $idr_amount_to_pay = $amount_to_pay * $ap->exchangerate;

                // jika belum pembayaran terakhir (clearing tidak di centang)
                if (!$request->is_clearing) {
                    $gap = 0;
                } else { //jika pembayaran terakhir
                    $all_si = APaymentA::select(
                        'sum(debit) as total_debit',
                        'sum(debit_idr) as total_debit_idr',
                    );

                    if (strtolower($apa->type) == 'grn') {
                        $grn_id = $si->trxpaymenta()->pluck('id_grn')->all();
                        $all_si = $all_si->whereIn('id_payment', $grn_id);
                    } else {
                        $all_si = $all_si->where('id_payment', $si->id);
                    }

                    $all_si = $all_si->where('type', $apa->type)->first();

                    $total_debit_idr =
                        $all_si->total_debit_idr + $idr_amount_to_pay;

                    $gap = $idr_amount_to_pay -
                        ($si->grandtotal - $total_debit_idr);
                }

                $debit = $amount_to_pay;
                $debit_idr = $idr_amount_to_pay;

                $result = [
                    'gap' => $gap,
                    'debit' => $debit,
                    'debit_idr' => $debit_idr,
                ];
            } else { //jika ap Foreign dan si Foreign
                $new_rate = $ap->exchangerate - $si->exchange_rate;

                $result = [
                    'gap' => ($new_rate * $amount_to_pay),
                    'debit' => $amount_to_pay,
                    'debit_idr' => $amount_to_pay * $ap->exchangerate,
                ];
            }
        }

        return (object) $result;
    }

    public function checkAmount($apa, $request)
    {
        $amount_to_pay = $request->debit;

        $si = $apa->getSI();
        if ($apa->type == 'GRN') {
            $grn = GRN::where('id', $apa->id_payment)->first();
            $trxpaymenta = TrxPaymentA::where('id_grn', $grn->id)->first();

            $si->grandtotal_foreign = $trxpaymenta->total;
            $si->grandtotal = $trxpaymenta->total_idr;
        }

        // get all payment amount si
        $query = APaymentA::where('id_payment', $si->id)
            ->where('id', '!=', $apa->id);

        // jika si foreign
        if ($si->currencies->code != 'idr') {
            $total_si_payment_amount = $query->sum('debit');
        } else { //jika si idr
            $total_si_payment_amount = $query->sum('debit_idr');
        }

        $total_si_payment_amount += $amount_to_pay;

        // jika currency ap dan si sama
        if ($apa->ap->currencies->code == $si->currencies->code) {
            if ($total_si_payment_amount > $si->grandtotal_foreign) {
                return (object)[
                    'status' => false,
                    'message' => 'Total amount payment is more than si amount',
                ];
            }
        }

        return (object)[
            'status' => true,
            'message' => ''
        ];
    }

    public function update(APaymentAUpdate $request, APaymentA $apaymenta)
    {

        $ap = $apaymenta->ap;
        if ($ap->approve) {
            return abort(404);
        }

        DB::beginTransaction();

        $calculation = $this->calculateAmount($apaymenta, $request);
        $check_amount = $this->checkAmount($apaymenta, $request);

        if (!$check_amount->status) {
            return response()->json([
                'errors' => $check_amount->message
            ]);
        }

        $request->merge([
            'debit' => $calculation->debit,
            'debit_idr' => $calculation->debit_idr,
        ]);

        $apaymenta->update($request->all());

        $apa = $apaymenta;

        $apc = $apa->apc;

        $apc_debit = 0;
        $apc_credit = 0;
        if ($calculation->gap <= 0) {
            $apc_credit = $calculation->gap;
        } else {
            $apc_debit = $calculation->gap;
        }

        if ($apc) {
            APaymentC::where('id', $apc->id)->update([
                'debit' => $apc_debit,
                'credit' => $apc_credit,
            ]);
        } else {
            APaymentC::create([
                'apa_id' => $apa->id,
                'ap_id' => $apa->ap->id,
                'transactionnumber' => $apa->transactionnumber,
                'id_payment' => $apa->id_payment,
                'code' => '81112003',
                'debit' => $apc_debit,
                'credit' => $apc_credit,
            ]);
        }

        DB::commit();

        return response()->json($apaymenta);
    }

    public function destroy(APaymentA $apaymenta)
    {
        $ap = $apaymenta->ap;
        if ($ap->approve) {
            return abort(404);
        }
        APaymentC::where('apa_id', $apaymenta->id)->forceDelete();
        $apaymenta->forceDelete();

        return response()->json($apaymenta);
    }

    public function api()
    {
        $apaymentadata = APaymentA::all();

        return json_encode($apaymentadata);
    }

    public function apidetail(APaymentA $apaymenta)
    {
        return response()->json($apaymenta);
    }

    public function getDataSI($apa)
    {
        // if id payment is GRN number
        if ($apa->type == 'GRN') {
            $grn = GRN::where('id', $apa->id_payment)->first();
            $trxpaymenta = TrxPaymentA::where('id_grn', $grn->id)->first();

            $si = $trxpaymenta->si()->with(['currencies'])->first();
            $si->grandtotal_foreign = $trxpaymenta->total;
            $si->grandtotal = $trxpaymenta->total_idr;
            $result = $si;
        } else {
            $result = TrxPayment::where('id', $apa->id_payment)
                ->with(['currencies'])
                ->first();
        }

        return $result;
    }

    public function countPaidAmount($apa_tmp)
    {
        $si = $apa_tmp->si;
        // ambil semua data pembayaran invoice ini
        $apa = APaymentA::where('id_payment', $si->id)
            ->where('type', $apa_tmp->type)
            ->get();

        $paid_amount = 0;
        foreach ($apa as $apa_row) {
            if ($si->currencies->code != 'idr') {
                $paid_amount += $apa_row->debit;
            } else {
                $paid_amount += $apa_row->debit_idr;
            }
        }

        return $paid_amount;
    }

    public function datatables(Request $request)
    {
        $AP = APayment::where('uuid', $request->ap_uuid)->first();
        $APA = APaymentA::where('ap_id', $AP->id)
            ->with([
                'ap',
                'apc',
                'ap.currencies',
                'currencies'
            ])
            ->get();

        for ($apa_index = 0; $apa_index < count($APA); $apa_index++) {
            $apa_row = $APA[$apa_index];

            if ($apa_row->type == 'GRN') {
                $transaction_number = GoodsReceived::findOrFail($apa_row->id_payment)->number;
            } else {
                $transaction_number = TrxPayment::findOrFail($apa_row->id_payment)->transaction_number;
            }

            $APA[$apa_index]->_transaction_number = $transaction_number;
            $APA[$apa_index]->si = $this->getDataSI($apa_row);
            $APA[$apa_index]->paid_amount = $this->countPaidAmount($apa_row);
            if ($AP->currencies->code == 'idr') {
                $APA[$apa_index]->credit = $APA[$apa_index]->credit_idr;
            }
        }

        $data = $alldata = json_decode(
            $APA
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
