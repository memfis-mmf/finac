<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateARecievesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_recieves', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('id_branch')->nullable();
            $table->integer('approve');
            $table->string('transactionnumber');
            $table->dateTime('transactiondate');
            $table->integer('id_customer');
            $table->string('accountcode');
            $table->string('refno')->nullable();
            $table->string('currency');
            $table->decimal('exchangerate',18,5);
            $table->decimal('totaltransaction',18,5)->nullable();
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
        Schema::dropIfExists('a_recieves');
    }
}
