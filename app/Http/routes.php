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

Route::get('/', function (){
    //return view('welcome');
    return \App\Http\Controllers\ConfigController::GetAllConfig();
});
Route::get('test', 'RSAController@Test');

Route::get('home', 'HomeController@index');
Route::post('config','RSAController@Handle');
Route::get('config','RSAController@Handle');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
