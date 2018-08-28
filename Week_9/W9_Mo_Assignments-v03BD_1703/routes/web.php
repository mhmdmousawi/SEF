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


Route::get('/', function () {   
    return view('welcome');
});

Route::get('/feed', 'FeedController@index');
Route::get('/home', 'FeedController@index')->name('home');

Auth::routes();

//works fine
Route::get('/profile', 'ProfileController@profile');
Route::get('/profile/{user_id}', 'ProfileController@profile_with_id');

//work fine
Route::post('/uploadProfilePicture', 'UploadPictureController@profile_picture');
Route::post('/uploadPostPicture', 'UploadPictureController@post_picture');

//works fine
Route::post('/follow/{user_id}', 'FollowController@follow');
Route::post('/unfollow/{user_id}', 'FollowController@unfollow');

//works fine
Route::post('/like/{post_id}', 'LikeController@like');
Route::post('/unlike/{post_id}', 'LikeController@unlike');

//works fine
Route::get('/addPost', 'PostController@addPost');