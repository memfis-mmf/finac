<?php

namespace memfisfa\Finac\Model;


use memfisfa\Finac\Model\MemfisModel;
use memfisfa\Finac\Model\Coa;
use Illuminate\Database\Eloquent\Model;

// ini model detail SI General
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
    
	public function si()
	{
		return $this->belongsTo(
			TrxPayment::class,
			'transaction_number',
			'transaction_number'
		);
	}
}
