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