<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrxJournalATable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trxjournala', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid')->unique();
			$table->string('id_branch');
			$table->string('voucher_no');
			$table->string('description');
			$table->bigIntger('account_code');
			$table->decimal('debit', 18, 5)->nullable();
			$table->decimal('credit', 18, 5)->nullable();
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
        Schema::dropIfExists('trxjournala');
    }
}
