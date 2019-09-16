<?php

namespace Directoryxx\Finac\Model;

use App\Models\Approval;
use Directoryxx\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;


class Invoice extends MemfisModel
{
    protected $fillable = [
        'id_branch',
        'closed',
        'transactionnumber',
        'transactiondate',
        'id_customer',
        'currency',
        'exchangerate',
        'discountpercent',
        'discountvalue',
        'ppnpercent',
        'ppnvalue',
        'grandtotalforeign',
        'grandtotal',
        'accountcode',
        'description'
    ];

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
    }
}
