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
            $table->integer('approve');
            $table->integer('approve2')->default(0);
            $table->string('transactionnumber');
            $table->dateTime('transactiondate');
            $table->string('xstatus');
            $table->string('personal');
            $table->string('refno');
            $table->string('currency');
            $table->decimal('exchangerate',18,5);
            $table->string('accountcode');
            $table->decimal('totaltransaction',18,5);
            $table->text('description');
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
