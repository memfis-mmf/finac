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
            $table->integer('id_branch')->nullable();
            $table->integer('approve')->default(0);
            $table->integer('approve2')->default(0);
            $table->string('transactionnumber')->unique();
            $table->dateTime('transactiondate')->nullable();
            $table->string('xstatus')->nullable();
            $table->string('personal')->nullable();
            $table->string('refno')->nullable();
            $table->string('currency')->nullable();
            $table->decimal('exchangerate',18,5)->nullable();
            $table->string('accountcode')->nullable();
            $table->decimal('totaltransaction',18,5)->nullable();
            $table->string('createdby')->nullable();
            $table->dateTime('updateddate')->nullable();
            $table->string('deleteby')->nullable();
            $table->string('updatedby')->nullable();
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
        Schema::dropIfExists('cashbooks');
    }
}
