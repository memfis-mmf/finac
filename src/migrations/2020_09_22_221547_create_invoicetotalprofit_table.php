<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicetotalprofitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoicetotalprofit', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('accountcode');
            $table->decimal('amount', 18, 5)->nullable();
            $table->string('type');
            $table->foreign('accountcode')->references('id')->on('coas');
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
        Schema::dropIfExists('invoicetotalprofit');
    }
}
