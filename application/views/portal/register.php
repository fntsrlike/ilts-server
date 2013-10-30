<div class="text-center" style="margin:100px auto; width:500px;">
  <h1>填寫會員資料</h1>
  <div style="margin-top:30px;">
  <form class="form-horizontal" role="form" action="<?php echo $form_action;?>" method="post">
    <div class="form-group">
      <label for="username" class="col-sm-3 control-label">User Name</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="username" name="username" placeholder="User Name  ">
      </div>
    </div>
    <div class="form-group">
      <div>
        <input type="hidden" name="value" value="<?php echo $provider_value;?>" />
        <button type="submit" class="btn btn-default">Sign in</button>
      </div>
    </div>
  </form>  
  </div>
</div>