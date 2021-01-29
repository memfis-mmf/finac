<?php

namespace memfisfa\Finac\Model;

use App\Models\Project;
use memfisfa\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class AReceiveB extends MemfisModel
{
    protected $table = "a_receive_b";

	protected $fillable = [
	    'uuid',
		'ar_id',
	    'transactionnumber',
	    'code',
	    'name',
	    'debit',
	    'credit',
	    'description',
	    'id_project',
	];

	public function ar()
	{
		return $this->belongsTo(
			AReceive::class,
			'ar_id'
		);
	}

	public function coa()
	{
		return $this->belongsTo(Coa::class, 'code', 'code');
    }
    
    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project');
    }
}
