<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetswriteoffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assetswriteoffs', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('id_branch')->nullable();
            $table->integer('approve')->default(0);
            $table->string('transactionnumber');
            $table->dateTime('transactiondate');
            $table->integer('id_asset')->nullable();
            $table->decimal('sellingprice',18,5);
            $table->string('accountcode');
            $table->string('coapl');
            $table->string('description');
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
        Schema::dropIfExists('assetswriteoffs');
    }
}
