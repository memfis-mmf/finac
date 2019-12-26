<?php

namespace App;

use Directoryxx\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class ARecieveA extends MemfisModel
{
    protected $table = "a_recieve_a";

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

	public function ar()
	{
		return $this->belongsTo(
			ARecieve::class,
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
