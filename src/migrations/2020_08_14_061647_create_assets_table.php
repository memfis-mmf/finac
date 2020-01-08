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
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('group')->nullable();
            $table->string('manufacturername')->nullable();
            $table->string('brandname')->nullable();
            $table->string('modeltype')->nullable();
            $table->dateTime('productiondate')->nullable();
            $table->string('serialno')->nullable();
            $table->dateTime('warrantystart')->nullable();
            $table->dateTime('warrantyend')->nullable();
            $table->string('ownership')->nullable();
            $table->string('location')->nullable();
            $table->string('pic')->nullable();
            $table->string('grnno')->nullable();
            $table->string('pono')->nullable();
            $table->decimal('povalue',18,2)->nullable();
            $table->decimal('salvagevalue',18,2)->nullable();
            $table->string('supplier')->nullable();
            $table->string('fixedtype')->nullable();
            $table->decimal('usefullife',18,2)->default(0);
            $table->dateTime('depreciationstart')->nullable();
            $table->dateTime('depreciationend')->nullable();
            $table->string('coaacumulated')->nullable();
            $table->string('coaexpense')->nullable();
            $table->integer('usestatus')->nullable();
            $table->string('description')->nullable();
            $table->integer('asset_category_id');
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
