<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCreditIdrAndDebitIdrArApDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('a_receive_a', function (Blueprint $table) {
        $table->decimal('credit_idr',18,5)->after('credit');
        $table->decimal('debit_idr',18,5)->after('credit');
      });

      Schema::table('a_payment_a', function (Blueprint $table) {
        $table->decimal('credit_idr',18,5)->after('credit');
        $table->decimal('debit_idr',18,5)->after('credit');
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
