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
        'id_project'
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

}
