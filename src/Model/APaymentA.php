<?php

namespace Directoryxx\Finac\Model;

use Directoryxx\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class APaymentA extends MemfisModel
{
    protected $table = "a_payments";

    protected $fillable = [
		'transactionnumber',
		'id_payment',
		'code',
		'currency',
		'exchangerate',
		'debit',
		'credit',
		'description',
    ];
}

