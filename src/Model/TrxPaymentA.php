<?php

namespace memfisfa\Finac\Model;


use memfisfa\Finac\Model\MemfisModel;
use memfisfa\Finac\Model\TrxPayment;
use App\Models\GoodsReceived;
use Illuminate\Database\Eloquent\Model;

class TrxPaymentA extends MemfisModel
{
    protected $table = "trxpaymenta";

    protected $fillable = [
		'transaction_number',
		'transaction_status',
		'id_grn',
		'total',
		'total_idr',
        'tax_percent',
		'description',
    ],
    $appends = [
        'tax_amount',
        'tax_amount_idr',
        'total_after_tax'
    ];

    public function getTaxAmountAttribute()
    {
        $result = ($this->total * ($this->tax_percent / 100));

        return $result;
    }

    public function getTaxAmountIdrAttribute()
    {
        $result = ($this->total_idr * ($this->tax_percent / 100));

        return $result;
    }

    public function getTotalAfterTaxAttribute()
    {
        $result = $this->total + $this->getTaxAmountAttribute();

        return $result;
    }

	public function grn()
	{
		return $this->belongsTo(GoodsReceived::class, 'id_grn');
	}

	public function si()
	{
		return $this->belongsTo(
			TrxPayment::class,
			'transaction_number',
			'transaction_number'
		);
	}
}
