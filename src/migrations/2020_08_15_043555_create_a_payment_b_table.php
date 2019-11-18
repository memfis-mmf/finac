<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAPaymentBTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_payment_b', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('transactionnumber')->nullable();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->decimal('debit',18,5)->default(0);
            $table->decimal('credit',18,5)->default(0);
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
        Schema::dropIfExists('a_payment_b');
    }
}
