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
//return redirect('/home');

Route::get('/', function () {   
    return view('welcome');
});

// Route::group(['prefix' => 'admin',  'middleware' => 'auth'], function()
// {
//     Route::get('/home', 'HomeController@index')->name('home');
// });

Auth::routes();

Route::get('/profile', 'ProfileController@index');


Route::get('/feed', 'FeedController@index');
Route::get('/home', 'HomeController@index')->name('home');

Route::post('/uploadPost', 'UploadPictureController@index');


