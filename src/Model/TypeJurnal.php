<?php

namespace memfisfa\Finac\Model;

use Illuminate\Database\Eloquent\Model;
use memfisfa\Finac\Model\MemfisModel;


class TypeJurnal extends MemfisModel
{
   
    protected $fillable = [
        'code',
        'name',
        'active',
    ];
    
}
