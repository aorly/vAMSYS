<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('position_reports', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('booking_id')->unsigned();
			$table->foreign('booking_id')->references('id')->on('bookings');
			$table->integer('altitude');
			$table->integer('magnetic_heading');
			$table->integer('true_heading');
			$table->decimal('latitude', 15, 12);
			$table->decimal('longitude', 15, 12);
			$table->integer('groundspeed');
			$table->integer('distance_remaining');
			$table->integer('phase');
			$table->string('departure_time');
			$table->string('time_remaining');
			$table->string('estimated_arrival_time');
			$table->string('network');
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
		Schema::drop('position_reports');
	}

}
