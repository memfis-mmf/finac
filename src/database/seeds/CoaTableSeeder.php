<?php

namespace Directoryxx\Finac\Database\Seeds;

use Illuminate\Database\Seeder;
use Directoryxx\Finac\Model\Coa;
use Illuminate\Support\Str;

class CoaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$data = [
			[
				'uuid' => Str::uuid()->toString(),
				'code' => '101.1.1.01',
				'name' => 'Cash on Hand',
				'description' => 'Cash on Hand',
				'type_id' => 203,
			],
			[
				'uuid' => Str::uuid()->toString(),
				'code' => '201.1.1.02',
				'name' => 'Engine',
				'description' => 'Engine',
				'type_id' => 204,
			],
			[
				'uuid' => Str::uuid()->toString(),
				'code' => '301.1.1.01',
				'name' => 'Repair & Maintenance',
				'description' => 'Repair & Maintenance',
				'type_id' => 205,
			],
			[
				'uuid' => Str::uuid()->toString(),
				'code' => '401.1.1.01',
				'name' => 'Authorized Capital',
				'description' => 'Authorized Capital',
				'type_id' => 206,
			],
			[
				'uuid' => Str::uuid()->toString(),
				'code' => '703.1.1.01',
				'name' => 'Maintenance & Repair Vehicles',
				'description' => 'Maintenance & Repair Vehicles',
				'type_id' => 207,
			],
		];

		Coa::insert($data);
    }
}
