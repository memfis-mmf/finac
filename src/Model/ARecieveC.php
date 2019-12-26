<?php

namespace App;

use Directoryxx\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class ARecieveC extends MemfisModel
{
	protected $fillable = [
	    'uuid',
	    'transactionnumber',
	    'id_invoice',
	    'code',
	    'difference',
	    'description',
	];
}
