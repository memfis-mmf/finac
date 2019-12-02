<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxBSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_BS', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
            $table->integer('approve');
            $table->integer('closed');
            $table->string('transaction_number');
            $table->dateTime('transaction_date');
            $table->integer('id_employee');
            $table->date('date_return');
            $table->decimal('value', 18, 2);
            $table->string('coac');
            $table->string('coad');
            $table->string('description');
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
        Schema::dropIfExists('trx_BS');
    }
}
