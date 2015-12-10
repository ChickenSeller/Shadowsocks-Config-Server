<?php namespace App\Http\Controllers;

use App\Config;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use League\Flysystem\Exception;
use Psy\TabCompletion\Matcher\KeywordsMatcher;

class RSAController extends Controller {
    public static function Test(Request $request){
        $config = array('private_key_bits' => 512);
        $privKey = openssl_pkey_new($config);
        var_dump($privKey);
        openssl_pkey_export($privKey, $privKey2);
        $pubKey = openssl_pkey_get_details($privKey);
        $pubKey = $pubKey["key"];
        var_dump($privKey2);
        var_dump($pubKey);

    }
    public static function KeyExchange($ClientKey,$request){
        $res = "";
        $crypt = new mycrypt();
        $FingerPrintObj=new FingerPrintResponse();
        $FingerPrintObj->VerifyString = str_random(32);
        try{
            $res = $crypt->encrypt(json_encode($FingerPrintObj),$ClientKey);
        }catch (\Exception $e){
            abort(404);
        }
        $fp = md5(time().str_random(16));
        $Session = new \App\Session();
        $Session->session_fp = $fp;
        $Session->user_pub = $ClientKey;
        $Session->verify_string = $FingerPrintObj->VerifyString;
        $Session->save();
        $request->session()->put('action','config');
        $request->session()->put('fp',$fp);
        $request->session()->put('provider',$crypt->friendlyname);
        //echo $request->session()->get('action');
        return $res;
    }
    public static function PushConfig($PostData,$request){
        $RequestJson = "";
        $crypt = new mycrypt();
        try{
            $RequestJson = $crypt->decrypt($PostData);
        }catch (\Exception $e){
            abort(404);
        }
        $Request = json_decode($RequestJson);
        $DecryptedString = $Request->decrypted_string;
        $VerifyString=$Request->verify_string;
        $fp = Session::get('fp');
        $Session = \App\Session::where('session_fp','=',$fp)->where('verify_string','=',$DecryptedString)->first();
        if($Session==null){
            abort(404);
        }
        $Configs=ConfigController::GetAllConfig();
        $result = new ConfigResponse();
        $result->VerifyString = $VerifyString;
        $result->Config = $Configs;
        $result->Provider = Session::get('provider');
        $res = "";
        try{
            $res = $crypt->encrypt(json_encode($result),$Session->user_pub);
        }catch (\Exception $e){
            abort(404);
        }
        $Session->delete();
        $request->session()->forget('action');
        $request->session()->forget('fp');
        $request->session()->forget('provider');
        return $res;
    }
    public static function Handle(Request $request){
        if($request->session()->has('action') && $request->session()->has('fp')){
            switch($request->session()->get('action')){
                case "config":
                    $PostData = file_get_contents("php://input");
                    return RSAController::PushConfig($PostData,$request);
                break;
                default:
                    $PostData = file_get_contents("php://input");
                    return RSAController::KeyExchange($PostData,$request);
            }
        }else{

            $PostData = file_get_contents("php://input");
            return RSAController::KeyExchange($PostData,$request);
        }
    }
}
class mycrypt {

    public $pubkey;
    public $privkey;
    public $friendlyname;

    function __construct() {
        $this->privkey = Config::find(1)->privatekey;
        $this->friendlyname = Config::find(1)->friendlyname;
    }

    public function encrypt($data,$Key) {
        $data = base64_encode($data);
        $encrypted = "";
        //把原始数据分段
        $len = 117;
        $m = strlen($data) / $len;

        if($m * $len!=strlen($data)){
            $m=$m+1;
        }

        for($i=0;$i<$m;$i++){
            $temp = "";
            $res = false;
            if ($i < $m - 1)
            {
                $temp =  substr($data,$i*$len,$len);
            }
            else{
                $temp = substr($data,$i*$len);
            }
            try{
                $res = openssl_public_encrypt($temp, $tempencrypted, $Key);
            }catch (\ErrorException $e){
                //echo $e->getMessage();
                throw new Exception($e->getMessage());
            }
            if ($res){
                $temp = base64_encode($tempencrypted);
                $encrypted = $encrypted.$temp;
            }else{
                return "Fail";
            }
        }
         return $encrypted;
    }

    public function decrypt($data) {
        $decrypted = "";
        //分段
        $len = 172;
        $m = strlen($data)/$len;

        if($m * $len !=strlen($data)){
            $m = $m+1;
        }

        for($i=0;$i<$m;$i=$i+1){
            $temp = "";
            if ($i < $m - 1)
            {
                $temp =  substr($data,$i*$len,$len);
            }
            else{
                $temp = substr($data,$i*$len);
            }
            if (openssl_private_decrypt(base64_decode($temp), $tempdecrypted, $this->privkey)){
                $decrypted = $decrypted.$tempdecrypted;
            }else{
                return "Fail";
            }
        }
        return base64_decode($decrypted);
    }
}
class FingerPrintResponse {
    public $FingerPrint;
    public $ServerPublicKey;
    public $VerifyString;
    public function __construct(){
        $this->ServerPublicKey = Config::find(1)->publickey;
        $this->FingerPrint = Config::find(1)->fingerprint;
    }
}
class ConfigResponse {
    public $Config;
    public $VerifyString;
    public $Provider;
}
