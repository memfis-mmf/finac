<?php

namespace Directoryxx\Finac\Model;


use Directoryxx\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;
use Directoryxx\Finac\Model\TrxJournalA;
use Directoryxx\Finac\Model\TypeJurnal;
use App\Models\GoodsReceived as GRN;
use App\Models\Currency;

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

	protected $appends = ['exchange_rate_fix'];

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
			"105.1.1.01",
			"105.1.1.02",
			"105.1.1.03",
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
			'account_code' => "301.1.1.01",
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
