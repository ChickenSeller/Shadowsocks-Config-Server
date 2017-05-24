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
Route::get('ssvip/{token}','RSAController@HandleSSVip');
Route::post('ssvip/{token}','RSAController@HandleSSVip');
Route::get('test/{token}',function($token){
    return \App\Http\Controllers\ConfigController::GetSSvipConfig($token);
});
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
Route::get('logout',function(){
    Session::forget('userid');
    Session::forget('username');
    return Redirect::to('login');
});
Route::post('login',function(){
    return \App\Http\Controllers\Auth\AuthController::Login();
});
Route::get('login',function(){
    if(Session::get('userid')!="" && Session::get('username')!=""){return Redirect::to('Panel');}
    return view('login');
});

Route::group(['middleware' => 'userAuth'],function(){
    Route::post('panel',function(){
        switch(Request::get('action')){
            case "DelServer":
                return \App\Http\Controllers\ViewController::DelServerView(Request::get('ServerID'));
                break;
            case "RstPasswd":
                //return Request::get('newpasswd');
                return \App\Http\Controllers\ViewController::RstPasswdView();
                break;
            case "AddServer":
                //return Request::get('newpasswd');
                return \App\Http\Controllers\ViewController::AddServerView();
                break;
            case "ChangeName":
                return \App\Http\Controllers\ViewController::ChnageNameView();
                break;
            default:
                return \App\Http\Controllers\ViewController::PanelView();
        }

    });
    Route::get('panel',function(){
        switch(Request::get('action')){
            case "DelServer":
                return \App\Http\Controllers\ViewController::DelServerView(Request::get('ServerID'));
                break;
            case "ChnageName":
                return \App\Http\Controllers\ViewController::PanelView("ChnageName");
                break;
            case "RstPasswd":
                //return Request::get('newpasswd');
                return \App\Http\Controllers\ViewController::PanelView("Passwd");
                break;
            case "AddItem":
                //return Request::get('newpasswd');
                return \App\Http\Controllers\ViewController::PanelView("AddItem");
                break;
            default:
                return \App\Http\Controllers\ViewController::PanelView();
        }

    });
    Route::get('logout',function(){
        Session::forget('userid');
        Session::forget('username');
        return Redirect::to('login');
    });
});