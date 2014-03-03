@extends('user.master')

@section('content')


<div class="container">
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <h1 class="text-center">伊爾特會員系統</h1>
      <h2 class="text-center">使用者頁面</h2>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 col-sm-12">
      使用者狀態：{{$user->status}}<br/>
      登入提供方：{{$user->provider}}<br/>
      登入辨識碼：{{$user->identifier}}<br/>
      使用者ＩＤ：{{$user->u_id}}<br/>
      使用者名稱：{{$user->username}}<br/>
      使用者權限：{{$user->authority}}<br/>
    </div>
  </div>
</div>
@stop