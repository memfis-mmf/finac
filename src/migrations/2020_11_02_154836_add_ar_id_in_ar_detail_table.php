<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArIdInArDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('a_receive_a', function (Blueprint $table) {
          $table->bigInteger('ar_id')->after('id');
      });
      Schema::table('a_receive_b', function (Blueprint $table) {
          $table->bigInteger('ar_id')->after('id');
      });
      Schema::table('a_receive_c', function (Blueprint $table) {
          $table->bigInteger('ar_id')->after('id');
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
