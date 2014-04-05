
<div id="application" class="row content tab-pane">
  <div class="col-md-12 col-sm-12">
    <div class="panel panel-info">
      <div class="panel-heading">學生身份認證</div>
      <div class="panel-body">
        <p>
          許多應用程式需要您有學生身份才願意給您使用，包括學權申訴系統、海報欄位系統等等，認證一個學生身份會讓您擁有更多權益。=)
        </p>
        <p class="text-right">
          @if (in_array('STUDENT', Session::get('user_being.authority') ) === false)
            <a href="{{action('StudentController@apply_email')}}">
              <button type="button" class="btn btn-primary">申請學生身份認證</button>
            </a>
          @else
            <button type="button" class="btn btn-success" disabled="disabled">您已經認證成功了！</button>
          @endif

        </p>
      </div>
    </div>
    <div class="panel panel-info">
      <div class="panel-heading">群組申請與加入</div>
      <div class="panel-body">
        <p>
          這是伊爾特系統的核心之一，但還未從原本的架構移植過來。敬請期待。
        </p>
        <p class="text-right">
          <button type="button" class="btn btn-primary" disabled="disabled">建立群組（未開放）</button>
          <button type="button" class="btn btn-primary" disabled="disabled">加入群組（未開放）</button>
        </p>
      </div>
    </div>
    <div class="panel panel-info">
      <div class="panel-heading">應用程式開發申請</div>
      <div class="panel-body">
        <p>
          想要編寫一個讓全校學生都使用的應用程式嗎？想要利用資訊的力量讓興大校園的更加便利與流通嗎？只要到這裡申請專案，就可以拿到一組API Key，讓你不用再建立會員系統，利用伊爾特幫你認證！不但可以知道該使用者是不是在這裡註冊過，還可以知道他是不是擁有學生身份，如果使用者允許，你甚至可以經過他們同意後像伊爾特拿取使用者儲存的資料，快速幫使用者上手你的應用程式，增加使用體驗哦！
        </p>
        <p class="text-right">
          @if (in_array('DEVELOPER', Session::get('user_being.authority') ) === true)
            <a href="{{action('DeveloperController@index')}}">
              <button type="button" class="btn btn-success">您已經是開發者了，前往開發專區</button>
            </a>
          @else
            <a href="{{action('UserController@apply_developer')}}">
              <button type="button" class="btn btn-primary">成為開發者</button>
            </a>
          @endif

        </p>
      </div>
    </div>

  </div>
</div>