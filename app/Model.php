<?php

namespace App;

use Illuminate\Database\Eloquent\Model as ModelClass;

class Model extends ModelClass
{
    protected $fillable = ['year_make_id', 'name', 'gen', 'img_url', 'msrp', 'hp_min', 'hp_max', 'mpg_city', 'mpg_road', 'warranty', 'engine_options'];
}
