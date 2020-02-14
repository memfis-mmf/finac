<?php

namespace memfisfa\Finac\Database\Seeds;

use memfisfa\Finac\Database\Seeds\TypeAssetTableSeeder;
use memfisfa\Finac\Database\Seeds\TypeJurnalTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
		$this->call(TypeAssetTableSeeder::class);
		$this->call(TypeJurnalTableSeeder::class);
		$this->call(TypeJournalTableSeeder::class);
		$this->call(CoaTableSeeder::class);
    }
}
