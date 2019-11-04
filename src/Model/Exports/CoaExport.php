<?php

namespace Directoryxx\Finac\Model\Exports;

use Directoryxx\Finac\Model\Coa;
use Maatwebsite\Excel\Concerns\FromArray;

class CoaExport implements FromArray
{
    public function array(): array
    {
		$coa = Coa::select([
			'code',
			'name',
			'description',
			'created_at',
		])->get();

		$header = [ 0 =>
			[
				'Account Code',
				'Account Name',
				'Description',
				'Date Created',
			]
		];

		$data = array_merge($header, json_decode($coa));

		return $data;
    }
}

