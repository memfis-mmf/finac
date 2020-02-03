<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocationAndDepartmentColumnCashbookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashbooks', function (Blueprint $table) {
			$table->enum(
				'location', ['Sidoarjo', 'Surabaya', 'Jakarta', 'Biak']
			)->nullable();
			$table->string('company_department')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
