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
    // Dashboard Pages
    Route::get('/dashboard/overview', 'Dashboard\OverviewController@index');
    Route::get('/dashboard/incomes/monthly', 'Dashboard\IncomeController@monthly' )->name('/dashboard/incomes/monthly');
    Route::get('/dashboard/incomes/weekly', 'Dashboard\IncomeController@weekly' );
    Route::get('/dashboard/expenses', 'Dashboard\ExpenseController@index');
    Route::get('/dashboard/savings', 'Dashboard\SavingController@index');
    

    //Page Configuration Pages
    Route::get('/profile', function() {
        return 'Profile Configuration Page' ;
    } );

    //Adding transactions Pages
    Route::get('/add/transaction', 'AddTransactionController@index' );
    Route::post('/add/transaction/create', 'AddTransactionController@create');

    //Adding savings Pages
    Route::get('/add/saving', 'AddSavingController@index' );
    Route::post('/add/saving/validate', 'AddSavingController@validateSaving');
    Route::post('/add/saving/confirm', 'AddSavingController@confirm');

    

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





