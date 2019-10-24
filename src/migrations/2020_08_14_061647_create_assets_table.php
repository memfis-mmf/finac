<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('active')->default(1);
            $table->string('code');
            $table->string('name');
            $table->string('group');
            $table->string('manufacturername');
            $table->string('brandname');
            $table->string('modeltype');
            $table->dateTime('productiondate');
            $table->string('serialno');
            $table->dateTime('warrantystart');
            $table->dateTime('warrantyend');
            $table->string('ownership');
            $table->string('location');
            $table->string('pic');
            $table->string('grnno');
            $table->string('pono');
            $table->decimal('povalue',18,2);
            $table->decimal('salvagevalue',18,2);
            $table->string('supplier');
            $table->string('fixedtype');
            $table->decimal('usefullife',18,2)->default(0);
            $table->dateTime('depreciationstart');
            $table->dateTime('depreciationend');
            $table->string('coaacumulated');
            $table->string('coaexpense');
            $table->integer('usestatus');
            $table->string('description');
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
        Schema::dropIfExists('assets');
    }
}
