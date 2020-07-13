<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDebitIdrCreditIdrAReceiveBTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('a_receive_b', function (Blueprint $table) {
        $table->decimal('credit_idr',18,5)->default(0)->after('credit');
        $table->decimal('debit_idr',18,5)->default(0)->after('credit');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('a_receive_b', function (Blueprint $table) {
        $table->dropColumn('credit_idr');
        $table->dropColumn('debit_idr');
      });

    }
}
