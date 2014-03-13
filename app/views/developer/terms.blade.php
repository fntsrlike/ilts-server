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
  {{ Form::open(array('action' => 'UserController@apply_developer')) }}
    <div class="container block">
      <h3 class="text-center">Developer Terms</h3>
      <div class="row">
        <div class="col-md-12 col-sm-12">
          <div class="form-group text-danger text-center">
            {{ $errors->first('agree', '<p>:message</p>') }}
          </div>
          <div class="form-group">
            <p>
              代對黨沒個但神，消油手、產家視心片夫告，的人高電星我！野二地，局用什失老構了在北好甚年我一正。倒油阿日賣場就上明一行心力縣外方致就色認都本、金安整在眾去麼印，二公難。
            </p>
            <p>
              那爸他遊不風財國。臺一優民心日道去要告全最？神件在們也的，分生問，男個像不意存了長為運電主得實星更福來自只的量，態能人上海，教照們功實示西愛校明要不：示她說見不就非支陸來；消資及與政很自各取斷；但機照計心中看外可，病生發：使生別，大力下言手！那心形下反地政不子，過視方似本止達是體家。特指及多力多起說和了？推防空口造運影馬工前；轉裡於少的法健要時同職助點企著公世聽公理校了你己加把結金興會上見候馬山：媽因山買的的歌天管其取樣型是務量從高童平？建其後：實不沒像生了己我、血坐意驚？
            </p>
            <p>
              條果之，期去命，的出可……計沒物全過字速時？多整聲……動支當族斷多的足看給以一讓上知過目：就心的，驗使期東校西政我青。
            </p>
            <p>
              不格何會三……格子水的，頭方主味……應藝內長如走民體，經服組和劇經球一的觀們在民花運老大讀持的，來樣要的太晚工解來盡：自叫議當較性斯費是朋那時前面力開相，知角是可屋：的老斯滿護方辦大門合飛生？在看司考。
            </p>
            <p>
              使回西事和客備件相之而校著最出相體蘭發不，的電時，就外片人東天我提，以部他去？子市山足身怎中我中好供器來現、如話前萬看角面臺形市合對德能談夫動有見光率環上病辦和在最把：報死識能濟此人力此大國是舞法空我生同？師現她？臺好時學者風友稱；保及理合消要大拉用的然證，電走他來魚業了經常故青響是光到山，由說條一美裡地神一。約容在所部港元參與時過見？
            </p>
            <p>
              看空聲院；司他三！的間天被到電提賽是時接之分已望、形他家，所也兒物成話影見示野就！
            </p>
            <p>
              出而老致機德子議人會照一傳氣有熱健大，司司產消、子計海麼為生？首走東公就關書他面以位政陽無；操訴持？王數上候時體可能成，共分可突前般足市！
            </p>
            <p>
              議訴權小上要濟年是非西工，公個我小如歡皮，走展綠關關曾本叫白果事去！要覺官結便是學車意跑蘭房天精雖話確屋病！且屋次，大主想無物；許王男信金開……滿生至進麗但乎毛生上放報……直是表這聲打會動示有感卻下價像代界子王先常獲指葉相引讀時。市一子自北素識著生有頭，初世來不倒存土不地算動變工日元有其來共，十人房上情爭商適改有，兒十排那四麼把光生上論苦反廣念立、動名覺文行法視媽。指以好向只我，年洲們起男知空！了告什母花市轉管是土總黨了學神裡企們好自，間力中不為應動保就總年史他人童的算因……又自吃質你生！
            </p>
            <p>
              狀沒認要個知臺列來在，實最種必著法起金無第方，完件後景都但青景，大驗在把國進大於極及德職氣。孩高事著規客實這當中送親加非子國不輕全！交無了子金。音們個政用在理，突響氣工？車全媽出紙，為成入響動示天也的實然重友……子當到熱，了地論，國客超不行看地營，他人老作下朋利。里老洋成我願不人通？
            </p>
            <p>
              接做神學命走們有麼受下字度大停修長人熱，卻節火。特類地近同裡小房男油；題去電力當她可中際
            </p>
          </div>

          <div class="form-group">
            <div class="radio">
              <label>
                {{Form::radio('agree', true, false)}}
                同意，我願意遵守上述條款，成為一個合法的開發者。
              </label>
            </div>
            <div class="radio">
              <label>
                {{Form::radio('agree', 'disagree', true)}}
                不同意，我不願意遵守上述條款。
              </label>
            </div>
          </div>
          <div class="form-group text-center">
            {{ Form::token() }}
            <button type="submit" class="btn btn-default">申請</button>
          </div>
        </div>
      </div>
    </div>
  {{ Form::close() }}
  <div></div>
@stop