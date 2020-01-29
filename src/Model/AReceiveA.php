<?php

namespace memfisfa\Finac\Model;

use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class AReceiveA extends MemfisModel
{
    protected $table = "a_receive_a";

    protected $fillable = [
		'transactionnumber',
		'id_invoice',
		'code',
		'currency',
		'exchangerate',
		'debit',
		'credit',
		'description',
    ];

	public function ap()
	{
		return $this->belongsTo(
			AReceive::class,
			'transactionnumber',
			'transactionnumber'
		);
	}

	public function invoice()
	{
		return $this->belongsTo(
			Invoice::class,
			'id_invoice'
		);
	}

	public function coa()
	{
		return $this->belongsTo(Coa::class, 'code', 'code');
	}
}
