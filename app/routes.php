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

Route::get('/', ['as' => 'home', function () {

	return View::make('hello');

}]);


Route::get('profile', function() {

	return "Bienvenido " . Auth::user()->email;

})->before('auth');

Route::get('login','SessionsController@create');

Route::get('logout','SessionsController@destroy');

Route::resource('sessions', 'SessionsController' , ['only' => ['index', 'create', 'destroy', 'store']]);

Route::resource('users', 'UsersController');



Route::get('/rendicions/{id}/create', 'RendicionsController@create');



Route::get('/rendicions/agentesshow','RendicionsController@agentesshow');

Route::resource('rendicions', 'RendicionsController');

Route::get('/juegos/{id}/saldar','JuegosController@saldar');

Route::resource('juegos', 'JuegosController');

Route::resource('diarios', 'DiariosController');
