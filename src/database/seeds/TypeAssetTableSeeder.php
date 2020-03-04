<?php

namespace memfisfa\Finac\Database\Seeds;


use Illuminate\Database\Seeder;
use memfisfa\Finac\Model\TypeAsset;


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
            'AccountCode' => '12111004',
            'usefullife' => '240'
        ]);

        TypeAsset::create([
            'code' => 'INVKAN',
            'name' => 'INVENTARIS KANTOR',
            'AccountCode' => '12111005',
            'usefullife' => '48'
        ]);

        TypeAsset::create([
            'code' => 'KND',
            'name' => 'KENDARAAN',
            'AccountCode' => '12111006',
            'usefullife' => '120'
        ]);

        TypeAsset::create([
            'code' => 'LISTRIK',
            'name' => 'LISTRIK',
            'AccountCode' => '12111001',
            'usefullife' => '60'
        ]);

        TypeAsset::create([
            'code' => 'MSN',
            'name' => 'MESIN',
            'AccountCode' => '12111009',
            'usefullife' => '120'
        ]);

        TypeAsset::create([
            'code' => 'PAB',
            'name' => 'PERALATAN PABRIK',
            'AccountCode' => '12111002',
            'usefullife' => '48'
        ]);
    }
}
