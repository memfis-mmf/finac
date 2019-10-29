<?php

namespace Directoryxx\Finac\Model;


use Directoryxx\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;
use Directoryxx\Finac\Model\JurnalA;
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

	static public function generateCode()
	{
		$journal = Journal::orderBy('id', 'desc');

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

		$code = "JADJ-".date('Y/m')."/".$number;
		
		return $code;
	}

	static public function insertFromGRN(
		$component, 
		$consumable, 
		$raw_material, 
		$id_grn
	)
	{
		$po = GRN::find($id_grn)->purchase_order;

		$data['voucher_no'] = $this->generateCode();
		$data['transaction_date'] = date('Y-m-d H:i:s');
		$data['journal_type'] = TypeJurnal::where('code', 'PJR')->first()->id;
		$data['currency_code'] = Currency::find($po->currency_id)->code;
		$data['exchange_rate'] = $po->exchange_rate;
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
}
