<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYearsMakesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('years_makes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year_id')->references('id')->on('years')->index();
            $table->integer('make_id')->references('id')->on('makes')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('years_makes');
    }
}
