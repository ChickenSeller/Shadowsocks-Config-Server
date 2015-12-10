<?php namespace App\Http\Controllers;

use App\Config;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;
/*
 * 密码加密方式：
 * 用户把原始密码进行MD5后的结果m发往服务器，服务器对m进行如下处理：
 * md5(base64_encode(m.salt))
 * 把结果存入数据库
 */
class InstallController extends Controller {

	public static function Install($username,$password,$friendlyname){

            $User = new User();
            $salt = md5(time().str_random(32));
            $password = md5(base64_encode($password.$salt));
            $User->name = $username;
            $User->password = $password;
            $User->salt = $salt;
            $User->save();
            $config = array('private_key_bits' => 1024);
            $res = openssl_pkey_new($config);
            openssl_pkey_export($res, $privKey);
            $pubKey = openssl_pkey_get_details($res);
            $pubKey = $pubKey["key"];
            $Config = Config::find(1);
            if($Config!=null){
                abort(404);
            }
            $fp = md5(time().str_random(32));
            $Config = new Config();
            $Config->fingerprint =  $fp;
            $Config->publickey = $pubKey;
            $Config->privatekey = $privKey;
            $Config->friendlyname = $friendlyname;
            $Config->save();
            $myfile = fopen(base_path()."/app.lock", "w");
            return true;



    }
    public static function Ready(){
        if(file_exists(base_path()."/app.lock")){
            abort(404);
        }
        $Config = Config::find(1);
        if($Config!=null){
            abort(404);
        }
        return view('install');
    }

}
