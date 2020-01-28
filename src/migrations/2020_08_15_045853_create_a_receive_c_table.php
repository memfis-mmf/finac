<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAReceiveCTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_recieve_c', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('transactionnumber');
            $table->integer('id_invoice');
            $table->string('code');
            $table->decimal('difference',18,5);
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
        Schema::dropIfExists('a_recieve_cs');
    }
}
