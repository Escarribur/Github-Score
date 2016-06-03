<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'PagesController@home');

Route::post('puntaje', 'PagesController@score_post');
Route::get('puntaje', 'PagesController@score');

Route::get('about', 'PagesController@about');

Route::get('cards', 'CardsController@index');

Route::get('cards/{card}', 'CardsController@show');