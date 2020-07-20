<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApIdInApDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('a_payment_a', function (Blueprint $table) {
            $table->bigInteger('ap_id')->after('id');
        });
        Schema::table('a_payment_b', function (Blueprint $table) {
            $table->bigInteger('ap_id')->after('id');
            $table->decimal('credit_idr', 18, 5)->default(0)->after('credit');
            $table->decimal('debit_idr', 18, 5)->default(0)->after('credit');
        });
        Schema::table('a_payment_c', function (Blueprint $table) {
            $table->bigInteger('apa_id')->after('id');
            $table->bigInteger('ap_id')->after('id');
            $table->decimal('credit',18,5)->default(0)->after('difference');
            $table->renameColumn('difference', 'debit');
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
