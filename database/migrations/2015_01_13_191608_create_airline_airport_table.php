<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirlineAirportTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('airline_airport', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('airline_id')->unsigned();
			$table->foreign('airline_id')->references('id')->on('airlines');
			$table->integer('airport_id')->unsigned();
			$table->foreign('airport_id')->references('id')->on('airports');
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
		Schema::drop('airline_airport');
	}

}
