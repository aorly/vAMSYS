<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePilotsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pilots', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username')->unique();
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('airline_id')->unsigned();
			$table->foreign('airline_id')->references('id')->on('airlines');
			$table->integer('location_id')->unsigned();
			$table->foreign('location_id')->references('id')->on('airports');
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
		Schema::drop('pilots');
	}

}
