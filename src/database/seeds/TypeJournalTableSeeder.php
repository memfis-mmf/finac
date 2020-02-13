<?php

namespace memfisfa\Finac\Database\Seeds;

use Illuminate\Database\Seeder;
use memfisfa\Finac\Model\TypeJurnal;

class TypeJournalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeJurnal::create([
            'code' => 'PRJ',
            'name' => 'PROJECT JOURNAL',
            'active' => '1',
        ]);

    }
}
