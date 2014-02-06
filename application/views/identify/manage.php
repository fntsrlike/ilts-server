<h1> 組織權限管理：<?php echo "$organ ($oId)";?></h1>


<div style="margin:40px auto">
  <h3> 新增使用者權限 </h3>
  <form id="createForm" class="form-inline" role="form" method="post" action="<?php echo base_url('identify/put_process');?>">

    <div class="form-group" >
      <label class="sr-only" for="createIdentUser">User Name</label>
      <input type="text" name="name" class="form-control" id="createIdentUser" placeholder="User Name"/>
    </div>
    <div class="form-group" >
      <label class="sr-only" for="createIdentLevel">Identify Level</label>
      <input type="text" name="level" class="form-control" id="createIdentLevel" placeholder="Identify Level"/>
    </div>

    <input type="hidden" name="oId" value="<?php echo $oId;?>" />
    <input type="submit" value="Create"  class="btn btn-default">
  </form>
</div>

<h3> 現有權限清單 </h3>
<div id="table"></div>

<script type="text/javascript">

  $.getScript( base_url + '/assets/identify_manage.js');
</script>