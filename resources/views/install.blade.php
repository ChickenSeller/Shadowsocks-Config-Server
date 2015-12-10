@extends('base')
@section('content')
    <div style="margin-top: 20px">

        <div style="width: 500px;margin-left: auto;margin-right: auto;" class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">安装</h3>
                </div>
                <div class="panel-body">
                    {!! Form::open() !!}
                    <div class="form-group">
                        {!! Form::label('username', '管理员用户名') !!}
                        {!! Form::text('username','',array('class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('passwd', '管理员密码') !!}
                        {!! Form::password('passwd',array('class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('servername', '服务器对外名称(以后可修改)') !!}
                        {!! Form::text('servername','',array('class' => 'form-control')) !!}
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
@stop