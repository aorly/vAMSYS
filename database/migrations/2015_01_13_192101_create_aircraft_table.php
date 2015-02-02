<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAircraftTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('aircraft', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('registration', 10)->index();
			$table->string('type', 6);
			$table->integer('airline_id')->unsigned();
			$table->foreign('airline_id')->references('id')->on('airlines');
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
		Schema::drop('aircraft');
	}

}
