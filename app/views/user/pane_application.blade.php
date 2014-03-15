
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