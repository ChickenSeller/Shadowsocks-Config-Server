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

}
class ServerConfig{
    public $server;
    public $server_port;
    public $password;
    public $method;
    public $remarks;
}
