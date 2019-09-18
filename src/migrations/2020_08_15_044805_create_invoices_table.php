<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedBigInteger('id_branch')->default(1);
            $table->integer('closed')->default(0);
            $table->string('transactionnumber')->unique();
            $table->dateTime('transactiondate');
            $table->unsignedBigInteger('id_customer');
            $table->unsignedBigInteger('currency');
            $table->unsignedBigInteger('id_quotation');
            $table->unsignedBigInteger('id_bank');
            $table->json('attention')->nullable();
            $table->decimal('exchangerate',18,5);
            $table->decimal('discountpercent',18,5);
            $table->decimal('discountvalue',18,5);
            $table->decimal('ppnpercent',18,5);
            $table->decimal('ppnvalue',18,5);
            $table->decimal('grandtotalforeign',18,5);
            $table->decimal('grandtotal',18,5);
            $table->unsignedInteger('accountcode');
            $table->text('description');
            $table->foreign('accountcode')->references('id')->on('coas');
            $table->foreign('currency')->references('id')->on('currencies');
            $table->foreign('id_branch')->references('id')->on('branches');
            $table->foreign('id_customer')->references('id')->on('customers');
            $table->foreign('id_quotation')->references('id')->on('quotations');
            $table->foreign('id_bank')->references('id')->on('bank_accounts');
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
        Schema::dropIfExists('invoices');
    }
}
