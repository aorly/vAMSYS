<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMorePirepsColumns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pireps', function(Blueprint $table)
		{
			$table->dropForeign('pireps_aircraft_id_foreign');
			$table->dropForeign('pireps_pilot_id_foreign');
			$table->dropForeign('pireps_route_id_foreign');
			$table->dropColumn('pilot_id');
			$table->dropColumn('aircraft_id');
			$table->dropColumn('route_id');

			$table->integer('booking_id')->unsigned()->after('id');
			$table->foreign('booking_id')->references('id')->on('bookings');

			$table->integer('fuel_used');
			$table->integer('load');
			$table->string('flight_time');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pireps', function(Blueprint $table)
		{
			$table->dropForeign('pireps_booking_id_foreign');
			$table->dropColumn('booking_id');

			$table->integer('pilot_id')->unsigned();
			$table->foreign('pilot_id')->references('id')->on('pilots');
			$table->integer('aircraft_id')->unsigned();
			$table->foreign('aircraft_id')->references('id')->on('aircraft');
			$table->integer('route_id')->unsigned();
			$table->foreign('route_id')->references('id')->on('routes');

			$table->dropColumn('fuel_used');
			$table->dropColumn('load');
			$table->dropColumn('flight_time');
		});
	}

}
