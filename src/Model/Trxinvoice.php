<?php

namespace Directoryxx\Finac\Model;


use Directoryxx\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class Trxinvoice extends MemfisModel
{
    protected $table = "trxinvoice";

    protected $fillable = [
        'id_branch',
        'closed',
        'transactionnumber',
        'transactiondate',
        'id_customer',
        'id_quotation',
        'id_bank',
        'schedule_payment',
        'currency',
        'exchangerate',
        'discountpercent',
        'discountvalue',
        'ppnpercent',
        'attention',
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

    
    public function currencies()
    {
        return $this->hasOne(Currency::class,'id','currency');
    }

    public function coas(){
        return $this->hasOne(Coa::class,'id','accountcode');
    }

    public function quotations(){
        return $this->hasOne(Quotation::class,'id','id_quotation');
    }

    /*
    public function totalprofit(){
        return $this->hasMany(Trxinvoice::class,'id','invoice_id');
    }
    */
}
