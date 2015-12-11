@extends('base')
@section('content')
    <div style="margin-top: 20px">

        <div style="width: 500px;margin-left: auto;margin-right: auto;" class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">登录</h3>
                </div>
                <div class="panel-body">
                    {!! Form::open(array('onsubmit' => 'return handlepasswd()')) !!}
                    <div class="form-group">
                        {!! Form::label('username', '用户名') !!}
                        {!! Form::text('username','',array('class' => 'form-control','id' => 'username')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('passwd', '密码') !!}
                        {!! Form::password('passwd',array('class' => 'form-control','id' => 'passwd')) !!}
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
@section('script')
    <script type="text/javascript" src="/js/jQuery.md5.js"></script>
    <script>
        function handlepasswd(){
            if($('#username').val()==""){
                alert("用户名不能为空！");
                return false;
            }
            if($('#passwd').val()==""){
                alert("密码不能为空！");
                return false;
            }
            var rawpasswd=$("#passwd").val();
            $("#passwd").val($.md5(rawpasswd));
            return true;
        }
    </script>
@stop
