<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    public function addFav($post) {
        $user = Auth::user();
        $isFavourite = $user->favourite_posts()->where('post_id',$post)->count();

        if ($isFavourite == 0){
            $user->favourite_posts()->attach($post);
            Toastr::success('Post Successfully Added to Your Favourite List :)', 'Success');
            return back();
        }else {
            $user->favourite_posts()->detach($post);
            Toastr::success('Post successfully removed from your favourite list :)', 'Success');
            return back();
        }
    }
}
