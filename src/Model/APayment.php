<?php

namespace Directoryxx\Finac\Model;

use Directoryxx\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Currency;

class APayment extends MemfisModel
{
    protected $table = "a_payments";

    protected $fillable = [
		'approve',
		'transactionnumber',
		'transactiondate',
		'id_supplier',
		'accountcode',
		'refno',
		'currency',
		'exchangerate',
		'totaltransaction',
		'description',
    ];

	protected $appends = ['date'];

	public function getDateAttribute()
	{
		return date('Y-m-d', strtotime($this->transactiondate));
	}

	static public function generateCode($code)
	{
		$data = APayment::orderBy('id', 'desc')
			->where('transactionnumber', 'like', $code.'%');

		if (!$data->count()) {

			if ($data->withTrashed()->count()) {
				$order = $data->withTrashed()->count() + 1;
			}else{
				$order = 1;
			}

		}else{
			$order = $data->withTrashed()->count() + 1;
		}

		$number = str_pad($order, 5, '0', STR_PAD_LEFT);

		$code = $code."-".date('Y/m')."/".$number;

		return $code;
	}

	public function vendor()
	{
		return $this->belongsTo(Vendor::class, 'id_supplier');
	}

	public function coa()
	{
		return $this->belongsTo(Coa::class, 'accountcode', 'code');
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
