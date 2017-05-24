<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SSServer;
use Illuminate\Http\Request;

class ConfigController extends Controller {

	public static function GetConfig($serverlist = array()){
        $Configs = array();
        for($i=0;$i<$serverlist;$i++){
            $server = SSServer::find($serverlist[$i]);
            $config=new ServerConfig();
            $config->method = $server->method;
            $config->server = $server->host;
            $config->password =$server->passwd;
            $config->remarks = $server->comment;
            $config->server_port =$server->port;
            $Configs[$i]=$config;
        }
        return $Configs;
    }
    public static function GetAllConfig(){
        $Configs = array();
        $i = 0;
        $Servers = SSServer::all();
        foreach($Servers as $server ){
            $config=new ServerConfig();
            $config->method = $server->method;
            $config->server = $server->host;
            $config->password =$server->passwd;
            $config->remarks = $server->comment;
            $config->server_port =$server->port;
            $Configs[$i]=$config;
            $i++;
        }
        //echo $Configs;
        return $Configs;
    }
    
    public static function GetSSvipConfig($token){
        $SSVip = "https://beta.ssvip.lol/api/beta/server_get_node";
        $Key = "7a5ff735f1da46849e9f654b9f030fec";
        $Url = $SSVip.'?key='.$Key.'&token='.$token;
        $Json = file_get_contents($Url);
        $JsonObj = json_decode($Json);
        $Configs = array();
        $i = 0;
        foreach ($JsonObj->data as $server){
            $config=new ServerConfig();
            $config->method = $server->method;
            $config->server = $server->server;
            $config->password =$server->password;
            $config->remarks = $server->remarks;
            $config->server_port =$server->server_port;
            $Configs[$i]=$config;
            $i++;
        }
        return $Configs;
    }

}
class ServerConfig{
    public $server;
    public $server_port;
    public $password;
    public $method;
    public $remarks;
}
