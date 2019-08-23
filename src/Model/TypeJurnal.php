<?php

namespace Directoryxx\Finac\Model;

use Illuminate\Database\Eloquent\Model;
use Directoryxx\Finac\Model\MemfisModel;


class TypeJurnal extends MemfisModel
{
   
    protected $fillable = [
        'code',
        'name',
        'active',
    ];
    
}
