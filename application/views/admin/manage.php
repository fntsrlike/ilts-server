<h2>管理群</h2>

<div>
  <h3>新增</h3>
  <form id="createForm" class="form-inline" role="form" method="post" action="<?php echo $action['create'];?>">
    <div class="form-group" >
      <label class="sr-only" for="Name">Name</label>
      <input type="text" name="name" class="form-control" id="Name" placeholder="Name"/>
    </div>
    <div class="form-group" >
      <label class="sr-only" for="Comment">Comment</label>
      <input type="text" name="comment" class="form-control" id="Comment" placeholder="Comment"/>
    </div>
    <input type="submit" value="Create"  class="btn btn-default">
    <div class="form-group" id="createMsg">

    </div>
  </form>
</div>

<h3>清單</h3>
<form id="loadList" action="<?php echo $action['list'];?>"></form>
<table id="listTable" class="table">
    <thead>
        <tr>
            <td>序號</td>
            <td>使用者名稱</td>
            <td>註解</td>
            <td>管理</td>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<script src="assets/admin_manage.js"></script>