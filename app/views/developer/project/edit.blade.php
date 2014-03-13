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
  {{ Form::model($project, array('action' => array('API_ProjectController@update', $project->project_id), 'method' => 'put')) }}
    <div class="container block">
      <h3 class="text-center">Client API Key Application</h3>
      <div class="row">
        <div class="col-md-12 col-sm-12">
          <div class="form-group text-danger">
            {{ HTML::ul($errors->all())}}
          </div>
          <div class="form-group">
            {{ Form::label('name', '專案名稱') }}
            {{ Form::text('name', Input::old('name'), array('class' => 'form-control', 'placeholder' => '中、英文、數字、底線')) }}
          </div>
          <div class="form-group">
            {{ Form::label('describe', '專案敘述') }}
            {{ Form::textarea('describe', Input::old('describe'), array('class' => 'form-control', 'placeholder' => '200字以內敘述，讓使用者了解您的專案')) }}
          </div>
          <div class="form-group">
            {{ Form::label('email', '電子郵件') }}
            {{ Form::text('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => '')) }}
          </div>
          <div class="form-group">
            {{ Form::label('homepage_url', '官方網站網址') }}
            {{ Form::text('homepage_url', Input::old('homepage_url'), array('class' => 'form-control', 'placeholder' => '')) }}
          </div>
          <div class="form-group">
            {{ Form::label('logo_url', 'LOGO網址') }}
            {{ Form::text('logo_url', Input::old('logo_url'), array('class' => 'form-control', 'placeholder' => '')) }}
          </div>
          <div class="form-group">
            {{ Form::label('privacy_policy_url', '隱私政策網址') }}
            {{ Form::text('privacy_policy_url', Input::old('privacy_policy_url'), array('class' => 'form-control', 'placeholder' => '')) }}
          </div>
          <div class="form-group">
            {{ Form::label('terms_of_service_url', '服務條款網址') }}
            {{ Form::text('terms_of_service_url', Input::old('terms_of_service_url'), array('class' => 'form-control', 'placeholder' => '')) }}
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-default pull-right">申請</button>
          </div>
        </div>
      </div>
    </div>
  {{ Form::close() }}
  <div></div>
@stop