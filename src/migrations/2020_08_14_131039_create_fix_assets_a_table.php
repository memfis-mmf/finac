<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFixAssetsATable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fix_assets_a', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('transactionnumber');
            $table->integer('id_asset')->default(0);
            $table->decimal('povalue',18,5)->default(0);
            $table->decimal('salvagevalue',18,5)->default(0);
            $table->integer('usefullife')->default(0);
            $table->integer('atmonth')->default(0);
            $table->decimal('deprecation',18,5)->default(0);
            $table->string('coad');
            $table->string('coac');
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
        Schema::dropIfExists('fix_assets_as');
    }
}
