<?php

namespace Directoryxx\Finac\Model;

use App\Models\Approval;
use Directoryxx\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class ARecieve extends MemfisModel
{
    protected $fillable = [
        'id_branch',
        'approve',
        'transactionnumber',
        'transactiondate',
        'id_customer',
        'currency',
        'exchangerate',
        'refno',
        'accountcode',
        'description'
    ];

    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
    }
}
