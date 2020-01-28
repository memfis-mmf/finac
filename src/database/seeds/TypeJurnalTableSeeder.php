<?php

namespace memfisfa\Finac\Database\Seeds;

use Illuminate\Database\Seeder;
use memfisfa\Finac\Model\TypeJurnal;

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

        TypeJurnal::create([
            'code' => 'ADJ',
            'name' => 'JOURNAL ADJUSTMENT',
            'active' => '1',
        ]);

        TypeJurnal::create([
            'code' => 'SRJ',
            'name' => 'INVOICE JOURNAL',
            'active' => '1',
        ]);

    }
}
