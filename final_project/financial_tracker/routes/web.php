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

// Route::post('/add/saving/validate', 'AddSavingController@validateSaving');

Route::group(['middleware' => 'auth'], function()
{
    // Dashboard Pages
    Route::get('/dashboard', 'Dashboard\OverviewController@index');
    Route::get('/dashboard/overview', 'Dashboard\OverviewController@index');
    Route::get('/dashboard/incomes', 'Dashboard\IncomeController@index');
    Route::get('/dashboard/expenses', 'Dashboard\ExpenseController@index');
    Route::get('/dashboard/savings', 'Dashboard\SavingController@index');
    
    Route::post('/dashboard/change/filter', 'Dashboard\TimeFilterController@change');

    //Page Configuration Pages
    Route::get('/profile', 'ProfileController@index');
    Route::post('/profile/edit', 'ProfileController@edit');

    //Adding transactions Pages
    Route::get('/add/transaction', 'AddTransactionController@index' );
    Route::post('/add/transaction/create', 'AddTransactionController@create');

    //Adding savings Pages
    Route::get('/add/saving', 'AddSavingController@index' );
    Route::post('saving/validate','Validation@validateSaving');
    Route::post('/add/saving/confirmed', 'AddSavingController@validateAndAdd');
    // Route::post('/add/saving/confirm', 'AddSavingController@confirm');

    //Edit Transaction
    Route::get('/edit/transaction/{transaction_id}', 'EditTransactionController@index' );
    Route::post('/edit/transaction', 'EditTransactionController@edit' );


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





