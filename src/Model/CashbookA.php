<?php

namespace Directoryxx\Finac\Model;

use Directoryxx\Finac\Model\MemfisModel;

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

    public function cashbooktest()
    {
        return $this->hasOne('Directoryxx\Finac\Model\Cashbook');
    }


}
