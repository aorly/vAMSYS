<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPilotRank extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pilots', function(Blueprint $table)
		{
			$table->integer('rank_id')->unsigned();
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
		Schema::table('pilots', function(Blueprint $table)
		{
			$table->dropColumn('rank_id');
		});
	}

}
