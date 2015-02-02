<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function ()
{
    return View::make('index');
});

Route::group(['prefix' => 'guestbook'], function ()
{
    Route::get('/all', 'GuestbookController@getAll');
    Route::post('/new', 'GuestbookController@createNew');
    Route::post('/delete', 'GuestbookController@delete');
});