<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('approve');
            $table->string('transactionnumber');
            $table->dateTime('transactiondate');
            $table->integer('id_supplier');
            $table->string('accountcode');
            $table->string('refno');
            $table->string('currency');
            $table->decimal('exchangerate',18,5);
            $table->decimal('totaltransaction',18,5);
            $table->text('description');
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
        Schema::dropIfExists('a_payments');
    }
}
