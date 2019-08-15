<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateARecieveBTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_recieve_b', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('transactionnumber');
            $table->string('code');
            $table->string('name');
            $table->decimal('debit',18,5);
            $table->decimal('credit',18,5);
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
        Schema::dropIfExists('a_recieve_bs');
    }
}
