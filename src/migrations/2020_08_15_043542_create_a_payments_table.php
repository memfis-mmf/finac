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
            $table->integer('approve')->nullable();
            $table->string('transactionnumber')->nullable();
            $table->dateTime('transactiondate')->nullable();
            $table->integer('id_supplier')->nullable();
            $table->string('accountcode')->nullable();
            $table->string('refno')->nullable();
            $table->string('currency')->nullable();
            $table->decimal('exchangerate',18,5)->default(1);
            $table->decimal('totaltransaction',18,5)->default(1);
            $table->text('description')->nullable();
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
