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
  <div class="container block">
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="alert alert-success">
          <h4>成功認證學生身份！</h4>
          <p>
            親愛的使用者您好，您已經成功認證學生身份。<br />
            請盡情享受學生身份使用者的相關權益。=D
          </p>
          <p>
            {{link_to_action('UserController@index', '>>返回 使用者面板')}}
          </p>
        </div>
      </div>
    </div>
  </div>
@stop