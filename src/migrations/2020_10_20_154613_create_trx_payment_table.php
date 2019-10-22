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
            $table->integer('id_branch');
            $table->integer('approve');
            $table->integer('closed');
            $table->string('transaction_number');
            $table->dateTime('transaction_date');
            $table->string('x_type');
            $table->integer('id_supplier');
            $table->string('currency');
            $table->decimal('exchange_rate');
            $table->decimal('discount_percent');
            $table->decimal('discount_value');
            $table->decimal('ppn_percent');
            $table->decimal('ppn_value');
            $table->decimal('grandtotal_foreign');
            $table->decimal('grandtotal');
            $table->string('account_code');
            $table->string('description');
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
