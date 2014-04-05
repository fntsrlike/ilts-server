@extends('master')

@section('head_css')
  @parent
  <style type="text/css">
  .block {
    width: 700px;
    background-color: rgba(244, 248, 240, 1);
    padding: 15px;
    border: 1px solid #e5e5e5;
    -webkit-border-radius: 15px;
    -moz-border-radius: 15px;
    border-radius: 15px;
    -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
    -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
    box-shadow: 0 1px 2px rgba(0,0,0,.05);
  }

  textarea.form-control {
    height:100px;
  }
  </style>
@stop

@section('content')
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <h1 class="text-center">伊爾特系統</h1>
      <h2 class="text-center">Students Application</h2>
    </div>
  </div>
  {{ Form::open(array('action' => 'StudentController@apply_email_process')) }}
    <div class="container block">
      <h3 class="text-center">Project Application</h3>
      <div class="row">
        <div class="col-md-12 col-sm-12">
          <div class="form-group text-danger">
            {{ HTML::ul($errors->all()) }}
          </div>
          <div class="form-group">
            {{ Form::label('email', '學校信箱') }}
            {{ Form::text('email', Input::old('mail'), array('class' => 'form-control', 'placeholder' => 'xxx@mail.xxx.edu.tw')) }}
          </div>
          <div class="form-group">
            {{ Form::token() }}
            <button type="submit" class="btn btn-default pull-right">申請</button>
          </div>
        </div>
      </div>
    </div>
  {{ Form::close() }}
  <div></div>
@stop