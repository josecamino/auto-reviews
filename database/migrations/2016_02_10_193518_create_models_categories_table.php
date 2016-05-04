<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('models_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('model_id')->references('id')->on('models')->index();
            $table->integer('category_id')->references('id')->on('categories')->index();
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
        Schema::drop('models_categories');
    }
}
