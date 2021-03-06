<?php

namespace memfisfa\Finac\Model;

use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Currency;
use App\Models\GoodsReceived;

class APaymentA extends MemfisModel
{
    protected $table = "a_payment_a";

    protected $fillable = [
		'transactionnumber',
		'id_payment',
        'ap_id',
		'code',
		'type',
		'currency',
		'exchangerate',
        'debit',
        'debit_idr',
        'credit',
        'credit_idr',
		'description',
    ];

	public function ap()
	{
		return $this->belongsTo(
			APayment::class,
			'ap_id'
		);
    }
    
    public function apc()
    {
        return $this->hasOne(APaymentC::class, 'apa_id');
    }

	public function si()
	{
        return $this->belongsTo(
            TrxPayment::class,
            'id_payment'
        );
    }

	public function grn()
	{
        return $this->belongsTo(
            GoodsReceived::class,
            'id_payment'
        );
    }

    public function getSI()
    {
        $si = null;
        if (strtolower($this->type) == 'grn') {
            $si_detail = TrxPaymentA::where('id_grn', $this->id_payment)->first();
            $si = $si_detail->si;
        } else {
            $si = TrxPayment::find($this->id_payment);
        }

        return $si;
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
