<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeCashbookRefNullableCashbookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (Schema::hascolumn('cashbooks', 'cashbook_ref')) {
			Schema::table('cashbooks', function (Blueprint $table) {
		        $table->dropColumn('cashbook_ref');
			});
		}

		if (!Schema::hascolumn('cashbooks', 'cashbook_ref')) {
			Schema::table('cashbooks', function (Blueprint $table) {
		        $table->text('cashbook_ref')->nullable();
			});
		}
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
