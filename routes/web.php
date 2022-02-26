<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

Route::get('/','HomeController@index')->name('home');

Route::post('subscriber', 'SubscriberController@store')->name('subscriber.store')->middleware('demo_mode');

Route::get('post/{slug}', 'PostController@details')->name('post.details');

Route::get('posts', 'PostController@index')->name('post.index');

Route::get('/category/{slug}', 'PostController@postByCategory')->name('category.posts');
Route::get('/tag/{slug}', 'PostController@postByTag')->name('tag.posts');

Route::get('/search', 'SearchController@search')->name('search');

Route::get('profile/{username}', 'AuthorController@profile')->name('author.profile');

//Authentication Routes
Auth::routes();



//These are all for Admin dashboard routes and here defined file directory , prefix , namespace, middleware as default
Route::group(['as'=>'admin.','prefix'=>'admin', 'namespace'=>'Admin', 'middleware'=>['auth', 'admin', 'demo_mode']], function() {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('tag', 'TagController');
    Route::resource('category', 'CategoryController');
    Route::resource('post', 'PostController');


    Route::get('pending/post', 'PostController@pending')->name('post.pending');
    Route::put('/post/{id}/approved', 'PostController@approval')->name('post.approved');
    Route::put('/post/{id}/approve', 'PostController@approve')->name('post.approve');


    Route::get('/subscriber', 'SubscriberController@index')->name('subscriber.index');
    Route::delete('/subscriber/{subscriber}', 'SubscriberController@destroy')->name('subscriber.destroy');

    Route::get('settings', 'SettingsController@index')->name('settings');

    Route::put('profile-update', 'SettingsController@updateProfile')->name('profile.update');

    Route::put('password-update', 'SettingsController@updatePassword')->name('password.update');


    Route::get('/favourite', 'FavouriteController@index')->name('favourite.index');

    Route::get('comments', 'CommentController@index')->name('comments.index');
    Route::delete('comments/{id}', 'CommentController@destroy')->name('comment.destroy');

    Route::get('authors', 'AuthorController@index')->name('author.index');
    Route::delete('authors/{id}', 'AuthorController@destroy')->name('author.destroy');

});


//These are all for Author dashboard routes and here defined file directory , prefix , namespace, middleware as default
Route::group(['as'=>'author.','prefix'=>'author', 'namespace'=>'Author', 'middleware'=>['auth', 'author', 'demo_mode']], function() {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('post', 'PostController');

    Route::get('settings', 'SettingsController@index')->name('settings');

    Route::put('profile-update', 'SettingsController@updateProfile')->name('profile.update');

    Route::put('password-update', 'SettingsController@updatePassword')->name('password.update');

    Route::get('/favourite', 'FavouriteController@index')->name('favourite.index');

    Route::get('comments', 'CommentController@index')->name('comments.index');
    Route::delete('comments/{id}', 'CommentController@destroy')->name('comment.destroy');
});


Route::group(['middleware' => ['auth', 'demo_mode']], function() {
    Route::post('favourite/{post}/add', 'FavouriteController@addFav')->name('post.favourite');
    Route::post('comment/{post}', 'CommentController@store')->name('comment.store');
});

View::composer('layouts.frontend.partials.footer', function ($view) {
    $categories = App\Category::all();
    $view->with('categories', $categories);
});
