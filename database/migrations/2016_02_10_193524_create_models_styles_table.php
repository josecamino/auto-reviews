<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelsStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('models_styles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('model_id')->references('id')->on('models')->index();
            $table->integer('style_id')->references('id')->on('styles')->index();
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
        Schema::drop('models_styles');
    }
}
