<?php

namespace Directoryxx\Finac\Model;

use Directoryxx\Finac\Model\MemfisModel;

class CashbookA extends MemfisModel
{
    protected $fillable = [
        'transactionnumber',
        'code',
        'name',
        'debit',
        'credit',
        'description'
    ];
}
