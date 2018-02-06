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

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'ItemsController@index');

Route::get('/', 'ItemsController@index');

Route::get('/items', 'ItemsController@index');

Route::get('/comments/{id}', 'CommentsController@index');

Route::post('/comments/{id}/add-comment', 'CommentsController@store');

Route::post('/comments/{id}/get-comments-now', 'CommentsController@get_comments_now');





