<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    //database table relationship many to one
    public function users() {
        return $this->hasMany('App\User');
    }
}
