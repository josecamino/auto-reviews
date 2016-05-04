<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('models', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year_make_id')->references('id')->on('years_makes')->index();
            $table->string('name');
            $table->integer('gen')->unsigned()->default(1);
            $table->float('avg_rating')->nullable();
            $table->integer('rating_count')->unsigned()->default(0);
            $table->string('img_url');
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
        Schema::drop('models');
    }
}
