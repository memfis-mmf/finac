<?php

namespace memfisfa\Finac\Model;

use App\Models\Approval;
use App\Models\Currency;
use App\Models\Quotation;
use App\Models\Customer;
use App\Models\Bank;
use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class Invoice extends MemfisModel
{
    protected $fillable = [
        'id_branch',
        'closed',
        'transactionnumber',
        'transactiondate',
        'id_customer',
        'id_quotation',
        'id_bank',
        'currency',
        'exchangerate',
        'discountpercent',
        'schedule_payment',
        'discountvalue',
        'ppnpercent',
        'schedule_payment',
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
        return $this->hasOne(Currency::class, 'id', 'currency');
    }

    public function coas()
    {
        return $this->hasOne(Coa::class, 'id', 'accountcode');
    }

    public function quotations()
    {
        return $this->hasOne(Quotation::class, 'id', 'id_quotation');
    }

    public function totalprofit()
    {
        return $this->hasMany(Invoicetotalprofit::class, 'invoice_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'id_bank');
    }
}
