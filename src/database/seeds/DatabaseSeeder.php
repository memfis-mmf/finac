<?php

namespace Directoryxx\Finac\Database\Seeds;

use Directoryxx\Finac\Database\Seeds\TypeAssetTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(TypeAssetTableSeeder::class);
    }
}