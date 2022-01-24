<?php

namespace memfisfa\Finac\Model;

use App\Models\Project;
use memfisfa\Finac\Model\MemfisModel;

class CashbookA extends MemfisModel
{
    protected $table = "cashbook_a";

    protected $fillable = [
        'transactionnumber',
        'code',
        'name',
        'debit',
        'credit',
        'description',
        'id_project',
        'quotation_workshop_id',
    ],
    $appends = [
        'second_debit',
        'second_credit',
    ];

    public function cashbook()
    {
        return $this->belongsTo(
			Cashbook::class, 'transactionnumber', 'transactionnumber'
		);
    }

    public function coa()
    {
        return $this->belongsTo(
			Coa::class, 'code', 'code'
		);
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project');
    }

    public function quotation_workshop()
    {
        return $this->belongsTo(QuotationWorkshop::class, 'quotation_workshop_id', 'id');
    }

    public function getSecondDebitAttribute()
    {
        if ($this->cashbook->second_currencies) {
            if ($this->cashbook->currencies->code == 'idr') {
                return $this->debit / $this->cashbook->exchangerate;
            }

            return $this->debit * $this->cashbook->exchangerate;
        } else {
            return 0;
        }
    }

    public function getSecondCreditAttribute()
    {
        if ($this->cashbook->second_currencies) {
            if ($this->cashbook->currencies->code == 'idr') {
                return $this->credit / $this->cashbook->exchangerate;
            }

            return $this->credit * $this->cashbook->exchangerate;
        } else {
            return 0;
        }
    }

}
