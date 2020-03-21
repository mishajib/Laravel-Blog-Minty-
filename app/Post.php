<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed user_id
 */
class Post extends Model
{
    //one user have multiple post
    public function user() {
        return $this->belongsTo('App\User');
    }

    //one post have multiple category
    public function categories() {
        return $this->belongsToMany('App\Category')->withTimestamps();
    }


    //one post have multiple tags
    public function tags() {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    //one users have multiple favourite
    public function favourite_to_users() {
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    //one post have multiple comments
    public function comments() {
        return $this->hasMany('App\Comment');
    }

    //laravel local scope query for checking database field
    public function scopeApproved($query)
    {
        return $query->where('is_approved', 1);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }
}
