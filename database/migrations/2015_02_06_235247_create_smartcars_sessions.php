<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmartcarsSessions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('smartCARS_sessions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('pilot_id')->unsigned();
			$table->foreign('pilot_id')->references('id')->on('pilotd');
			$table->string('sessionid');
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
		Schema::drop('smartCARS_sessions');
	}

}
