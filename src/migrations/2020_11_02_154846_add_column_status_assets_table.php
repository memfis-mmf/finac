<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use memfisfa\Finac\Model\Asset;
use memfisfa\Finac\Model\Coa;

class AddColumnStatusAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->integer('status')
                ->default(1)
                ->comment('0=Closed, 1=Open, 2=Approved');
        });

        Asset::where('approve', false)
            ->update([
                'status' => 1
            ]);

        Asset::where('approve', true)
            ->update([
                'status' => 2
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
