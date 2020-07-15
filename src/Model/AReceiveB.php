<?php

namespace memfisfa\Finac\Model;

use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class AReceiveB extends MemfisModel
{
    protected $table = "a_receive_b";

	protected $fillable = [
	    'uuid',
		'ar_id',
	    'transactionnumber',
	    'code',
	    'name',
	    'debit',
	    'credit',
	    'description',
	];

	public function ar()
	{
		return $this->belongsTo(
			AReceive::class,
			'ar_id'
		);
	}

	public function coa()
	{
		return $this->belongsTo(Coa::class, 'code', 'code');
	}
}
