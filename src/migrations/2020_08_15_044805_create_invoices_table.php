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
            $table->integer('id_branch')->nullable();
            $table->integer('closed')->default(0);
            $table->string('transactionnumber');
            $table->dateTime('transactiondate');
            $table->integer('id_customer');
            $table->string('currency');
            $table->decimal('exchangerate',18,5);
            $table->decimal('discountpercent',18,5);
            $table->decimal('discountvalue',18,5);
            $table->decimal('ppnpercent',18,5);
            $table->decimal('ppnvalue',18,5);
            $table->decimal('grandtotalforeign',18,5);
            $table->decimal('grandtotal',18,5);
            $table->string('accountcode');
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
        Schema::dropIfExists('invoices');
    }
}
