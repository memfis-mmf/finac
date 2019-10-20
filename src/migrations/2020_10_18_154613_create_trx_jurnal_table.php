<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxJurnalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trxjurnal', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
			$table->integer('id_branch');
			$table->integer('approve');
			$table->string('voucher_no');
			$table->dateTime('transaction_date');
			$table->string('ref_no');
			$table->string('currency_code');
			$table->decimal('exchange_rate', 18, 5);
			$table->string('journal_type');
			$table->decimal('total_transaction', 18, 5);
			$table->integer('automatic_journal_type');
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
        Schema::dropIfExists('trxjurnal');
    }
}
