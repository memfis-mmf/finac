<?php

namespace memfisfa\Finac\Model;

use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class AReceiveC extends MemfisModel
{
    protected $table = "a_receive_c";

	protected $fillable = [
	    'uuid',
	    'transactionnumber',
	    'id_invoice',
	    'code',
	    'difference',
	    'description',
	];

	public function ar()
	{
		return $this->belongsTo(
			AReceive::class,
			'transactionnumber',
			'transactionnumber'
		);
	}

	public function coa()
	{
		return $this->belongsTo(Coa::class, 'code', 'code');
	}
}
