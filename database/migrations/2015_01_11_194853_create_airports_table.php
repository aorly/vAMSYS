<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('airports', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('icao', 4)->index();
			$table->string('iata', 3)->index()->nullable();
			$table->string('name');
			$table->decimal('latitude', 10, 7);
			$table->decimal('longitude', 10, 7);
			$table->integer('region_id')->unsigned();
			$table->foreign('region_id')->references('id')->on('regions');
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
		Schema::drop('airports');
	}

}
