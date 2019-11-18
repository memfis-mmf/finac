<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAPaymentATable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_payment_a', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('transactionnumber')->nullable();
            $table->integer('id_payment')->nullable();
            $table->string('code')->nullable();
            $table->string('currency')->nullable();
            $table->decimal('exchangerate',18,5)->nullable();
            $table->decimal('debit',18,5)->default(0);
            $table->decimal('credit',18,5)->default(0);
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
        Schema::dropIfExists('a_payment_as');
    }
}
