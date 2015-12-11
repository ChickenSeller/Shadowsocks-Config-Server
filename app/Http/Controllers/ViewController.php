<?php namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


class ViewController extends Controller {

    public static function PanelView($Section=""){
        return view('panel')->with(['ItemList'=>ServerController::GeneratePanelServerList(),'Section'=>$Section,'Script'=>'']);
    }
    public static function DelServerView($ServerID){
        ServerController::DelServer($ServerID);
        return view('panel')->with(['ItemList'=>ServerController::GeneratePanelServerList(),'Section'=>'','Script'=>'']);
    }
    public static function RstPasswdView(){
        $res = AuthController::RstPasswd(Session::get('username'),\Illuminate\Support\Facades\Request::get('oldpasswd'),\Illuminate\Support\Facades\Request::get('newpasswd'));
        if($res==true){
            $Script = "<script>alert(\"密码修改成功\");</script>";
            return view('panel')->with(['ItemList'=>ServerController::GeneratePanelServerList(),'Section'=>'Passwd','Script'=>$Script]);
        }else{
            $Script = "<script>alert(\"密码修改失败\");</script>";
            return view('panel')->with(['ItemList'=>ServerController::GeneratePanelServerList(),'Section'=>'Passwd','Script'=>$Script]);
        }
    }
    public static function AddServerView(){
        $res = ServerController::AddServer();
        if($res==false){
            $Script = "<script>alert(\"服务器添加失败\");</script>";
            return view('panel')->with(['ItemList'=>ServerController::GeneratePanelServerList(),'Section'=>'AddItem','Script'=>$Script]);
        }else{
            $Script = "<script>alert(\"服务器添加成功\");</script>";
            return view('panel')->with(['ItemList'=>ServerController::GeneratePanelServerList(),'Section'=>'AddItem','Script'=>$Script]);
        }
    }

}
