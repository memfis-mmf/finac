<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeDescriptionNullableInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('invoices', function (Blueprint $table) {
        $table->dropColumn('description');
      });

      Schema::table('trxinvoice', function (Blueprint $table) {
        $table->dropColumn('description');
      });

      Schema::table('invoices', function (Blueprint $table) {
        $table->text('description')->nullable();
      });

      Schema::table('trxinvoice', function (Blueprint $table) {
        $table->text('description')->nullable();
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
