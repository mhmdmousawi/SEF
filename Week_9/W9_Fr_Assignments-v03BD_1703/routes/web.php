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



Auth::routes();
Route::group([ 'middleware' => 'auth'], function()
{

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/channel/{channel_id}', 'RoomController@channel');
    Route::get('/chat/{profile_id}', 'RoomController@chat');
    
    Route::post('/sendChannel', 'ChatController@channel');
    Route::post('/sendDirect', 'ChatController@direct');

});




