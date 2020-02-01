<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameRecieveToReceiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if (!Schema::hasTable('a_receives')) {
			Schema::rename('a_recieves', 'a_receives');
		}
		if (!Schema::hasTable('a_receive_a')) {
			Schema::rename('a_recieve_a', 'a_receive_a');
		}
		if (!Schema::hasTable('a_receive_b')) {
			Schema::rename('a_recieve_b', 'a_receive_b');
		}
		if (!Schema::hasTable('a_receive_c')) {
			Schema::rename('a_recieve_c', 'a_receive_c');
		}
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
