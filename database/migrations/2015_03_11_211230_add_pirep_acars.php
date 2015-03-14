<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPirepAcars extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('acars', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
        });

		Schema::table('pireps', function(Blueprint $table)
		{
            $table->integer('acars_id')->unsigned()->nullable()->default(null);
            $table->foreign('acars_id')->references('id')->on('acars');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
    public function down()
    {
        Schema::drop('acars');
    }

}
