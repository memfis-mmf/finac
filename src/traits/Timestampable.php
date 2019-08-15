<?php
namespace Directoryxx\Finac\Traits;

use App\User;

trait Timestampable
{
    /***************************************** ACCESSOR ******************************************/
    public function getCreatedAtFormattedAttribute()
    {
        echo $this->created_at->diffForHumans() .
                '<br>' .
                '<small class="text-muted">' .
                    $this->created_at->format('d-M-Y') .
                '</small>';
    }
    public function getUpdatedAtFormattedAttribute()
    {
        echo $this->updated_at->diffForHumans() .
                '<br>' .
                '<small class="text-muted">' .
                    $this->updated_at->format('d-M-Y') .
                '</small>';
    }
}