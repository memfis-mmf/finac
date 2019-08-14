<?php

namespace Directoryxx\Finac\Model;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
