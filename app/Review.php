<?php

namespace App;

use Illuminate\Database\Eloquent\Model as ModelClass;

class Review extends ModelClass
{
    protected $fillable = ['model_id', 'rating', 'by', 'url', 'excerpt'];
}
