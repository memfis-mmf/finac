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

		if ($request->type == "GRN") {
			$grn = GRN::where('uuid', $request->data_uuid)->first();
			$trxpaymenta = TrxPaymentA::where('id_grn', $grn->id)->first();

			$APA = APaymentA::where(
				'transactionnumber',
				$AP->transactionnumber
			)->first();

			// jika data yang sudah terinput itu bukan GRN
			if ($APA && strpos($APA->id_payment, "GRN") !== true) {
				return [
					'errors' => 'Data detail must not GRN'
				];
			}

			$si = $trxpaymenta->si;

			$x['transaction_number'] = $trxpaymenta->grn->number;
		} else {
			$si = TrxPayment::where('uuid', $request->data_uuid)->first();

			$APA = APaymentA::where(
				'transactionnumber',
				$AP->transactionnumber
			)->first();

			// jika data yang sudah terinput itu GRN
			if ($APA && strpos($APA->id_payment, "GRN") !== false) {
				return [
					'errors' => 'Data detail must be GRN'
				];
			}

			$x['transaction_number'] = $si->transaction_number;
		}

		$x['currency'] = $si->currency;
		$x['exchange_rate'] = $si->exchange_rate;
		@$x['code'] = ($v = $si->vendor->coa->first()->code)? $v: '';

		$request->request->add([
			'description' => '',
			'transactionnumber' => $AP->transactionnumber,
			'id_payment' => $si->id,
			'currency' => $x['currency'],
			'exchangerate' => $x['exchange_rate'],
			'code' => $x['code'],
		]);

        $apaymenta = APaymentA::create($request->all());
        return response()->json($apaymenta);
    }

    public function edit(APaymentA $apaymenta)
    {
        return response()->json($apaymenta);
    }

    public function update(APaymentAUpdate $request, APaymentA $apaymenta)
    {

		DB::beginTransaction();
		try {

	        $apaymenta->update($request->all());

			$apa = $apaymenta;
			$ap = $apa->ap;

			$apc = APaymentC::where('id_payment', $apa->id_payment)
			->where('transactionnumber', $apa->transactionnumber)
			->first();

			$difference = ($apa->debit * $ap->exchangerate) - ($apa->debit * $apa->exchangerate);

			if ($apc) {
				APaymentC::where('id', $apc->id)->update([
					'difference' => $difference
				]);
			} else {
				APaymentC::create([
				    'transactionnumber' => $apa->transactionnumber,
				    'id_payment' => $apa->id_payment,
				    'code' => '81112003',
				    'difference' => $difference,
				]);
			}

			DB::commit();

	        return response()->json($apaymenta);

		} catch (\Exception $e) {

			DB::rollBack();

	        return response()->json($e->getMessage());

		}

    }

    public function destroy(APaymentA $apaymenta)
    {
        $apaymenta->delete();

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

	public function getDataSI($x)
	{
		// if id payment is GRN number
		if (strpos($x->id_payment, "GRN") !== false) {
			$grn = GRN::where('id', $x->id_payment)->first();
			$trxpaymenta = TrxPaymentA::where('id_grn', $grn->id)
			->with(['currencies'])
			->first();

			$result = $trxpaymenta->si;
		} else {
			$result = TrxPayment::where(
				'id',
				$x->id_payment
			)
			->with(['currencies'])
			->first();
		}

		return $result;
	}

	public function countPaidAmount($x)
	{
		$apa = APaymentA::where(
			'transactionnumber', $x->transactionnumber
		)->get();

		$ap = $apa[0]->ap;

		$data['debt_total_amount'] = TrxPayment::where(
			'id_supplier',
			$ap->vendor()->first()->id
		)->sum('grandtotal');

		$payment_total_amount = 0;

		for ($j = 0; $j < count($apa); $j++) {
			$y = $apa[$j];

			$payment_total_amount += ($y->debit * $ap->exchangerate);
		}

		$data['payment_total_amount'] = $payment_total_amount;
		$data['debt_balance'] = (
			$data['debt_total_amount'] - $data['payment_total_amount']
		);

		return $data['debt_balance'];
	}

    public function datatables(Request $request)
    {
		$AP = APayment::where('uuid', $request->ap_uuid)->first();
		$APA = APaymentA::where('transactionnumber', $AP->transactionnumber)
			->with([
				'ap',
				'ap.currencies',
				'currencies'
			])
			->get();

		for ($i=0; $i < count($APA); $i++) {
			$x = $APA[$i];

			$APA[$i]->_transaction_number = $x->id_payment;
			$APA[$i]->si = $this->getDataSI($x);
			$APA[$i]->paid_amount = $this->countPaidAmount($x);
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
			filter_var($datatable['requestIds'], FILTER_VALIDATE_BOOLEAN))
		{
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
