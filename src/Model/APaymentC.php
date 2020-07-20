<?php

namespace memfisfa\Finac\Model;

use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class APaymentC extends MemfisModel
{
    protected $table = "a_payment_c";

    protected $fillable = [
        'apa_id',
        'ap_id',
        'uuid',
        'transactionnumber',
        'id_payment',
        'code',
        'debit',
        'credit',
        'description',
    ];

    protected $appends = [
        'gap'
    ];

    public function getGapAttribute()
    {
        if ($this->credit != 0) {
            return $this->credit;
        } else {
            return $this->debit;
        }
    }

    public function ap()
    {
        return $this->belongsTo(
            APayment::class,
            'ap_id'
        );
    }

    public function apa()
    {
        return $this->belongsTo(APaymentA::class, 'apa_id');
    }

    public function coa()
    {
        return $this->belongsTo(Coa::class, 'code', 'code');
    }
}
