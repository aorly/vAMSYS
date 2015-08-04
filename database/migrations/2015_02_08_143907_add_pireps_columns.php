<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPirepsColumns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pireps', function(Blueprint $table)
		{
			$table->integer('landing_rate');
			$table->dateTime("pirep_start_time")->nullable();
			$table->dateTime("off_blocks_time")->nullable();
			$table->dateTime("departure_time")->nullable();
			$table->dateTime("landing_time")->nullable();
			$table->dateTime("on_blocks_time")->nullable();
			$table->dateTime("pirep_end_time")->nullable();
			$table->longText("pirep_data");
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
			$table->dropColumn('landing_rate');
			$table->dropColumn("pirep_start_time");
			$table->dropColumn("off_blocks_time");
			$table->dropColumn("departure_time");
			$table->dropColumn("landing_time");
			$table->dropColumn("on_blocks_time");
			$table->dropColumn("pirep_end_time");
			$table->dropColumn("pirep_data");
		});
	}

}
