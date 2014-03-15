
<div id="user_info" class="row content tab-pane active">
  <div class="col-md-12 col-sm-12">
    <h4>
      基本資料
      <small>
        <a href="#" data-toggle="modal" data-target="#user_info_modify">[Edit]</a>
      </small>
    </h4>
    <ul class="list-unstyled">
      <li>ＩＤ：{{$user->u_username}}</li>
      <li>暱稱：{{$user->u_nick}}</li>
      <li>信箱：{{$user->u_email}}</li>
      <li>權限：{{$user->u_authority}}</li>
    </ul>
    -
    <h4>
      個人資料
      <small>
        <a href="#" data-toggle="modal" data-target="#personal_info_modify">[Edit]</a>
      </small>
    </h4>
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

<div class="modal fade" id="user_info_modify" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="form-horizontal" role="form">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">使用者資料修改</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">ＩＤ</label>
            <div class="col-sm-10">
              <p class="form-control-static">email@example.com</p>
            </div>
          </div>
          {{Form::bs_text('暱稱', 'nickname', 'iNick', 'nickname')}}
          {{Form::bs_text('信箱', 'email', 'iEmail', 'email')}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div><!-- /.modal-content -->
    </form>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<div class="modal fade" id="personal_info_modify" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="form-horizontal" role="form">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">個人資料修改</h4>
        </div>
        <div class="modal-body">
          {{Form::bs_text('姓', 'lastname', 'iLastName', '趙')}}
          {{Form::bs_text('名', 'firstname', 'iFirstName', '錢孫')}}
          {{Form::bs_text('性別', 'gender', 'iGender', 'Radio')}}
          <select class="form-control">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
          </select>
          {{Form::bs_text('生日', 'birthday', 'iBirthday', 'yyyy/mm/dd')}}
          {{Form::bs_text('電話', 'phone', 'iPhone', '0912-345678')}}
          {{Form::bs_text('地址', 'address', 'iAddress', '12345 台中市南區250號')}}
          {{Form::bs_text('網站', 'site', 'iSite', 'http://foo.com')}}
          {{Form::bs_text('頭像', 'gravaster', 'iGravaster', 'foo@bar.com')}}
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">敘述</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" id="iDescribe" name="describe" placeholder="Email">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div><!-- /.modal-content -->
    </form>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
