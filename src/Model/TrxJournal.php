<?php

namespace memfisfa\Finac\Model;


use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;
use memfisfa\Finac\Model\TrxJournalA;
use memfisfa\Finac\Model\TypeJurnal;
use App\Models\GoodsReceived as GRN;
use App\Models\Currency;
use App\User;
use App\Models\Approval;
use Illuminate\Validation\ValidationException;
use Auth;
use Illuminate\Support\Facades\DB;

class TrxJournal extends MemfisModel
{
    protected $table = "trxjournals";

    protected $fillable = [
		'approve',
		'voucher_no',
		'transaction_date',
		'ref_no',
		'currency_code',
		'exchange_rate',
		'journal_type',
		'total_transaction',
		'automatic_journal_type',
    ];

	protected $appends = [
		'created_by',
		'updated_by',
		'approved_by',
	];

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

	public function getApprovedByAttribute()
	{
		$approval = $this->approvals->first();
		$conducted_by = @User::find($approval->conducted_by)->name;

		$result = '-';

		if ($conducted_by) {
			$result = $conducted_by.' '.$approval->created_at;
		}

		return $result;
	}

	public function getCreatedByAttribute()
	{
		$audit = $this->audits->first();
		$conducted_by = @User::find($audit->user_id)->name;

		$result = '-';

		if ($conducted_by) {
			$result = $conducted_by.' '.$this->created_at;
		}

		return $result;
	}

	public function getUpdatedByAttribute()
	{
		$tmp = $this->audits;

		$result = '-';

		if (count($tmp) > 1) {
			$result =  User::find($tmp[count($tmp)-1]->user_id)->name
			.' '.$this->created_at;
		}

		return $result;
	}

	static public function getJournalCode($journal_type_id)
	{
		$type = TypeJurnal::find($journal_type_id);

		if($type->code == 'GJV' || $type->code == 'ADJ') {
			$code = "J".$type->code;
		}

		return $code;
	}

	static public function generateCode($code = "JADJ")
	{
		$journal = TrxJournal::orderBy('id', 'desc')
			->where('voucher_no', 'like', $code.'%');

		if (!$journal->count()) {

			if ($journal->withTrashed()->count()) {
				$order = $journal->withTrashed()->count() + 1;
			}else{
				$order = 1;
			}

		}else{
			$order = $journal->withTrashed()->count() + 1;
		}

		$number = str_pad($order, 5, '0', STR_PAD_LEFT);

		$code = $code."-".date('Y')."/".$number;

		return $code;
	}

	/*
	 *jangan copy function dibawah ini untuk membuat function lain
	 *yang seperti ini, copy function insertFromAP saja
	 */
	static public function insertFromBS($header, $detail)
	{
		$data['voucher_no'] = $header->transaction_number;
		$data['transaction_date'] = $header->transaction_date;
		$data['journal_type'] = TypeJurnal::where('code', 'GJV')->first()->id;
		$data['currency_code'] = 'idr';
		$data['exchange_rate'] = 1;

		$journal = TrxJournal::create($data);

		$total = $header->value;

		for($a = 0; $a < count($detail); $a++) {

			if($detail[$a]) {

				$debit = $header->value;
				$credit = 0;

				/*
				 *jika sudah bukan loopingan pertama
				 */
				if ($a > 0) {
					$debit = 0;
					$credit = $header->value;
				}

				TrxJournalA::create([
					'voucher_no' => $data['voucher_no'],
					'account_code' => $detail[$a]->code,
					'debit' => $debit,
					'credit' => $credit,
				]);
			}

		}

		TrxJournal::where('id', $journal->id)->update([
			'total_transaction' => $header->value
		]);
	}

	static public function insertFromBSR($header, $detail)
	{
		$data['voucher_no'] = $header->transaction_number;
		$data['transaction_date'] = $header->transaction_date;
		$data['journal_type'] = TypeJurnal::where('code', 'GJV')->first()->id;
		$data['currency_code'] = 'idr';
		$data['exchange_rate'] = 1;

		$journal = TrxJournal::create($data);

		$total = $header->value;

		for($a = 0; $a < count($detail); $a++) {

			if($detail[$a]) {

				$credit = $header->value;
				$debit = 0;

				/*
				 *jika sudah bukan loopingan pertama
				 */
				if ($a > 0) {
					$credit = 0;
					$debit = $header->value;
				}

				TrxJournalA::create([
					'voucher_no' => $data['voucher_no'],
					'account_code' => $detail[$a]->code,
					'debit' => $debit,
					'credit' => $credit,
				]);
			}

		}

		TrxJournal::where('id', $journal->id)->update([
			'total_transaction' => $header->value
		]);
	}

