<?php

namespace Directoryxx\Finac\Model;

use Directoryxx\Finac\Model\MemfisModel;


class Coa extends MemfisModel
{


    protected $fillable = [
        'code',
        'name',
        'type_id',
        'description'
    ];

	public function type()
	{
		return $this->belongsTo(
			'App\Models\Type',
			'type_id'
		);
	}
	
}
