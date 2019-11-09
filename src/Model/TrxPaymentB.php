<?php

namespace Directoryxx\Finac\Model;


use Directoryxx\Finac\Model\MemfisModel;
use Directoryxx\Finac\Model\Coa;
use Illuminate\Database\Eloquent\Model;

class TrxPaymentB extends MemfisModel
{
    protected $table = "trxpaymentb";

    protected $fillable = [
		'transaction_number',
		'code',
		'total',
		'description',
    ];

	public function coa()
	{
		return $this->belongsTo(Coa::class, 'code', 'code');
	}
}
