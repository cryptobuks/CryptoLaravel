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


Route::group( ['middleware' => 'auth' ], function()
{

    Route::get('/admin', 'Admin@index')->name('adminPage');
    Route::get('/admin/add-coins', 'Admin@addCoins')->name('addCoins');
    Route::get('/admin/update-coins', 'Admin@updateCoins')->name('updateCoins');
    Route::get('/admin/delete-coins', 'Admin@deleteCoins')->name('deleteCoins');



    Route::get('/tools', 'MainController@tools')->name('toolsPage');

    Route::get('/tools/coin', 'ToolsController@coinsPage')->name('coinsPage');

    Route::get('/tools/coin/{coin}', 'ToolsController@coin')->name('coinPage');


    Route::get('/api/coin/{ticker}', 'ApiController@coin')->name('apiCoin');


});





Route::get('/', 'MainController@index')->name('home');

Route::get('{path}', function ($path) {
    return Redirect::to('/');
})->where('path', '(index|home|homepage|main)');


Route::get('/ask', 'MainController@ask')->name('askPage');



Route::any('{query}',
    function() { return redirect('/login'); })
    ->where('query', '.*');




