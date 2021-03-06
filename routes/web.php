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

Route::get('/threads', 'ThreadController@index');
Route::get('threads/create', 'ThreadController@create');

//Route::resource('threads', 'ThreadController');
Route::get('/threads/{channel}/{thread}', 'ThreadController@show');
Route::post('threads', 'ThreadController@store');
Route::post('/threads/{channel}/{thread}/reply', 'ReplyController@add');


Route::auth();
