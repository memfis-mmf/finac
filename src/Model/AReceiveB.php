<?php

namespace App;

use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class AReceiveB extends MemfisModel
{
    protected $table = "a_recieve_b";

	protected $fillable = [
	    'uuid',
	    'transactionnumber',
	    'code',
	    'name',
	    'debit',
	    'credit',
	    'description',
	];
}
