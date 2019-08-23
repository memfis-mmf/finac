<?php

namespace Directoryxx\Finac\Model;

use Illuminate\Database\Eloquent\Model;
use Directoryxx\Finac\Model\MemfisModel;


class Asset extends MemfisModel
{
   
    protected $fillable = [
        'code',
        'name',
        'active',
    ];

}
