<?php

namespace App;

use Illuminate\Database\Eloquent\Model as ModelClass;

class YearMake extends ModelClass
{
	protected $table = 'years_makes';

    protected $fillable = ['year_id', 'make_id'];
}
