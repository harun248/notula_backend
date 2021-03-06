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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/notula/{id}', 'HomeController@notula')->name('notula');
Route::get('/notulas/{id}', 'HomeController@notulas')->name('notulas');


Route::get('/generate-pdf','HomeController@generatePDF');

