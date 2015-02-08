<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAircraftParameters extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('aircraft', function(Blueprint $table)
		{
			$table->integer('passengers')->unsigned();
			$table->integer('cargo')->unsigned();
			$table->integer('rank_id')->unsigned()->nullable()->default(null);
			$table->foreign('rank_id')->references('id')->on('ranks');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('aircraft', function(Blueprint $table)
		{
			$table->dropColumn('passengers')->unsigned();
			$table->dropColumn('cargo')->unsigned();
			$table->dropColumn('rank_id')->unsigned();
		});
	}

}
