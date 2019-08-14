<?php

namespace Directoryxx\Finac\Model;

use Illuminate\Database\Eloquent\Model;
use Directoryxx\Finac\Traits\UuidKey;


class Coa extends Model
{

    use UuidKey;
    
    protected $fillable = [
        'id_branch',
        'code',
        'name',
        'type',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
