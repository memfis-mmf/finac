<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransJurATable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_jur_a', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('branchno');
            $table->string('voucherno');
            $table->dateTime('transactiondate');
            $table->string('refno');
            $table->string('currencycode');
            $table->decimal('exchangerate',18,4);
            $table->string('journaltype');
            $table->string('journalvouchertype');
            $table->integer('postingstatus');
            $table->string('parentvoucherno');
            $table->string('automaticjournaltype');
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
        Schema::dropIfExists('trans_jur_as');
    }
}
