@extends('master')


@section('head_css')
  @parent
<style type="text/css">
  .block {
    width: 860px;
    background-color: rgba(244, 248, 240, 1);
    padding: 20px;
    border: 1px solid #e5e5e5;
    -webkit-border-radius: 15px;
    -moz-border-radius: 15px;
    border-radius: 15px;
    -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
    -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
    box-shadow: 0 1px 2px rgba(0,0,0,.05);
  }

  .content {
    padding-left: 5px;
    padding-top: 15px;
  }

  table {
    font-size: 14px;
  }

</style>
@stop

@section('footer_scripts')
  @parent

<script type="text/javascript">
$(function(){
  var hash = window.location.hash;
  hash && $('ul.nav a[href="' + hash + '"]').tab('show');

  $('.nav a').click(function (e) {
    $(this).tab('show');
    var scrollmem = $('body').scrollTop();
    window.location.hash = this.hash;
    $('html,body').scrollTop(scrollmem);
  });

  console.log('test');
  console.log(typeof($));
});
</script>

@stop

@section('content')
<div class="container block">
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <h1 class="text-center">伊爾特使用者專區</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <ul class="nav nav-justified nav-pills">
        <li><a href="#about" data-toggle="tab">關於</a></li>
        <li class="active"><a href="#user_info" data-toggle="tab">使用者</a></li>
        <!-- <li><a href="#massages" data-toggle="tab">短訊（預計）</a></li> -->
        <li><a href="#auth_manage" data-toggle="tab">權限</a></li>
        <li><a href="#application" data-toggle="tab">申請</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            登出、切換 <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="{{action('PortalController@logout')}}">登出</a></li>

            <li>
              <a href="{{action('DeveloperController@index')}}">
                開發者介面
              </a>
            </li>
            <li><a href="#">管理者介面</a></li>
            <li><a href="#">群組介面</a></li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
  <div class="tab-content">
  @include('user.pane_about')
  @include('user.pane_application')
  @include('user.pane_auth')
  @include('user.pane_info')
  </div>
</div>

@stop