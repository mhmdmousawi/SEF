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
    // return view('welcome');
});

Auth::routes();


Route::group(['middleware' => 'auth'], function()
{
    // Route::get('/', function () {
    //     return view('welcome');
    // });

    // Dashboard Pages
    Route::get('/dashboard/overview', function() {
        return 'Dashboard Page -- Overview' ;
    } );

    Route::get('/dashboard/incomes', function() {
        return 'Dashboard Page -- Incomes' ;
    } );

    Route::get('/dashboard/expenses', function() {
        return 'Dashboard Page -- Expenses' ;
    } );

    Route::get('/dashboard/savings', function() {
        return 'Dashboard Page -- Savings' ;
    } );
    

    //Page Configuration Pages
    Route::get('/profile', function() {
        return 'Profile Configuration Page' ;
    } );

    //Adding transactions Pages
    Route::get('/add/income', function() {
        return 'Adding an income transaction ' ;
    } );

    Route::get('/add/expense', function() {
        return 'Adding an expense transaction ' ;
    } );

    //Adding Saving plan
    Route::get('/add/saving', function() {
        return 'Adding a saving plan ' ;
    } );

    Route::get('/add/saving/validate', function() {
        return 'Saving Validation ' ;
    } );

    //Adding Category
    Route::get('/add/category', function() {
        return 'Adding a new category' ;
    } );

    //Adding Currency
    Route::get('/add/currency', function() {
        return 'Adding a new currency';
    } );


    Route::get('/home', 'HomeController@index')->name('home');
});





