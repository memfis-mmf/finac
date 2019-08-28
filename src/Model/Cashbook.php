<?php

namespace Directoryxx\Finac\Model;


use Directoryxx\Finac\Model\MemfisModel;
use App\Models\Approval;
use Illuminate\Support\Facades\Auth;

class Cashbook extends MemfisModel
{
    protected $fillable = [
        'approve',
        'approve2',
        'transactionnumber',
        'transactiondate',
        'xstatus',
        'personal',
        'refno',
        'currency',
        'exchangerate',
        'accountcode',
        'totaltransaction',
        'description',
        'createdby',
    ];

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
    }
}
