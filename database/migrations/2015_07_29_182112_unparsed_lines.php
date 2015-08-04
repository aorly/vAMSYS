<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UnparsedLines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unparsed_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->text('line');
            $table->integer('acars_id')->unsigned();
            $table->foreign('acars_id')->references('id')->on('acars');
            $table->integer('pirep_id')->unsigned();
            $table->foreign('pirep_id')->references('id')->on('pireps');
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
        Schema::drop('unparsed_lines');
    }
}
