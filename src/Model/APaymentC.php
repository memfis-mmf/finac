<?php

namespace App;

use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class APaymentC extends MemfisModel
{
	protected $fillable = [
	    'uuid',
	    'transactionnumber',
	    'id_payment',
	    'code',
	    'difference',
	    'description',
	];
}
