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

Route::get('/','RSAController@Handle');
Route::post('/','RSAController@Handle');
Route::get('test','RSAController@Test');
Route::get('install','InstallController@Ready');
Route::post('install',function(){
    $Username = Input::get('username');
    $Password = Input::get('passwd');
    $Server = Input::get('servername');
    $res = \App\Http\Controllers\InstallController::Install($Username,$Password,$Server);
    if($res == false){

    }
    return view('complete');
});