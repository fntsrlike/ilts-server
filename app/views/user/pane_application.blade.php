
<div id="application" class="row content tab-pane">
  <div class="col-md-12 col-sm-12">
    <h4>應用程式開發申請</h4>
    <p>
      想要編寫一個讓全校學生都使用的應用程式嗎？想要利用資訊的力量讓興大校園的更加便利與流通嗎？只要到這裡申請專案，就可以拿到一組API Key，讓你不用再建立會員系統，利用伊爾特幫你認證！不但可以知道該使用者是不是在這裡註冊過，還可以知道他是不是擁有學生身份，如果使用者允許，你甚至可以經過他們同意後像伊爾特拿取使用者儲存的資料，快速幫使用者上手你的應用程式，增加使用體驗哦！
    </p>
    <p class="text-center">
      @if (in_array('DEVELOPER', Session::get('user_being.authority') ) == true)
        <a href="{{action('DeveloperController@index')}}">
          <button type="button" class="btn btn-primary">前往開發專區</button>
        </a>
      @else
        <a href="{{action('UserController@apply_developer')}}">
          <button type="button" class="btn btn-primary">成為開發者</button>
        </a>
      @endif

    </p>

    --
    <h4>群組申請與加入</h4>
    <p>
      本功能尚未開放。
    </p>
    <p class="text-center">
      <button type="button" class="btn btn-primary">建立群組</button>
      <button type="button" class="btn btn-primary">加入群組</button>
    </p>
  </div>
</div>