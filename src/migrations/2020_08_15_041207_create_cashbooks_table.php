<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashbooks', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('approve')->nullable();
            $table->integer('approve2')->default(0);
            $table->string('transactionnumber');
            $table->dateTime('transactiondate')->nullable();
            $table->string('xstatus')->nullable();
            $table->string('personal')->nullable();
            $table->string('refno')->nullable();
            $table->string('currency')->nullable();
            $table->decimal('exchangerate',18,5)->nullable();
            $table->string('accountcode')->nullable();
            $table->decimal('totaltransaction',18,5)->nullable();
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
        Schema::dropIfExists('cashbooks');
    }
}
