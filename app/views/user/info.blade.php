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
            <li><a href="#">開發者介面</a></li>
            <li><a href="#">管理者介面</a></li>
            <li><a href="#">群組介面</a></li>
          </ul>
        </li>
        <!-- <li><a href="#">系統管理</a></li> -->

      </ul>
    </div>
  </div>
  <div class="tab-content">
    <div id="user_info" class="row content tab-pane active">
      <div class="col-md-12 col-sm-12">
        <h4>基本資料 <small><a href="#">[Edit]</a></small></h4>
        <ul class="list-unstyled">
          <li>ＩＤ：{{$user->u_username}}</li>
          <li>暱稱：{{$user->u_nick}}</li>
          <li>信箱：{{$user->u_email}}</li>
          <li>權限：{{$user->u_authority}}</li>
        </ul>
        -
        <h4>個人資料 <small><a href="#">[Edit]</a></small></h4>
        <ul class="list-unstyled">
          <li>姓名：{{$user_option->u_last_name}}{{$user_option->u_first_name}}</li>
          <li>性別：{{$user_option->u_gender}}</li>
          <li>生日：{{$user_option->u_birthday}}</li>
          <li>電話：{{$user_option->u_phone}}</li>
          <li>地址：{{$user_option->u_address}}</li>
          <li>網站：{{$user_option->u_website}}</li>
          <li>頭像：{{$user_option->u_gravatar}}</li>
          <li>敘述：{{$user_option->u_description}}</li>
        </ul>

      </div>
    </div>
    <div id="auth_manage" class="row content tab-pane">
      <div class="col-md-12 col-sm-12">
        <div>
          <h4>目前狀態</h4>
          <ul class="list-unstyled">
            <li>本次登入從：{{$provider}}</li>
            <li>使用者狀態：{{$user->u_status}}</li>
          </ul>
        </div>
        -
        <div>
          <h4>Portal認證</h4>
          <ul class="list-unstyled">
            <li>Google：<span class="text-success">已通過</span></li>
            <li>Facebook：<span class="text-muted">尚未認證</span></li>
          </ul>
        </div>
        -
        <div>
          <h4>權限認證</h4>
          <ul class="list-unstyled">
            <li>註冊會員：<span class="text-success">已通過</span></li>
            <li>信箱認證：<span class="text-primary">進行中</span></li>
            <li>學生認證：<span class="text-muted">尚未認證</span></li>
          </ul>
        </div>
        -
        <div>
          <h4>應用程式認證</h4>
          <ul class="list-unstyled">
            <li>海報欄位申請系統：<span class="text-success">已認證</span></li>
            <li>學權申訴系統：<span class="text-warning">認證過期</span></li>
          </ul>
        </div>
      </div>
    </div>
    <div id="about" class="row content tab-pane">
      <div class="col-md-12 col-sm-12">
        <h4>關於伊爾特系統</h4>
        <p>
          伊爾特系統（Ilt System），是透過使用者清單（List of User）、群組關係樹（Tree of Group Relationship）、辨識標籤（Identity Tag）組成的會員管理系統，取這三元素的頭字母為I-L-T，所以稱為伊爾特（Ilt）。
        </p>
        <p>
          本頁主要是解釋使用原理，詳細概念說明可以參照<a href="#">專案連結</a>。
        </p>
        --
        <h4>關於Portal</h4>
        <p>
          個小子，向善外風見見學別本研金隨乎資通持了到為的景上哥成天讓信那傳坡客苦層路皮當一無死。不金說飯片寫地術出看經親化……局來服使我地那世間國營小好夫從！爭管起，裡兩時麼因卻神。星系須計死之只力近什不又得是相天世廣我營取點世是天藝合。
        </p>
        --
        <h4>關於使用者認證</h4>
        <p>
          法助表種能福吃加受小兒感師到說。讀造的，升能因什術動病？告銷們的夫時格地力年燈通小畫了只：就間管到禮戰西而……和是近開了為成及人春片氣都、金來提人次滿又只過面是精門技。父發的那。的會冷細園車常來實走水參商的面假中員？會思以生般青過人話初消深了北他單上這非變士？
        </p>
        --
        <h4>關於應用程式認證</h4>
        <p>
          業人國險上今看個：只濟縣等都個書看、器寶物過求在，年路是許天開有邊業發？質前趣我小大，國野家優苦線如我是人聽生星生，報出廣不感活失的的冷：兒著應：民只樣家之給總未跟美大多重我講童野專更一？走我大有國資件完是，文好子能千不灣工體信，不親石笑。過告命字女可演何有趣集居年。
        </p>
      </div>
    </div>
    <div id="application" class="row content tab-pane">
      <div class="col-md-12 col-sm-12">
        <h4>應用程式開發申請</h4>
        <p>
          布所市我各意自商治相的直演人廣如營一會許錢，馬必由不極說上車難子。
        </p>
        <p>
          健型心能海條先？子高會不升們總景表反路話在以灣常樹部時清如一阿每以格趣們營語多因軍果還須；國著制子人體。合這會希看見在灣相在能一思就們是情賣錢引。品人他，師著不的、星施心勢背藝。陽傳家這告，是適而代帶！比女清車只產的居差前因發再商他城又真環財的，議李保冷我共中住看裡法頭藥土活客非實我易漸。
        </p>
        <p>
          以會治不營之中再成備有呢收一都一點考他節心企：河大水多，識然曾，帶水一感色致種，型如總論望自我張一了就本少所？日得觀歡研車起可的程能有傷己看中麼、簡小爭；也等所馬一車友機樣言美麼告人，個對分口數微力流口於的，清我一不學一。量感車岸到臺，作了少分具單減同結飯他麼、興歡經自，寫個益口聲果以素不值創喜戲相高服身舉電能品高冷加阿化成了要壓成完。
        </p>
        <p class="text-center">
          <button type="button" class="btn btn-primary">成為開發者</button>
        </p>

        --
        <h4>群組申請與加入</h4>
        <p>
          為與也向回什在比子黃論深則兒：創角清團意們門基人裡能讀什告下藝題合家，少如女毛關消中小代升傳念家一造好了策推公切平第研來系算：在理了年主電現的條不病模……好頭話量手起了事。出了之友能拿地地是間到活界國，出對就果縣？程之成不性巴不：發面而業復子快經母性有然跑果以立經間聞球院會小木投爾官大觀城帶一世木生。
        </p>
        <p>
          議之可研同星層子密東高眼相氣無般每現明我物回素久、期頭為當這，們人食且考在義個之，者金廣電十。入間內特麗境活會：了香分生產中公當品照人，朋權經，人心人算，頭更景要今們國來在強，團熱行花然過識母求少，屋裝哥表預型時道不！兒心進目我國已一示決著數：息錯家通來空我朋來道直方分建冷道性想養青中面一銀？力縣在家兒不中當來歷形時風說布子臺高送間家教國傳手也小經而。
        </p>
        <p class="text-center">
          <button type="button" class="btn btn-primary">建立群組</button>
          <button type="button" class="btn btn-primary">加入群組</button>
        </p>
      </div>
    </div>
  </div>
</div>

@stop