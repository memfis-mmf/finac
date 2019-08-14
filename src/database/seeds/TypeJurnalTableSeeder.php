<?php

namespace Directoryxx\Finac\Database\Seeds;

use Illuminate\Database\Seeder;
use Directoryxx\Finac\Model\TypeJurnal;

class TypeJurnalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeJurnal::create([
            'code' => 'BPJ',
            'name' => 'BANK PAYMENT JOURNAL',
            'active' => '1',
        ]);

        TypeJurnal::create([
            'code' => 'BRJ',
            'name' => 'BANK RECEIVE JOURNAL',
            'active' => '1',
        ]);

        TypeJurnal::create([
            'code' => 'CPJ',
            'name' => 'CASH PAYMENT JOURNAL',
            'active' => '1',
        ]);

        TypeJurnal::create([
            'code' => 'CRJ',
            'name' => 'CASH RECEIVE JOURNAL',
            'active' => '1',
        ]);

        TypeJurnal::create([
            'code' => 'GJV',
            'name' => 'GENERAL JOURNAL',
            'active' => '1',
        ]);

        TypeJurnal::create([
            'code' => 'PJR',
            'name' => 'PURCHASE JOURNAL',
            'active' => '1',
        ]);

        TypeJurnal::create([
            'code' => 'SJT',
            'name' => 'SALES JOURNAL',
            'active' => '1',
        ]);






    }
}
