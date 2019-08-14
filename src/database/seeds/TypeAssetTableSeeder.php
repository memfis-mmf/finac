<?php

namespace Directoryxx\Finac\Database\Seeds;


use Illuminate\Database\Seeder;
use Directoryxx\Finac\Model\TypeAsset;


class TypeAssetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeAsset::create([
            'code' => 'BGN',
            'name' => 'BANGUNAN',
            'AccountCode' => '205.1.2.01',
            'usefullife' => '240'
        ]);

        TypeAsset::create([
            'code' => 'INVKAN',
            'name' => 'INVENTARIS KANTOR',
            'AccountCode' => '205.1.7.01',
            'usefullife' => '48'
        ]);

        TypeAsset::create([
            'code' => 'KND',
            'name' => 'KENDARAAN',
            'AccountCode' => '205.1.3.01',
            'usefullife' => '120'
        ]);

        TypeAsset::create([
            'code' => 'LISTRIK',
            'name' => 'LISTRIK',
            'AccountCode' => '205.1.6.01',
            'usefullife' => '60'
        ]);

        TypeAsset::create([
            'code' => 'MSN',
            'name' => 'MESIN',
            'AccountCode' => '205.1.4.01',
            'usefullife' => '120'
        ]);

        TypeAsset::create([
            'code' => 'PAB',
            'name' => 'PERALATAN PABRIK',
            'AccountCode' => '205.1.5.01',
            'usefullife' => '48'
        ]);
    }
}
