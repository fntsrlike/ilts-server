@extends('master')


@section('head_css')
  @parent
<style type="text/css">
  .block {
    width: 960px;
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
      <h1 class="text-center">伊爾特管理者專區</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <ul class="nav nav-justified nav-pills">
        <li><a href="##pane_about" data-toggle="tab">關於</a></li>
        <li class="active"><a href="#pane_info" data-toggle="tab">資訊</a></li>
        <li><a href="#pane_system_manager" data-toggle="tab">系統</a></li>
        <li><a href="#pane_user_manager" data-toggle="tab">使用者</a></li>
        <li><a href="#pane_developer_manager" data-toggle="tab">開發者</a></li>
        <li><a href="#pane_admin_manager" data-toggle="tab">管理者</a></li>
        <li><a href="#pane_group_manager" data-toggle="tab">群組</a></li>
        <li><a href="#pane_identity_manager" data-toggle="tab">權限</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            登出、切換 <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="{{action('PortalController@logout')}}">登出</a></li>

            <li>
              <a href="{{action('UserController@index')}}">
                使用者介面
              </a>
            </li>
            <li><a href="{{action('DeveloperController@index')}}">開發者介面</a></li>
            <li><a href="#">群組介面</a></li>
          </ul>
        </li>
        <!-- <li><a href="#">系統管理</a></li> -->

      </ul>
    </div>
  </div>
  <div class="tab-content">
    @include('admin.pane_about')
    @include('admin.pane_info')
    @include('admin.pane_system_manager')
    @include('admin.pane_user_manager')
    @include('admin.pane_developer_manager')
    @include('admin.pane_admin_manager')
    @include('admin.pane_group_manager')
    @include('admin.pane_identity_manager')
  </div>
</div>

@stop