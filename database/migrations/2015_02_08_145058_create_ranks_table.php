<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRanksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ranks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('level')->unsigned();
			$table->integer('airline_id')->unsigned();
			$table->foreign('airline_id')->references('id')->on('airlines');
			$table->string('name');
			$table->timestamps();

			$table->unique(array('level', 'airline_id'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ranks');
	}

}
