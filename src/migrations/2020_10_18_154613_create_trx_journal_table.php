<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxJournalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trxjournals', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
			$table->integer('approve')->default(0);
			$table->string('voucher_no');
			$table->dateTime('transaction_date');
			$table->string('ref_no')->nullable();
			$table->string('currency_code');
			$table->decimal('exchange_rate', 18, 5);
			$table->bigInteger('journal_type');
			$table->decimal('total_transaction', 18, 5)->nullable();
			$table->integer('automatic_journal_type')->nullable();
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
        Schema::dropIfExists('trxjournals');
    }
}
