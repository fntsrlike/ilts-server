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
      <h2 class="text-center">Developers</h2>
    </div>
  </div>
  {{ Form::model($client, array('action' => array('API_ClientController@update', $client->client_id), 'method' => 'put')) }}
    <div class="container block">
      <h3 class="text-center">Client API Edit</h3>
      <div class="row">
        <div class="col-md-12 col-sm-12">
          <div class="form-group text-danger">
            {{ HTML::ul($errors->all())}}
          </div>
          <div class="form-group">
            {{ Form::label('from_uri', '應用程式來源頁面 白名單（For JavaScript）') }}
            {{ Form::textarea('from_uri', Input::old('from_uri'), array('class' => 'form-control', 'placeholder' => '若您是使用JavaScript索取資料，請輸入主機位址白名單，以增加安全性，避免資料外洩。若是多組位址，請以斷行分別。')) }}
          </div>
          <div class="form-group">
            {{ Form::label('redirect_uri', '應用程式轉向頁面 白名單') }}
            {{ Form::textarea('redirect_uri', Input::old('redirect_uri'), array('class' => 'form-control', 'placeholder' => '讓我們知道哪些轉向頁面是合法的，避免有心人士竊取使用者的資料。若是多組位址，請以斷行分別。')) }}
          </div>
          <div class="form-group">

            <button type="submit" class="btn btn-default pull-right">編輯</button>
          </div>
        </div>
      </div>
    </div>
  {{ Form::close() }}
  <div></div>
@stop