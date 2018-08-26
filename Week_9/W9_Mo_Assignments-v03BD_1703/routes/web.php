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


Auth::routes();

Route::get('/profile', 'ProfileController@index');


Route::get('/feed', 'FeedController@index');
Route::get('/home', 'HomeController@index')->name('home');

Route::post('/uploadProfilePicture', 'UploadPictureController@profile_picture');

Route::post('/uploadPostPicture', 'UploadPictureController@post_picture');
