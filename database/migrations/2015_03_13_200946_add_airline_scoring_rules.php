<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAirlineScoringRules extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('airlines', function(Blueprint $table)
		{
			$table->longText('scoring_rules');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('airlines', function(Blueprint $table)
		{
			$table->dropColumn('scoring_rules');
		});
	}

}
