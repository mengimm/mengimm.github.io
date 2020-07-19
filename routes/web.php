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

Route::get('/set_hook', 'viber@sethook');
Route::get('/unset_hook', 'viber@unsethook');

Route::get('/bot_get', 'viber@bot_get');

Route::get('/', function () {
    return view('welcome');
});
