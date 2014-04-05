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
    <h3 class="text-center">Project Application</h3>
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="alert alert-danger">
          <h4>您已經填寫過本表單了！</h4>
          親愛的使用者您好，您已經填寫過本表單了。請到您填寫的學校信箱接受確認信，已完成驗證程序。
          若是您尚未收到驗證信件，請聯絡系統管理員。
          <!--
            未來會新增重發確認信以及刪除資料重填的選項。
          -->
        </div>
      </div>
    </div>
  </div>
@stop