<div id="projects" class="row content tab-pane">

  <div class="col-md-12 col-sm-12">
    <div class="row">
      <div id="project-list" class="col-md-12 col-sm-12">
        <div style="margin-bottom: 20px;">
          <a href="{{url('v1/res/projects/create', $parameters = array(), $secure = null)}}">
            <button class="btn btn-primary btn-sm">
              Create New Project
            </button>
          </a>
        </div>
        <table class="table" id="projects_table">
          <thead>
            <td>序號</td>
            <td>名稱</td>
            <td>操作</td>
            <td>創建日期</td>
          </thead>
          <tbody id="project_list_tbody">
          </tbody>
        </table>
      </div>
      <div id="project-clients" class="col-md-12 col-sm-12 hide">
        <div style="margin-bottom: 20px;">
          <a href="#projects" id="return_project_list">〈 返回列表</a>
        </div>

        <div style="margin-bottom: 20px;">
          <h4>Project: <span id="project_name"></span></h4>
        </div>

        <div style="margin-bottom: 20px;">
          <a href="#">
            <button id="create_client_btn" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createClientModal" for="">
              Create New Client
            </button>
          </a>
        </div>

        <div id="clients_table">

        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="createClientModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      {{ Form::open(array('action' => 'API_ClientController@store')) }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Create Client ID</h4>
        </div>
        <div class="modal-body">
          <div class="form-group text-danger">
            {{ HTML::ul($errors->all()) }}
          </div>
          <div class="form-group">
            {{ Form::label('input_from_uri', 'Authorized JavaScript origins') }}
            {{ Form::textarea('input_from_uri', Input::old('input_from_uri'), array('class' => 'form-control', 'placeholder' => '若您是使用JavaScript索取資料，請輸入主機位址白名單，以增加安全性，避免資料外洩。若是多組位址，請以斷行分別。')) }}
          </div>
          <div class="form-group">
            {{ Form::label('input_redirect_uri', 'Authorized redirect URI') }}
            {{ Form::textarea('input_redirect_uri', Input::old('input_redirect_uri'), array('class' => 'form-control', 'placeholder' => '讓我們知道哪些轉向頁面是合法的，避免有心人士竊取使用者的資料。若是多組位址，請以斷行分別。')) }}
          </div>
        </div>
        <div class="modal-footer">
          {{ Form::token() }}
          <input type="hidden" id="create_client_project_id" name="project_id" />
          <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
          <button type="submit" class="btn btn-primary">申請</button>
        </div>
        {{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->