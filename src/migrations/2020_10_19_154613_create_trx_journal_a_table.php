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
			$table->string('voucher_no');
			$table->string('description')->nullable();
			$table->bigInteger('account_code')->nullable();
			$table->decimal('debit', 18, 5)->default(0);
			$table->decimal('credit', 18, 5)->default(0);
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
