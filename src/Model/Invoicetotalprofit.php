<?php

namespace memfisfa\Finac\Model;

use App\Models\Approval;

use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;


class Invoicetotalprofit extends MemfisModel
{
    protected $table = "invoicetotalprofit";

    protected $fillable = [
        'invoice_id',
        'accountcode',
        'amount',
        'type',
    ];

    public function coas(){
        return $this->hasOne(Coa::class,'id','accountcode');
    }

}
