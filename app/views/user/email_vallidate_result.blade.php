@extends('master')


@section('head_css')
  @parent
  <style type="text/css">
    h3 {
      text-align: center;
    }
  </style>
@stop

@section('footer_scripts')
  @parent
@stop

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <h1 class="text-center">伊爾特信箱驗證程序</h1>
    </div>
  </div>
  <div class="row" style="margin-top: 50px;">
    <div class="col-md-12 col-sm-12">
      @if ($status === 'not_found')
        <div class="alert alert-warning">
          <h3>本驗證網址無效，請重新申請寄發驗證信件！</h3>
        </div>
      @elseif ($status === 'not_match')
        <div class="alert alert-danger">
          <h3>本驗證網址與您的使用者身份不符，請確認當前身份是否正確。</h3>
        </div>
      @elseif ($status === 'already')
        <div class="alert alert-warning">
          <h3>您的使用者身份已經驗證過了。</h3>
        </div>
      @elseif ($status === 'success')
        <div class="alert alert-success">
          <h3>驗證成功！</h3>
        </div>
      @endif
    </div>
  </div>
</div>
@stop