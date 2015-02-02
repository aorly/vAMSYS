<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePirepsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pireps', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('pilot_id')->unsigned();
			$table->foreign('pilot_id')->references('id')->on('pilots');
			$table->integer('aircraft_id')->unsigned();
			$table->foreign('aircraft_id')->references('id')->on('aircraft');
			$table->integer('route_id')->unsigned();
			$table->foreign('route_id')->references('id')->on('routes');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pireps');
	}

}
