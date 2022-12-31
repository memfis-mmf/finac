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
use memfisfa\Finac\Model\TrxJournal;
use memfisfa\Finac\Model\TrxJournalA;

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
        $journal = TrxJournal::where('voucher_no', $request->voucher_no)->first();
        if ($journal->approve) {
            return abort(404);
        }
		$coa = Coa::where('code', $request->account_code)->first();

		$request->merge([
			'account_code' => $coa->id
		]);

		$request->merge([
			'debit' => 0,
			'credit' => 0,
		]);

		if ($request->methodpayment == 'debet') {
			$method = 'debit';
		}else{
			$method = 'credit';
		}

		$request->merge([
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
        $journal = $journala->journal;
        if ($journal->approve) {
            return abort(404);
        }

        return response()->json($journala);
    }

    public function update(Request $request)
    {
        $journala = JournalA::where('uuid', $request->uuid);
        $journal = $journala->first()->journal;

        if ($journal->approve) {
            return abort(404);
        }

		$request->merge([
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

		$request->merge([
			$method => $request->amount,
			$otherMethod => 0,
			'description' => $request->remark
		]);

		$journala->update(
			$request->only([
				$method,
                $otherMethod,
                'id_project',
				'description',
			])
		);

		$this->updateJournalTotalTransaction($journala->first()->voucher_no);

        return response()->json($journala);
    }

    public function updateAfterApprove(Request $request, $journala_uuid)
    {
        $journala = JournalA::where('uuid', $journala_uuid);

		$journala->update([
				'description_2' => $request->description_2,
			]);

        return [
            'status' => true,
            'message' => 'Data Saved'
        ];
    }

    public function destroy(JournalA $journala)
    {
        $journal = $journala->journal;
        if ($journal->approve) {
            return abort(404);
        }
        $journala->forceDelete();

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
            'coa.type',
            'journal.currency',
            'project'
        ])->orderBy('trxjournala.id', 'DESC')->get();

        $total_debit = 0;
        $total_credit = 0;

        foreach ($data as $item) {
            $total_debit += $item->debit;
            $total_credit += $item->credit;
        }

        return datatables()->of($data)
            ->addColumn('total_debit', function() use($total_debit) {
                return $total_debit;
            })
            ->addColumn('total_credit', function() use($total_credit){
                return $total_credit;
            })
            ->addColumn('ref_debit', function($row){
                $amount = $this->getRefAmount($row, $row->debit);

                if (!$amount) {
                    return '-';
                }

                $format_amount = number_format($amount, 0, ',', '.');
                return "{$row->journal->ref_collection->currency->symbol} {$format_amount}";
            })
            ->addColumn('ref_credit', function($row){
                $amount = $this->getRefAmount($row, $row->credit);

                if (!$amount) {
                    return '-';
                }

                $format_amount = number_format($amount, 0, ',', '.');
                return "{$row->journal->ref_collection->currency->symbol} {$format_amount}";
            })
            ->addColumn('description_formated', function($row) {
                return $row->description_2 ?? $row->description;
            })
            ->make(true);
    }

    public function datatablesAfterApprove(Request $request)
    {
        $data = JournalA::where('voucher_no', $request->voucher_no)->with([
            'coa.type',
            'journal.currency',
            'project'
        ])->orderBy('trxjournala.id', 'DESC')->get();

        $total_debit = 0;
        $total_credit = 0;

        foreach ($data as $item) {
            $total_debit += $item->debit;
            $total_credit += $item->credit;
        }

        return datatables()->of($data)
		->addColumn('total_debit', function() use($total_debit) {
			return $total_debit;
		})
		->addColumn('total_credit', function() use($total_credit){
			return $total_credit;
		})
        ->addColumn('description_field', function($row) {
            $description = $row->description_2 ?? $row->description;

            $html = "<textarea class='form-control not-disabled'>$description</textarea>";

            return $html;
        })
        ->addColumn('action', function($row) {
            $html = 
            '<button 
                type="button"
                class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill save-description" 
                title="Save" data-uuid="'.$row->uuid.'"> 
                <i class="la la-check"></i> 
            </button>';

            return $html;
        })
        ->addColumn('url', function($row) {
            return route('journala.update-after-approve', $row->uuid);
        })
        ->escapeColumns([])
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

    public function getRefAmount(TrxJournalA $journal_detail, $amount)
    {
        $journal = $journal_detail->journal;
        $ref = $journal->ref_collection;

        if ($ref->currency->code == 'idr') {
            return null;
        }

        return $amount / $ref->rate;
    }
}
