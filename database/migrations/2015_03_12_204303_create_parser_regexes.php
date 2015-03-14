<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParserRegexes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('parser_regexes', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('acars_id')->unsigned();
            $table->foreign('acars_id')->references('id')->on('acars');
			$table->text('regex');
            $table->string('parser');
            $table->string('abstract');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('parser_regexes');
	}

}
