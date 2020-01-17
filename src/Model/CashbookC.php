<?php

namespace memfisfa\Finac\Model;

use memfisfa\Finac\Model\MemfisModel;


class CashbookC extends MemfisModel
{
    protected $table = "cashbook_c";
    protected $fillable = [
        'transactionnumber',
        'code',
        'name',
        'debit',
        'credit',
        'description',
        'createdby'
    ];
}
