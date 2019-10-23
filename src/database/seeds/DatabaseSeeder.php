<?php

namespace Directoryxx\Finac\Database\Seeds;

use Directoryxx\Finac\Database\Seeds\TypeAssetTableSeeder;
use Directoryxx\Finac\Database\Seeds\TypeJurnalTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(TypeAssetTableSeeder::class);
        $this->call(TypeJurnalTableSeeder::class);
        $this->call(CoaTableSeeder::class);
    }
}
