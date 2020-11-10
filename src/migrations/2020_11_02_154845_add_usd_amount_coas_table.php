<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use memfisfa\Finac\Model\Coa;

class AddUsdAmountCoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coas', function (Blueprint $table) {
            $table->double('usd_amount', 18, 5)
                ->after('level')
                ->nullable();
        });

        Coa::where('code', '11111002')->update([
            'usd_amount' => 6987
        ]);

        Coa::where('code', '11112104')->update([
            'usd_amount' => 32643.27
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
