<?php

namespace memfisfa\Finac\Model;

use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class APaymentB extends MemfisModel
{
    protected $table = "a_payment_b";

	protected $fillable = [
	    'uuid',
	    'ap_id',
	    'transactionnumber',
	    'code',
	    'name',
	    'debit',
	    'credit',
	    'description',
	];

	public function ap()
	{
		return $this->belongsTo(
			APayment::class,
			'ap_id'
		);
	}

	public function coa()
	{
		return $this->belongsTo(Coa::class, 'code', 'code');
	}
}
