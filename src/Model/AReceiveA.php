<?php

namespace memfisfa\Finac\Model;

use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Currency;
use Modules\Workshop\Entities\InvoiceWorkshop\InvoiceWorkshop;

class AReceiveA extends MemfisModel
{
    protected $table = "a_receive_a";

    protected $fillable = [
        'transactionnumber',
        'id_invoice',
        'ar_id',
        'code',
        'currency',
        'exchangerate',
        'debit',
        'debit_idr',
        'credit',
        'credit_idr',
        'description',
    ];

    public function ar()
    {
        return $this->belongsTo(
            AReceive::class,
            'ar_id'
        );
    }

    public function arc()
    {
        return $this->hasOne(AReceiveC::class, 'ara_id');
    }

    public function invoice()
    {
        return $this->belongsTo(
            Invoice::class,
            'id_invoice'
        );
    }

    public function invoice_workshop()
    {
        return $this->belongsTo(
            InvoiceWorkshop::class,
            'id_invoice'
        );
    }

    public function coa()
    {
        return $this->belongsTo(Coa::class, 'code', 'code');
    }

    public function currencies()
    {
        return $this->belongsTo(Currency::class, 'currency', 'code');
    }
}