	// approve journal

	static public function approve($journal, $auto = false)
	{

		try {

	        $journal->first()->approvals()->save(new Approval([
	            'approvable_id' => $journal->first()->id,
	            'conducted_by' => Auth::id(),
	            'note' => @$request->note,
	            'is_approved' => 1
	        ]));

			$journal->update([
				'approve' => 1
			]);

			return true;

		} catch (\Exception $e) {

			return false;

		}

	}

	// auto journal

	/**
	* $header : [
	* 'voucher_no', //voucher numer of data sended
	* 'transaction_date', //date of approved data sended
	* 'coa_piutang', //coa piutang (coa customer)
	* ]
	*
	* $detail : [
	*  [
	*   'value',
	*   'coa_piutang',
	*  ],
	*  [
	*   'value',
	*   'coa_piutang',
	*  ],
	* ]
	*
	* $journal_type // type of journal
	* $journal_prefix_number // journal prefix number
	* $income_outcome // income or outcome
	*/
	static public function autoJournal(
		$header,
		$detail,
		$journal_prefix_number,
		$journal_type
	)
	{

		$data['voucher_no'] = TrxJournal::generateCode($journal_prefix_number);
		$data['ref_no'] = $header->voucher_no;
		$data['transaction_date'] = $header->transaction_date;
		$data['journal_type'] = TypeJurnal::where(
			'code', $journal_type
		)->first();
		if ($data['journal_type']) {
			$data['journal_type'] = $data['journal_type']->id;
		}else{
			return [
				'status' => false,
				'message' => 'journal_type not found : '.$journal_type
			];
		}
		$data['currency_code'] = 'idr';
		$data['exchange_rate'] = 1;
        $data['description'] = 'Generate from auto journal '.$data['voucher_no'];

        DB::beginTransaction();

		$journal = TrxJournal::create($data);

		$total_credit = 0;
		$total_debit = 0;

		for ($i = 0; $i < count($detail); $i++) {

			$x = $detail[$i];

			// if ($x->debit != 0 || $x->credit != 0) {

				TrxJournalA::create([
					'voucher_no' => $data['voucher_no'],
					'account_code' => $x->coa_detail,
					'credit' => $x->credit,
					'debit' => $x->debit,
					// 'description' => 'Generate from auto journal, '.$header->voucher_no,
					'description' => $x->_desc
				]);

			// }

			$total_credit += $x->credit;
			$total_debit += $x->debit;
		}

		$tmp_journal = TrxJournal::where('id', $journal->id);

		$tmp_journal->update([
			// income outcome tidak pengaruh untu variable satu ini
			'total_transaction' => $total_credit
		]);

		// TrxJournal::approve($tmp_journal);

		if ($total_debit != $total_credit) {
			return [
				'status' => false,
				'message' => 'Invalid debit or credit value'
			];
        }

        DB::commit();

		return ['status' => true];
	}
	// end auto journal

