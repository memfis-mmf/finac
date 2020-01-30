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

	static public function insertFromInvoice($header, $detail)
	{
		$data['voucher_no'] = $header->transactionnumber;
		$data['transaction_date'] = $header->transactiondate;
		$data['journal_type'] = TypeJurnal::where('code', 'SRJ')->first()->id;
		$data['currency_code'] = $header->currencies->code;
		$data['exchange_rate'] = $header->exchangerate;

		$journal = TrxJournal::create($data);

		$total = 0;
		for($a = 0; $a < count($detail); $a++) {

			if($detail[$a]) {
				TrxJournalA::create([
					'voucher_no' => $data['voucher_no'],
					'account_code' => @($v = $detail[$a]->accountcode)? $v: 0,
					'credit' => $detail[$a]->amount,
				]);

				$total += $detail[$a]->amount;
			}

		}

		TrxJournalA::create([
			'voucher_no' => $data['voucher_no'],
			'account_code' => $header->accountcode,
			'debit' => $total,
		]);

		TrxJournal::where('id', $journal->id)->update([
			'total_transaction' => $total
		]);
	}

	static public function insertFromSI($header, $detail, $coa_credit)
	{
		$data['voucher_no'] = TrxJournal::generateCode('PRJR');
		$data['transaction_date'] = $header->transaction_date;
		$data['journal_type'] = TypeJurnal::where('code', 'BPJ')->first()->id;
		$data['currency_code'] = $header->currency;
		$data['exchange_rate'] = $header->exchange_rate;

		$journal = TrxJournal::create($data);

		$total = 0;
		for($a = 0; $a < count($detail); $a++) {

			if($detail[$a]) {
				TrxJournalA::create([
					'voucher_no' => $data['voucher_no'],
					'account_code' => $detail[$a]->coa->id,
					'debit' => $detail[$a]->total,
				]);

				$total += $detail[$a]->total;
			}

		}

		TrxJournalA::create([
			'voucher_no' => $data['voucher_no'],
			'account_code' => $coa_credit,
			'credit' => $total,
		]);

		TrxJournal::where('id', $journal->id)->update([
			'total_transaction' => $total
		]);
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

	static public function insertFromAP($header, $detail)
	{
		$data['voucher_no'] = $header->transactionnumber;
		$data['transaction_date'] = $header->transactiondate;
		$data['journal_type'] = TypeJurnal::where('code', 'BPJ')->first()->id;
		$data['currency_code'] = $header->currency;
		$data['exchange_rate'] = $header->exchangerate;

		$journal = TrxJournal::create($data);

		$total = 0;
		for($a = 0; $a < count($detail); $a++) {

			if($detail[$a]) {
				TrxJournalA::create([
					'voucher_no' => $data['voucher_no'],
					'account_code' => @($v = $detail[$a]->coa->id)? $v: 0,
					'debit' => $detail[$a]->debit,
				]);

				$total += $detail[$a]->debit;
			}

		}

		TrxJournalA::create([
			'voucher_no' => $data['voucher_no'],
			'account_code' => $header->coa->id,
			'credit' => $total,
		]);

		TrxJournal::where('id', $journal->id)->update([
			'total_transaction' => $total
		]);
	}

	static public function insertFromAR($header, $detail)
	{
		$data['voucher_no'] = $header->transactionnumber;
		$data['transaction_date'] = $header->transactiondate;
		$data['journal_type'] = TypeJurnal::where('code', 'BRJ')->first()->id;
		$data['currency_code'] = $header->currency;
		$data['exchange_rate'] = $header->exchangerate;

		$journal = TrxJournal::create($data);

		$total = 0;
		for($a = 0; $a < count($detail); $a++) {

			if($detail[$a]) {
				TrxJournalA::create([
					'voucher_no' => $data['voucher_no'],
					'account_code' => @($v = $detail[$a]->coa->id)? $v: 0,
					'credit' => $detail[$a]->credit,
				]);

				$total += $detail[$a]->credit;
			}

		}

		TrxJournalA::create([
			'voucher_no' => $data['voucher_no'],
			'account_code' => $header->coa->id,
			'credit' => $total,
		]);

		TrxJournal::where('id', $journal->id)->update([
			'total_transaction' => $total
		]);
	}

	static public function insertFromGRN($header, $detail)
	{

		try {
			$data['voucher_no'] = $header->voucher_no;
			$data['transaction_date'] = $header->transaction_date;
			$data['journal_type'] = TypeJurnal::where('code', 'PRJ')->first()->id;
			$data['currency_code'] = 'idr';
			$data['exchange_rate'] = 1;
			$data['description'] = 'Generate from auto journal '.$data['voucher_no'];

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

			return true;
			
		} catch (\Exception $e) {

			return false;

		}
	}

	static public function insertFromIvOut($header, $detail)
	{

		try {

			$data['voucher_no'] = $header->voucher_no;
			$data['transaction_date'] = $header->transaction_date;
			$data['journal_type'] = TypeJurnal::where('code', 'PRJ')->first()->id;
			$data['currency_code'] = 'idr';
			$data['exchange_rate'] = 1;
			$data['description'] = 'Generate from auto journal '.$data['voucher_no'];

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
