<?php

namespace memfisfa\Finac\Model;

use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class APaymentC extends MemfisModel
{
    protected $table = "a_payment_c";

	protected $fillable = [
	    'uuid',
	    'transactionnumber',
	    'id_payment',
	    'code',
	    'difference',
	    'description',
	];
	
	public function ap()
	{
		return $this->belongsTo(
			APayment::class,
			'transactionnumber',
			'transactionnumber'
		);
	}

	public function coa()
	{
		return $this->belongsTo(Coa::class, 'code', 'code');
	}
}
