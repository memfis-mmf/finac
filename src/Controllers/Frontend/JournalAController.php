<?php

namespace memfisfa\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use memfisfa\Finac\Model\TrxJournalA as JournalA;
use memfisfa\Finac\Model\TrxJournal as Journal;
use memfisfa\Finac\Model\Coa;
use memfisfa\Finac\Request\JournalAUpdate;
use memfisfa\Finac\Request\JournalAStore;
use App\Http\Controllers\Controller;
use DataTables;

class JournalAController extends Controller
{
    public function index()
    {
        return redirect()->route('journala.create');
    }

    public function create()
    {
        return view('journalaview::index');
    }

    public function store(JournalAStore $request)
    {
		$coa = Coa::where('code', $request->account_code)->first();

		$request->merge([
			'account_code' => $coa->id
		]);

		$request->request->add([
			'debit' => 0,
			'credit' => 0,
		]);

		if ($request->methodpayment == 'debet') {
			$method = 'debit';
		}else{
			$method = 'credit';
		}

		$request->request->add([
			$method => $request->amount,
			'description' => $request->remark
		]);

        $journala = JournalA::create($request->all());

		$this->updateJournalTotalTransaction($request->voucher_no);

        return response()->json($journala);
    }

    public function edit(Request $request)
    {
		$journala = JournalA::where('uuid', $request->journala)->with([
			'coa',
			'coa.type',
		])->first();

        return response()->json($journala);
    }

    public function update(Request $request)
    {
		$request->request->add([
			'debit' => 0,
			'credit' => 0,
		]);

		if ($request->methodpayment == 'debet') {
			$method = 'debit';
			$otherMethod = 'credit';
		}else{
			$method = 'credit';
			$otherMethod = 'debit';
		}

		$request->request->add([
			$method => $request->amount,
			$otherMethod => 0,
			'description' => $request->remark
		]);

        $journala = JournalA::where('uuid', $request->uuid);

		$journala->update(
			$request->only([
				$method,
				$otherMethod,
				'description',
			])
		);

		$this->updateJournalTotalTransaction($journala->first()->voucher_no);

        return response()->json($journala);
    }

    public function destroy(JournalA $journala)
    {
        $journala->delete();

		$this->updateJournalTotalTransaction($journala->voucher_no);

        return response()->json($journala);
    }

    public function api()
    {
        $journaladata = JournalA::all();

        return json_encode($journaladata);
    }

    public function apidetail(JournalA $journala)
    {
        return response()->json($journala);
    }

    public function datatables(Request $request)
    {
        $data = JournalA::where('voucher_no', $request->voucher_no)->with([
            'coa',
            'coa.type',
        ])->orderBy('trxjournala.id', 'DESC')->get();

        $total_debit = 0;
        $total_credit = 0;

        foreach ($data as $item) {
            $total_debit += $item->debit;
            $total_credit += $item->credit;
        }

        return DataTables::of($data)
		->addColumn('total_debit', function() use($total_debit) {
			return $total_debit;
		})
		->addColumn('total_credit', function() use($total_credit){
			return $total_credit;
		})
        ->make(true);
    }

	public function updateJournalTotalTransaction($voucher_no)
	{
		$journala = JournalA::where('voucher_no', $voucher_no)->get();

		$totalDebit = 0;
		$totalCredit = 0;
		for ($a=0; $a < count($journala); $a++) {
			$x = $journala[$a];

			$totalDebit += $x->debit;
			$totalCredit += $x->credit;
		}

		$total = ($v = $totalDebit)? $v: $totalCredit;

		Journal::where('voucher_no', $voucher_no)->update([
			'total_transaction' => $total
		]);
	}
}
