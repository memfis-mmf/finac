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
		'exchange_rate_fix',
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
		return @User::find($this->approvals->first()->conducted_by);
	}

	public function getCreatedByAttribute()
	{
		return User::find($this->audits->first()->user_id);
	}

	public function getUpdatedByAttribute()
	{
		$tmp = $this->audits;

		$result = '';

		if (count($tmp) > 1) {
			$result =  User::find($tmp[count($tmp)-1]->user_id);
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

		$code = $code."-".date('Y/m')."/".$number;

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
		)->first()->id;
		$data['currency_code'] = 'idr';
		$data['exchange_rate'] = 1;
		$data['description'] = 'Generate from auto journal '.$data['voucher_no'];

		$journal = TrxJournal::create($data);

		$total_credit = 0;
		$total_debit = 0;

		for ($i = 0; $i < count($detail); $i++) {

			$x = $detail[$i];

			if ($x->debit != 0 || $x->credit != 0) {

				TrxJournalA::create([
					'voucher_no' => $data['voucher_no'],
					'account_code' => $x->coa_detail,
					'credit' => $x->credit,
					'debit' => $x->debit,
					'description' => 'Generate from auto journal, '.$header->voucher_no,
				]);

			}

			$total_credit += $x->credit;
			$total_debit += $x->debit;
		}

		$tmp_journal = TrxJournal::where('id', $journal->id);

		$tmp_journal->update([
			// income outcome tidak pengaruh untu variable satu ini
			'total_transaction' => $total_credit
		]);

		TrxJournal::approve($tmp_journal);

		if ($total_debit == 0 || $total_debit != $total_credit) {
			throw ValidationException::withMessages([]);
		}

		return true;
	}

	// end auto journal

	static public function insertFromGRN_($header, $detail)
	{

		try {
			$data['voucher_no'] = $header->voucher_no;
			$data['transaction_date'] = $header->transaction_date;
			$data['journal_type'] = TypeJurnal::where('code', 'PRJ')->first()->id;
			$data['currency_code'] = 'idr';
			$data['exchange_rate'] = 1;
			$data['description'] = 'Generate from auto journal '.$data['voucher_no'];

			$journal = TrxJournal::create($data);

			$total = 0;

			for ($i = 0; $i < count($detail); $i++) {

				$x = $detail[$i];

				TrxJournalA::create([
					'voucher_no' => $data['voucher_no'],
					'account_code' => $x->coa_iv,
					'debit' => $x->val,
					'description' => 'Generate from auto journal '.$data['voucher_no'],
				]);

				$total += $x->val;
			}

			TrxJournalA::create([
				'voucher_no' => $data['voucher_no'],
				'account_code' => $param[0]->coa_vendor,
				'credit' => $total,
			]);

			TrxJournal::where('id', $journal->id)->update([
				'total_transaction' => $total
			]);

			return [
				'status' => true,
				'message' => ''
			];

		} catch (\Exception $e) {

			return [
				'status' => false,
				'message' => $e->getMessage()
			];

		}
	}

	static public function insertFromIvOut($header, $detail)
	{

		try {

			$data['voucher_no'] = $header->voucher_no;
			$data['transaction_date'] = $header->transaction_date;
			$data['journal_type'] = TypeJurnal::where('code', 'GJV')->first()->id;
			$data['currency_code'] = 'idr';
			$data['exchange_rate'] = 1;
			$data['description'] = 'Generate from auto journal '.$data['voucher_no'];

			$journal = TrxJournal::create($data);

			$total = 0;

			for ($i = 0; $i < count($detail); $i++) {

				$x = $detail[$i];

				TrxJournalA::create([
					'voucher_no' => $data['voucher_no'],
					'account_code' => $x->coa_iv,
					'credit' => $x->val,
					'description' => 'Generate from auto journal '.$data['voucher_no'],
				]);

				$total += $x->val;
			}

			TrxJournalA::create([
				'voucher_no' => $data['voucher_no'],
				'account_code' => $param[0]->coa_vendor,
				'debit' => $total,
			]);

			TrxJournal::where('id', $journal->id)->update([
				'total_transaction' => $total
			]);

			return true;

		} catch (\Exception $e) {

			return false;

		}
	}

	public function getTransactionDateYmdAttribute()
	{
		return date(
			'Y-m-d', strtotime($this->transaction_date)
		);
	}

	public function getExchangeRateFixAttribute()
	{
		return number_format($this->exchange_rate, 0, 0, '.');
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
