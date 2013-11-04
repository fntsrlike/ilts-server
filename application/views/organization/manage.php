
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assests/tree.css');?>" />
<h1>Organization 管理面板</h1>
<div>
  <h3>Create</h3>
  <form class="form-inline" role="form" action="<?php echo base_url('organization/put_process');?>" id="createForm">
    <div class="form-group" >
      <label class="sr-only" for="createOrgName">Organization Name</label>
      <input type="text" name="name" class="form-control" id="createOrgName" placeholder="Organization Name"/>
    </div>
    <div class="form-group" >
      <label class="sr-only" for="createOrgParentId">Organization Parent Id</label>    
      <input type="text" name="parent" class="form-control" id="createOrgParentId" placeholder="Parent Id"/>
    </div>  
    <div class="form-group" >
      <label class="sr-only" for="createOrgSort">Organization Sort Number</label>
      <input type="text" name="sort" class="form-control" id="createOrgSort" placeholder="Sort Number"/>
    </div>
    <input type="submit" value="Create"  class="btn btn-default">
  </form>
</div>

<div class="tree"></div>

<div class="modal fade" id="updateMenu">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Update <span id="manageName"></span></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" action="<?php echo base_url('organization/set_process');?>" id="updateForm">
          <div class="form-group" >
            <label class="col-sm-4 control-label" for="updateOrgName">Organization Id</label>
            <div class="col-sm-8">
              <p class="form-control-static" id="updateOrgIdDisplay"></p>
              <input type="hidden" name="id" class="form-control" id="updateOrgId" placeholder="Organization Id"/>
            </div>
          </div>          
          <div class="form-group" >
            <label class="col-sm-4 control-label" for="updateOrgName">Organization Name</label>
            <div class="col-sm-8">
              <input type="text" name="name" class="form-control" id="updateOrgName" placeholder="Organization Name"/>
            </div>
          </div>
          <div class="form-group" >
            <label class="col-sm-4 control-label" for="updateOrgParentId">Parent Id</label>    
            <div class="col-sm-8">
              <input type="text" name="parent" class="form-control" id="updateOrgParentId" placeholder="Parent Id"/>
            </div>
          </div>  
          <div class="form-group" >
            <label class="col-sm-4 control-label" for="updateOrgSort">Sort Number</label>
            <div class="col-sm-8">  
              <input type="text" name="sort" class="form-control" id="updateOrgSort" placeholder="Sort Number"/>
            </div>
          </div>
          <div class="form-group" >
            <label class="col-sm-4 control-label" for="Operator">Operator</label>
            <div class="col-sm-8">  
              <button type="button" class="btn btn-info btn-sm" id="identifyBtn">權限管理</button>
              <button type="button" class="btn btn-danger btn-sm" id="deleteBtn">Delete</button>
            </div>
          </div>          
          </form>
        
      </div>

      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="updateBtn">Update</button>
      </div>
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="<?php echo base_url("assests/organ_manage.js");?>"></script>
<script type="text/javascript">
  $(".tree").load('<?php echo base_url("/organization/tree");?>', function(){
    $.getScript("<?php echo base_url('/assests/organ_manage_reload.js');?>");
  });
</script>