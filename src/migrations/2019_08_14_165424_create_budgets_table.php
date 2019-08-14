<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('id_branch')->nullable();
            $table->integer('year');
            $table->string('xtype');
            $table->string('accounttype');
            $table->text('description');
            $table->decimal('1',18,4);
            $table->decimal('2',18,4);
            $table->decimal('3',18,4);
            $table->decimal('4',18,4);
            $table->decimal('5',18,4);
            $table->decimal('6',18,4);
            $table->decimal('7',18,4);
            $table->decimal('8',18,4);
            $table->decimal('9',18,4);
            $table->decimal('10',18,4);
            $table->decimal('11',18,4);
            $table->decimal('12',18,4);
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
        Schema::dropIfExists('budgets');
    }
}
