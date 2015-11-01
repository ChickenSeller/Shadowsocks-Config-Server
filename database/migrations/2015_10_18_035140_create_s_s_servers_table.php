<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSSServersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ss_servers', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('host');
            $table->string('method');
            $table->integer('port');
            $table->text('passwd');
            $table->text('comment');
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
		Schema::drop('ss_servers');
	}

}
