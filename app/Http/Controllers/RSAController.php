<?php namespace App\Http\Controllers;

use App\Config;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Psy\TabCompletion\Matcher\KeywordsMatcher;

class RSAController extends Controller {
    public static function Test(){
        //$data = ConfigController::GetAllConfig();
        $crypt = new mycrypt();
        return $crypt->encrypt("xx",$crypt->pubkey);
        //return $crypt->decrypt("ilaMkj40tquS+fj7sdy/L4EERKHABaOY3eIa8HZxkoACFMPgZRpfPXCt2fTbOzKkoyZtW2hg2r3pHtTnXdgudRT+mYPklNqOubKbYkOODN0voghY7ThSRtz0aO1kdp3sRBp1HTOI2UWYk7EejeyKQJsSnErl7OiwAa4OGbYv2IQ=");//encrypt(json_encode("sadffdgsddddfffdddddddddddddk"),$crypt->pubkey);
    }
    public static function KeyExchange(){
        $FingerPrint = Config::find(1)->fingerprint;
        //$ClientKey=base64_decode(Session::get('public_key'));
        $ClientKey = "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC3i7cWdz0kyZErgIUKenRgX1C0
3LPuHIXl1dguXAiZSo7Kzfb/KTkEouyUcu1AKf8pGQLCKADMaBkXcoLOQ+fTSGe5
JpHQjeDyQCxewzIZbXy1XZtpzotBr6TTLKA1sdn9RDZviV/jTGNpJ9P+1r4+cWwd
EJNKQ8CMu2MFQd5T5QIDAQAB
-----END PUBLIC KEY-----";
        echo $ClientKey;
        $crypt = new mycrypt();
        $FingerPrintObj=new FingerPrintResponse();
        $FingerPrintObj->fingerprint = $FingerPrint;
        Session::put('step','config');
        $res = $crypt->encrypt(json_encode($FingerPrintObj),$ClientKey);
        echo $res;
        return $res;
    }
    public static function PushConfig(){
        $EncryptedVerifyString=Input::get('verify');
        $crypt = new mycrypt();
        $VerifyString=$crypt->decrypt($EncryptedVerifyString);
        echo "1";
        $Configs=ConfigController::GetAllConfig();
        $result = new ConfigResponse();
        $result->verify = $VerifyString;
        $result->config = $Configs;
        Session::forget('step');
        Session::forget('public_key');

        $clientKey = base64_decode(Session::get('public_key'));
        echo $clientKey;
        return $crypt->encrypt(json_encode($result),$clientKey);
    }
    public static function Handle(){
        if(Session::has('step')){
            if(Session::get('step')=='config'){
                return RSAController::PushConfig();
            }else{
                $ClientKey=Input::get('key');
                Session::put('public_key',$ClientKey);
                return RSAController::KeyExchange();
            }
        }else{
            $ClientKey=Input::get('key');
            Session::put('public_key',$ClientKey);
            echo "<br />";
            echo Session::get('public_key');
            return RSAController::KeyExchange();
        }
    }
}
class mycrypt {

    public $pubkey;
    public $privkey;

    function __construct() {
        //$this->privkey = Config::find(1)->privatekey;
        //$this->pubkey = Config::find(1)->publickey;
        $this->pubkey="-----BEGIN PUBLIC KEY-----
MIGdMA0GCSqGSIb3DQEBAQUAA4GLADCBhwKBgQCMl6pWKShN+C53yQE0aQaXTzv9
kCbVWz2v/ZMhqg+4XvFwsSDDWHUQSc1/V0pCBPqNbZtBgc0hatHuMQTsBFpmRJ+n
Ny+iZGf1JAA/DfNFQWvFCGR3HLDoAjInZZNFLawWVaKQ9bRPAszhmxu47eazCx2M
pTq2bIXL3OLv/lMo6QIBAw==
-----END PUBLIC KEY-----
";
        $this->privkey="-----BEGIN RSA PRIVATE KEY-----
MIICWwIBAAKBgQCMl6pWKShN+C53yQE0aQaXTzv9kCbVWz2v/ZMhqg+4XvFwsSDD
WHUQSc1/V0pCBPqNbZtBgc0hatHuMQTsBFpmRJ+nNy+iZGf1JAA/DfNFQWvFCGR3
HLDoAjInZZNFLawWVaKQ9bRPAszhmxu47eazCx2MpTq2bIXL3OLv/lMo6QIBAwKB
gF26cY7GGt6ldE/bViLwrw+KJ/5gGeOSKR/+YhZxX9A/S6B2FdeQTgrb3lTk3CwD
UbOeZ4EBM2uci/QgrfKtkZh/36a/dP6XrJOD25oWJhIrw9wn7yzMmmnUQrHW1BuR
LiFw0BP7y+CztaJ2MHCqcQd2AztT9iejXqv+wSkXtVjjAkEA7NwPS8U4dLxlCQyo
UmjODYCOHkgYAEu+nzXXfeJoYp3+ljK5CjC0sCZWz78g1kyNGHWHJjFYoBwcesOd
a6GGBwJBAJf0Hcw67AwostUqL5pRW/JFbK41m+l9iqSYRSVys3FI5ZY3ufHRyUUW
FxoT7xfwmsGjLIEYIldbrWP9lO8hnY8CQQCd6Aoyg3r4fZiwsxrhmzQJAF6+2rqq
3Sm/eTpT7EWXE/8OzHtcIHh1buSKf2s5iF4QTloZdjsVaBL8gmjya66vAkBlTWky
0fKyxcyOHB+8Nj1MLkh0I71GU7HDEC4Y9yJLhe5kJSahNoYuDroRYp9lSxHWbMhW
EBbk58jtU7ifa75fAkEAnW7pRhj/a+EqCCBZykJJgDMlgHsYo71mXjaGQv9MLJ8d
eEhY+oyP9uzSr9+OcZR11oqPEEid/dT/oAwdPIfTZA==
-----END RSA PRIVATE KEY-----
";
    }

    public function encrypt($data,$clientKey) {
        //echo $this->pubkey;
        //var_dump(openssl_public_encrypt($data, $encrypted, $clientKey));
        if (openssl_public_encrypt(base64_encode($data), $encrypted, $this->pubkey)){
            $data = base64_encode($encrypted);
            //echo $encrypted."\r\n".$data;;
            //echo $data;
        }else{
            //$data = base64_encode($encrypted);
            return 'Unable to encrypt data. Perhaps it is bigger than the key size?';
        }
         return $data;
    }

    public function decrypt($data) {
        if (openssl_private_decrypt(base64_decode($data), $decrypted, $this->privkey))
            $data = $decrypted;
        else
            $data = '';
        return $data;
    }
}
class FingerPrintResponse {
    public $fingerprint;
    public $serverpublickey;
    public function __construct(){
        $this->ServerPublicKey = Config::find(1)->publickey;
    }
}
class ConfigResponse {
    public $config;
    public $verify;
}
