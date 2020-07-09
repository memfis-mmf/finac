<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDebitCreditAReceiveCTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('a_receive_c', function (Blueprint $table) {
        $table->decimal('credit',18,5)->default(0)->after('difference');
        $table->renameColumn('difference', 'debit');
        $table->bigInteger('ara_id')->after('id');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('a_receive_a', function (Blueprint $table) {
        $table->dropColumn('credit_idr');
        $table->dropColumn('debit_idr');
      });

      Schema::table('a_payment_a', function (Blueprint $table) {
        $table->dropColumn('credit_idr');
        $table->dropColumn('debit_idr');
      });
    }
}
