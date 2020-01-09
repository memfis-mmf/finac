<?php

namespace Directoryxx\Finac\Model;


use Directoryxx\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;
use Directoryxx\Finac\Model\TrxJournalA;
use Directoryxx\Finac\Model\TypeJurnal;
use App\Models\GoodsReceived as GRN;
use App\Models\Currency;
use App\User;

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
	];

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

	static public function insertFromSI($header, $detail, $coa_credit)
	{
		$data['voucher_no'] = TrxJournal::generateCode('PRJR');
		$data['transaction_date'] = $header->transaction_date;
		$data['journal_type'] = TypeJurnal::where('code', 'BPJ')->first()->id;
		$data['currency_code'] = $header->currency;
		$data['exchange_rate'] = $header->exchange_rate;

		TrxJournal::create($data);

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

		TrxJournal::create($data);

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
	}

	static public function insertFromBSR($header, $detail)
	{
		$data['voucher_no'] = $header->transaction_number;
		$data['transaction_date'] = $header->transaction_date;
		$data['journal_type'] = TypeJurnal::where('code', 'GJV')->first()->id;
		$data['currency_code'] = 'idr';
		$data['exchange_rate'] = 1;

		TrxJournal::create($data);

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
	}

	static public function insertFromAP($header, $detail)
	{
		$data['voucher_no'] = $header->transactionnumber;
		$data['transaction_date'] = $header->transactiondate;
		$data['journal_type'] = TypeJurnal::where('code', 'BPJ')->first()->id;
		$data['currency_code'] = $header->currency;
		$data['exchange_rate'] = $header->exchangerate;

		TrxJournal::create($data);

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
	}

	static public function insertFromAR($header, $detail)
	{
		$data['voucher_no'] = $header->transactionnumber;
		$data['transaction_date'] = $header->transactiondate;
		$data['journal_type'] = TypeJurnal::where('code', 'BRJ')->first()->id;
		$data['currency_code'] = $header->currency;
		$data['exchange_rate'] = $header->exchangerate;

		TrxJournal::create($data);

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
	}

	static public function insertFromGRN(
		$component,
		$consumable,
		$raw_material,
		$id_grn
	)
	{
		$po = GRN::find($id_grn)->purchase_order;

		$data['voucher_no'] = TrxJournal::generateCode();
		$data['transaction_date'] = date('Y-m-d H:i:s');
		$data['journal_type'] = TypeJurnal::where('code', 'PJR')->first()->id;
		$data['currency_code'] = Currency::find($po->currency_id)->code;
		$data['exchange_rate'] = $po->exchange_rate;

		TrxJournal::create($data);

		$account_code = [
			"11161001",
			"11161002",
			"11161003",
		];

		$_data = [
			$component,
			$consumable,
			$raw_material
		];

		$total = 0;

		for($a = 0; $a < count($_data); $a++) {

			if($_data[$a]) {
				TrxJournalA::create([
					'voucher_no' => $data['voucher_no'],
					'account_code' => $account_code,
					'debit' => $_data[$a],
				]);

				$total += $_data[$a];
			}

		}

		TrxJournalA::create([
			'voucher_no' => $data['voucher_no'],
			'account_code' => "21111101",
			'credit' => $total,
		]);
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
			'Directoryxx\Finac\Model\TypeJurnal',
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
			'Directoryxx\Finac\Model\TrxJournalA',
			'voucher_no',
			'voucher_no'
		);
	}
}
