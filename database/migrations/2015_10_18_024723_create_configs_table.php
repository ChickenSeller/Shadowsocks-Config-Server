<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */

        public function up()
    {
        Schema::create('config', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('fingerprint');
            $table->text('publickey');
            $table->text('privatekey');
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
		Schema::drop('config');
	}

}
