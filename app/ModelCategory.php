<?php

namespace App;

use Illuminate\Database\Eloquent\Model as ModelClass;

class ModelCategory extends ModelClass
{
	protected $table = 'models_categories';

    protected $fillable = ['model_id', 'category_id'];
}
