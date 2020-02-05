<?php

namespace memfisfa\Finac\Model;

use memfisfa\Finac\Model\MemfisModel;

class CashbookA extends MemfisModel
{
    protected $table = "cashbook_a";

    protected $fillable = [
        'transactionnumber',
        'code',
        'name',
        'debit',
        'credit',
        'description'
    ];

    public function cashbook()
    {
        return $this->belongsTo(
			Cashbook::class, 'transactionnumber', 'transactionnumber'
		);
    }


}