	static public function insertFromGRN($header, $detail)
	{
		try {
			$data['voucher_no'] = TrxJournal::generateCode('PRJR');
			$data['ref_no'] = $header->voucher_no;
			$data['transaction_date'] = $header->transaction_date;
			$data['journal_type'] = TypeJurnal::where('code', 'PRJ')->first()->id;
			$data['currency_code'] = 'idr';
			$data['exchange_rate'] = 1;
			$data['description'] = 'Generate from auto journal '.$data['voucher_no'];

			$total_debit = 0;

            $detail_tmp = $detail;

            $sumDetail = [];

            foreach ($detail as $detailVal) {
                $coaExist = false;

                foreach ($sumDetail as $key => $sumDetailValue) {
                    if ($detailVal->coa_iv == $sumDetailValue->coa_detail) {
                        $sumDetail[$key]->debit += $detailVal->val;
                        $coaExist = true;
                    }
                }

                if (!$coaExist) {
                    $newSumDetail = (object)[
                        'coa_detail' => $detailVal->coa_iv,
                        'debit' => $detailVal->val,
                        'credit' => 0,
                        '_desc' => 'Increased Inventory : '
                        .$header->voucher_no.' '
                        .$header->supplier.' ',
                    ];

                    $sumDetail[] = $newSumDetail;
                }
            }

            $newSumDetail = (object) [
                'coa_detail' => $detail[0]->coa_vendor,
                'debit' => 0,
                'credit' => 0,
                '_desc' => 'Increased Inventory : '
                .$header->voucher_no.' '
                .$header->supplier.' ',
            ];

            foreach ($detail as $detailVal) {

                $newSumDetail->credit += $detailVal->val;
            }

            $sumDetail[] = $newSumDetail;

			TrxJournal::autoJournal($header, $sumDetail, 'PRJR', 'PRJ');

			return [
				'status' => true,
				'message' => ''
			];

		} catch (\Exception $e) {

			return [
				'status' => false,
				'message' => $e
			];

		}
	}

	static public function insertFromIvOut($header, $detail)
	{
        try {
            $sum_detail = [];

            // looping sebanyak item
            foreach ($detail as $detail_row) {
                $coaExistIv = false;
                $coaExistCogs = false;

                // looping sebanyak array baru
                foreach ($sum_detail as $sum_detail_row) {
                    // biaya
                    if ($detail_row->coa_cogs == $sum_detail_row->coa_detail) {
                        if ($detail_row->item_id == $sum_detail_row->item_id) {
                            $sum_detail_row->debit += $detail_row->val;
                            $coaExistCogs = true;
                        }
                    }

                    // persediaan
                    if ($detail_row->coa_iv == $sum_detail_row->coa_detail) {
                        if ($detail_row->item_categories->id == $sum_detail_row->item_categories_id) {
                            $sum_detail_row->credit += $detail_row->val;
                            $coaExistIv = true;
                        }
                    }
                }

                // jika coa cogs statusnya false
                if (!$coaExistCogs) {
                    $sum_detail[] = (object)[
                        'item_id' => $detail_row->item_id,
                        'coa_detail' => $detail_row->coa_cogs,
                        'item_categories_id' => $detail_row->item_categories->id,
                        'debit' => $detail_row->val,
                        'credit' => 0,
                        '_desc' => 'Material Usage: '
                            . $header->voucher_no 
                            . ' '
                            . $detail_row->part_number 
                    ];
                }

                // jika coa iv statusnya false
                if (!$coaExistIv) {
                    // create new array baru
                    $sum_detail[]  = (object)[
                        'item_id' => $detail_row->item_id,
                        'coa_detail' => $detail_row->coa_iv,
                        'item_categories_id' => $detail_row->item_categories->id,
                        'debit' => 0,
                        'credit' => $detail_row->val,
                        '_desc' => 'Increased Inventory : '
                            . $header->voucher_no 
                            . ' '
                            . $detail_row->item_categories->name 
                    ];
                }
            }

            usort($sum_detail, function ($item1, $item2) {
                return $item2->debit <=> $item1->debit;
            });

            // get status dari autoJournal
            $auto_journal = TrxJournal::autoJournal(
                $header,
                $sum_detail,
                'PRJR',
                'GJV'
            );

            return $auto_journal;

		} catch (\Exception $e) {

			return [
				'status' => false,
				'message' => $e->getMessage()
			];

		}
	}

	public function getTransactionDateYmdAttribute()
	{
		return date(
			'Y-m-d', strtotime($this->transaction_date)
		);
	}

	public function type_jurnal()
	{
		return $this->belongsTo(
			'memfisfa\Finac\Model\TypeJurnal',
			'journal_type'
		);
	}

	public function currency()
	{
		return $this->hasOne(
			'App\Models\Currency',
			'code',
			'currency_code'
		);
	}

	public function journala()
	{
		return $this->hasMany(
			'memfisfa\Finac\Model\TrxJournalA',
			'voucher_no',
			'voucher_no'
		);
	}
}
