<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnTotalInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('invoices', function (Blueprint $table) {
        $table->dropColumn('total');
      });

      Schema::table('trxinvoice', function (Blueprint $table) {
        $table->dropColumn('total');
      });

      Schema::table('invoices', function (Blueprint $table) {
        $table->decimal('total', 18, 5)->nullable();
        $table->decimal('subtotal', 18, 5)->nullable();
      });

      Schema::table('trxinvoice', function (Blueprint $table) {
        $table->decimal('total', 18, 5)->nullable();
        $table->decimal('subtotal', 18, 5)->nullable();
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
