<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //one category have multiple post
    public function posts() {
        return $this->belongsToMany('App\Post')->withTimestamps();
    }
}
