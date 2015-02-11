<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAirlinesCallsignRules extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('airlines', function(Blueprint $table)
		{
			$table->text('callsign_rules')->nullable()->default(null);
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
			$table->dropColumn('callsign_rules');
		});
	}

}
