<?php namespace App\Http\Controllers;

use App\Config;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SSServer;
use Illuminate\Http\Request;

class ServerController extends Controller {

    public static function GetServerList(){
        $ServerObj = SSServer::all();
        $ServerArray = array();
        $i = 0;
        foreach($ServerObj as $Server){
            $ServerArray[$i]=$Server;
            $i++;
        }
        return $ServerArray;
    }
    public static function DelServer($ServerID){
        $Server = SSServer::find($ServerID);
        if($Server==null){return true;}
        SSServer::destroy($ServerID);
        $Server = SSServer::find($ServerID);
        if($Server==null){return true;}else{return false;}
    }
    public static function AddServerEx($ServerArray){
        $Server = new SSServer();
        $Server->host=$ServerArray['host'];
        $Server->port=$ServerArray['port'];
        $Server->method=$ServerArray['method'];
        $Server->passwd=$ServerArray['passwd'];
        $Server->comment=$ServerArray['comment'];
        $Server->save();
        return $Server->id;
    }
    public static function GeneratePanelTdServer($ServerID){
        $Server = SSServer::find($ServerID);
        if($Server==null){return null;}
        //$HrefEdit=sprintf("<a href=\"/Panel?action=EditServer&ServerID=%s\">编辑</a>",$Server->id);
        $HrefDel=sprintf("<a href=\"/panel?action=DelServer&ServerID=%s\">删除</a>",$Server->id);
        $result = sprintf("
                        <tr>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                        </tr>",$Server->id,$Server->host,$Server->port,$Server->method,$Server->passwd,$Server->comment,$HrefDel);
        return $result;
    }
    public static function GeneratePanelServerList(){
        $ServerCollection = SSServer::all();
        $String = "";
        foreach($ServerCollection as $Server){
            $String=$String.ServerController::GeneratePanelTdServer($Server->id);
        }
        return $String;
    }
    public static function AddServer(){
        $Server = new SSServer();

        if(\Illuminate\Support\Facades\Request::get('server_host')==""){
            return false;
        }
        $Server->host = \Illuminate\Support\Facades\Request::get('server_host');
        if((is_numeric(\Illuminate\Support\Facades\Request::get('server_port'))==false)||(\Illuminate\Support\Facades\Request::get('server_port')=="")){
            return false;
        }
        $Server->port = \Illuminate\Support\Facades\Request::get('server_port');
        if(\Illuminate\Support\Facades\Request::get('server_method')==""){
            return false;
        }
        $Server->method = \Illuminate\Support\Facades\Request::get('server_method');
        if(\Illuminate\Support\Facades\Request::get('server_passwd')==""){
            return false;
        }
        $Server->passwd=\Illuminate\Support\Facades\Request::get('server_passwd');
        $Server->comment=\Illuminate\Support\Facades\Request::get('server_comment');
        $Server->save();
        return $Server->save();
    }
    public  static function ChnageName(){
        $Config = Config::find(1);
        if(\Illuminate\Support\Facades\Request::get('provider_name')==""){
            return false;
        }
        $Config->friendlyname = \Illuminate\Support\Facades\Request::get('provider_name');
        return true;
    }
}
