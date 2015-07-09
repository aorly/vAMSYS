<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEvenMorePirepsColumns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pireps', function(Blueprint $table)
		{
            $table->longText('log');
			$table->text('provided_route');
            $table->text('comments');
            $table->enum('status', ['new', 'processing', 'failed', 'processed', 'scoring', 'complete', 'accepted', 'rejected'])
                ->default('new');
            $table->dateTime('processed_time');
            $table->dateTime('scored_time');
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
            $table->dropColumn('log');
            $table->dropColumn('provided_route');
            $table->dropColumn('comments');
            $table->dropColumn('status');
            $table->dropColumn('processed_time');
            $table->dropColumn('scored_time');
		});
	}

}
