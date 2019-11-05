<?php

namespace Directoryxx\Finac\Database\Seeds;


use Illuminate\Database\Seeder;
use App\Models\Vendor;
use Illuminate\Support\Str;
use Faker\Factory as Faker;


class VendorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$faker = Faker::create('id_ID');

		$data = [];

		for ($i = 0; $i < 20; $i++) {
			$data[] = [
				'uuid' => Str::uuid()->toString(),
				'code' => '',
				'name' => $faker->unique()->company,
				'created_at' => date('Y-m-d H:i:s'),
			];
		}

		Vendor::insert($data);
    }
}
