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

Route::get('/', function () {
    return view('welcome');
});

Route::get(
    'contact',
    function () {
        return view('contact');
    }
);

Route::get('tries', 'Tries\IndexController@index');

Route::get('about', 'PagesController@about');
Route::get('contact', 'PagesController@contact');

Route::get('contacts', 'Tries\ContactsController@index');
Route::get('contacts/{id}', 'Tries\ContactsController@show');

Route::get('articles', 'Tries\ArticlesController@index');
Route::get('articles/create', 'Tries\ArticlesController@create');
Route::get('articles/{id}', 'Tries\ArticlesController@show');
Route::get('articles/delete/{id}', 'Tries\ArticlesController@destroy');

Route::post('articles', 'Tries\ArticlesController@store');
