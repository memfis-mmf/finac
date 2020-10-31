<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAtCoasAndAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dateTime('initiation_date')
                ->comment('ini berisi tanggal kapan data di approve (kolom ini hanya berlaku untuk data inject-an)')
                ->nullable();
        });

        Schema::table('coas', function (Blueprint $table) {
			$table->decimal('starting_balance', 18, 5);
            $table->dateTime('starting_balance_date')->nullable();
        });
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
