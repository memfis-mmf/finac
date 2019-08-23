<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashbookCTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashbook_c', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('transactionnumber');
            $table->string('code');
            $table->string('name');
            $table->decimal('debit',18,5);
            $table->decimal('credit',18,5);
            $table->text('description')->nullable();
            $table->foreign('transactionnumber')->references('transactionnumber')->on('cashbooks');
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
        Schema::dropIfExists('cashbook_cs');
    }
}
