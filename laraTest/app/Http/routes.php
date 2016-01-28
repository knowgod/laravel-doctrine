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

Route::get('articles', 'Doctrination\ArticlesController@index');
Route::get('articles/filter', 'Doctrination\ArticlesController@index');
Route::get('articles/create', 'Doctrination\ArticlesController@create');
Route::get('articles/{id}', 'Doctrination\ArticlesController@show');
Route::get('articles/delete/{id}', 'Doctrination\ArticlesController@destroy');
Route::get('articles/edit/{id}', 'Doctrination\ArticlesController@edit');

Route::post('articles', 'Doctrination\ArticlesController@store');
Route::post('articles/filter', 'Doctrination\ArticlesController@index');

Route::get(
    'starwars',
    function () {
        return view('starwars');
    }
);

Route::get(
    'starwars/lukeskywalker',
    function () {
        return view('starwars/lukeskywalker');
    }
);