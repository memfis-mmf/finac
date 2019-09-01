<?php

namespace Directoryxx\Finac\Model;

use Directoryxx\Finac\Model\MemfisModel;


class Coa extends MemfisModel
{


    protected $fillable = [
        'id_branch',
        'code',
        'name',
        'type_id',
        'description'
    ];

    


    
}
