<?php

namespace memfisfa\Finac\Model;

use memfisfa\Finac\Model\MemfisModel;

class CashbookB extends MemfisModel
{
    protected $table = "cashbook_b";
    protected $fillable = [
        'transactionnumber',
        'code',
        'name',
        'currency',
        'exchangerate',
        'debit',
        'credit',
        'description',
        'createdby'
    ];
}
