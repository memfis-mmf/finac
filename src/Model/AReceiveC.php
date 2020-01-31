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
}
