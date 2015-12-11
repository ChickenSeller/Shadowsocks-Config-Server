@extends('base')
@section('content')
    <div style="margin-top: 5px;width: 50%;margin-left: auto;margin-right: auto">
        <ul id="myTab" class="nav nav-pills">
            <li <?php if($Section==""||$Section=="Index"){echo "class=\"active\"";} ?>>
                <a href="#home" data-toggle="tab">
                    服务器列表
                </a>
            </li>
            <li <?php if($Section=="AddItem"){echo "class=\"active\"";} ?>>
                <a href="#additem" data-toggle="tab">
                    添加服务器
                </a>
            </li>

            <li style="float: right">
                <a href="/logout">登出</a>
            </li>
            <li style="float: right" <?php if($Section=="Passwd"){echo "class=\"active\"";} ?>>
                <a href="#changePasswd" data-toggle="tab">修改密码</a>
            </li>
            <li style="float: right" <?php if($Section=="ChangeName"){echo "class=\"active\"";} ?>>
                <a href="#changeName" data-toggle="tab">修改对外名称</a>
            </li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div style="margin-top: 10px" class="tab-pane fade <?php if($Section==""||$Section=="Index"){echo "in active";} ?>" id="home">
                <div>
                    <table  class="table table-bordered table-hover">
                        <th style="text-align: center">
                            ID
                        </th>
                        <th style="text-align: center">
                            服务器地址
                        </th>
                        <th style="text-align: center">
                            服务器端口
                        </th>
                        <th style="text-align: center">
                            加密方法
                        </th>
                        <th style="text-align: center">
                            连接密码
                        </th>
                        <th style="text-align: center">
                            服务器备注
                        </th>
                        <th style="text-align: center">
                            操作
                        </th>
                        {!! $ItemList !!}
                    </table>
                </div>
            </div>
            <div style="margin-top: 10px" class="tab-pane fade <?php if($Section=="AddItem"){echo "in active";} ?>" id="additem">
                <div style="margin-left: auto;margin-right: auto;width: 500px">
                <div class="panel panel-default">
                    <div class="panel-body">
                        {!! Form::open(['url' => '/panel?action=AddServer', 'method' => 'post','onsubmit' => 'return checkAddItem()']) !!}
                        <div class="form-group">
                            {!! Form::label('server_id', '服务器序号(选填)') !!}
                            {!! Form::text('server_id','',array('class' => 'form-control','id' => 'server_id')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('server_host', '服务器地址') !!}
                            {!! Form::text('server_host','',array('class' => 'form-control','id' => 'server_host')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('server_port', '服务器端口') !!}
                            {!! Form::text('server_port','',array('class' => 'form-control','id' => 'server_port')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('server_method', '加密方法') !!}
                            {!! Form::text('server_method','',array('class' => 'form-control','id' => 'server_method')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('server_passwd', '连接密码') !!}
                            {!! Form::text('server_passwd','',array('class' => 'form-control','id' => 'server_passwd')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('server_comment', '备注') !!}
                            {!! Form::text('server_comment','',array('class' => 'form-control','id' => 'server_comment')) !!}
                        </div>
                        <div class="form-group">
                            <div style="float:left;width: 50%;text-align: right;padding-right: 10px">
                                {!! Form::submit('添加',array('class' => 'btn btn-primary dropdown-toggle','style' => 'width:80%')) !!}
                            </div>
                            <div style="float:left;width: 50%;text-align: left;padding-left: 10px">
                                {!! Form::reset('重置',array('class' => 'btn btn-default dropdown-toggle','style' => 'width:80%')) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                </div>
            </div>
            <div style="margin-top: 10px" class="tab-pane fade <?php if($Section=="Passwd"){echo "in active";} ?>" id="changePasswd">
                <div style="margin-left: auto;margin-right: auto;width: 500px">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            {!! Form::open(['url' => '/panel?action=RstPasswd', 'method' => 'post','onsubmit' => 'return handlepasswd()']) !!}
                            <div class="form-group">
                                {!! Form::label('old_passwd', '原密码') !!}
                                {!! Form::password('old_passwd', ['class' => 'form-control','id' => 'old_passwd']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('new_passwd', '新密码') !!}
                                {!! Form::password('new_passwd', ['class' => 'form-control','id' => 'new_passwd']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('confirm_passwd', '确认新密码') !!}
                                {!! Form::password('confirm_passwd', ['class' => 'form-control','id' => 'confirm_passwd']) !!}
                            </div>
                            <div class="form-group">
                                <div style="float:left;width: 50%;text-align: right;padding-right: 10px">
                                    {!! Form::submit('确定',array('class' => 'btn btn-primary dropdown-toggle','style' => 'width:80%')) !!}
                                </div>
                                <div style="float:left;width: 50%;text-align: left;padding-left: 10px">
                                    {!! Form::reset('重置',array('class' => 'btn btn-default dropdown-toggle','style' => 'width:80%')) !!}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin-top: 10px" class="tab-pane fade <?php if($Section=="ChangeName"){echo "in active";} ?>" id="changeName">
                <div style="margin-left: auto;margin-right: auto;width: 500px">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            {!! Form::open(['url' => '/panel?action=ChangeName', 'method' => 'post','onsubmit' => 'return checkServerName()']) !!}
                            <div class="form-group">
                                {!! Form::label('provider_name', '对外显示的名称') !!}
                                {!! Form::text('provider_name','',array('class' => 'form-control','id' => 'provider_name')) !!}
                            </div>
                            <div class="form-group">
                                <div style="float:left;width: 50%;text-align: right;padding-right: 10px">
                                    {!! Form::submit('确定',array('class' => 'btn btn-primary dropdown-toggle','style' => 'width:80%')) !!}
                                </div>
                                <div style="float:left;width: 50%;text-align: left;padding-left: 10px">
                                    {!! Form::reset('重置',array('class' => 'btn btn-default dropdown-toggle','style' => 'width:80%')) !!}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop
@section('script')
    <script type="text/javascript" src="/js/jQuery.md5.js"></script>
    {!! $Script !!}
    <script>
        function checkAddItem(){
            if($('#server_host').val()==""){alert('服务器地址不能为空');return false;}
            if($('#server_port').val()==""){alert('服务器端口不能为空');return false;}
            if($('#server_method').val()==""){alert('加密方法不能为空');return false;}
            if($('#server_passwd').val()==""){alert('连接密码不能为空');return false;}
            return true;
        }
        function checkServerName(){
            if($('#provider_name').val()==""){alert('对外显示的名称不能为空');return false;}
            return true;
        }
        function handlepasswd(){
            if($('#old_passwd').val()==""){alert('原密码不能为空');return false;}
            if($('#new_passwd').val()==""){alert('新密码不能为空');return false;}
            if($('#new_passwd').val()!=$('#confirm_passwd').val()){alert('确认密码与新密码不相同');return false;}
            var rawpasswd=$("#old_passwd").val();
            $("#old_passwd").val($.md5(rawpasswd));
            var rawpasswd=$("#new_passwd").val();
            $("#new_passwd").val($.md5(rawpasswd));
            $('#confirm_passwd').val($('#new_passwd').val());
            return true;
        }

    </script>
    @stop

