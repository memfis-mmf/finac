<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trxpayments', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->integer('approve')->default(0);
            $table->integer('closed');
            $table->string('transaction_number');
            $table->dateTime('transaction_date');
            $table->string('x_type');
            $table->integer('id_supplier');
            $table->string('currency')->nullable();
            $table->decimal('exchange_rate')->nullable();
            $table->decimal('discount_percent')->nullable();
            $table->decimal('discount_value')->nullable();
            $table->decimal('ppn_percent')->nullable();
            $table->decimal('ppn_value')->nullable();
            $table->decimal('grandtotal_foreign')->nullable();
            $table->decimal('grandtotal')->nullable();
            $table->string('account_code')->nullable();
            $table->string('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trxpayment');
    }
}
