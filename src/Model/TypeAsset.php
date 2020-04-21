<?php

namespace memfisfa\Finac\Model;

use Illuminate\Database\Eloquent\Model;
use memfisfa\Finac\Model\MemfisModel;
use App\User;

class TypeAsset extends MemfisModel
{
    protected $fillable = [
		"code",
		"name",
		"accountcode",
		"usefullife",
	];

	protected $appends = [
		'created_by',
	];

	public function getCreatedByAttribute()
	{
		$audit = $this->audits->first();
		$conducted_by = @User::find($audit->user_id)->name;

		$result = '-';

		if ($conducted_by) {
			$result = $conducted_by.' '.$this->created_at;
		}

		return $result;
	}

	public function coa()
	{
		return $this->belongsTo(
			Coa::class,
			'accountcode',
			'code'
		);
	}
}
