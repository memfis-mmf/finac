<?php

namespace Directoryxx\Finac\Model;


use Directoryxx\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class TrxBS extends MemfisModel
{
    protected $table = "trx_BS";

    protected $fillable = [
		"approve",
		"closed",
		"transaction_number",
		"transaction_date",
		"id_employee",
		"date_return",
		"value",
		"coac",
		"coad",
		"description",
    ];

	static public function generateCode($code = "BSTR")
	{
		$bs = TrxBS::orderBy('id', 'desc')
			->where('transaction_number', 'like', $code.'%');

		if (!$bs->count()) {

			if ($bs->withTrashed()->count()) {
				$order = $bs->withTrashed()->count() + 1;
			}else{
				$order = 1;
			}

		}else{
			$order = $bs->withTrashed()->count() + 1;
		}

		$number = str_pad($order, 5, '0', STR_PAD_LEFT);

		$code = $code."-".date('Y/m')."/".$number;

		return $code;
	}

}
