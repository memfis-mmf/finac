<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransJurBTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trans_jur_b', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('branchcode');
            $table->string('voucherno');
            $table->string('description');
            $table->string('accountcode');
            $table->decimal('debit',18,3);
            $table->decimal('credit',18,3);
            $table->decimal('subareacode',18,3);
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
        Schema::dropIfExists('trans_jur_bs');
    }
}
