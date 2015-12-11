<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller {
    public static function Login(){
        $Passwd=Input::get('passwd');
        $Username=Input::get('username');
        $UserAuth = AuthController::UserAuth($Username,$Passwd);
        //var_dump($UserAuth);
        if($UserAuth==false){
            //Session::flush();
            //return AuthController::EncryptPasswd($Passwd);
            return view('login');
        }else{
            Session::put('username',$UserAuth->name);
            Session::put('userid',$UserAuth->id);
            return Redirect::to('panel');
        }

    }
    public static function EncryptPasswd($salt,$Passwd){
        $result = md5(base64_encode($Passwd.$salt));
        return $result;
    }
    public static function UserAuth($Username,$Passwd){
        $User = User::where('name','=',$Username)->first();
        //var_dump($User);
        if($User==null){
            return false;
        }else{
            if($User->password == AuthController::EncryptPasswd($User->salt,$Passwd)){
                return $User;
            }else{
                return false;
            }
        }
    }
    public static function RstPasswd($UserName,$OldPasswd,$Passwd){
        if(AuthController::UserAuth($UserName,$OldPasswd)==false){return false;}
        $User = User::where('name','=',$UserName)->first();
        $User->password=AuthController::EncryptPasswd($User->salt,$Passwd);
        $User->save();
        return true;
    }
}
