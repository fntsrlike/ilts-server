
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assests/tree.css');?>" />

<div>
  <h2>Create Organization</h2>
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

<div class="tree">
  <h2>Organization Tree</h2>
  <?php echo $tree;?>
</div>


<script>
  // Attach a submit handler to the form
  $("#createForm").submit(function( event ) {
   
    // Stop form from submitting normally
    event.preventDefault();
   
    // Get some values from elements on the page:
    var $form = $( this ),
      name    = $form.find( "input[name='name']" ).val(),
      parent  = $form.find( "input[name='parent']" ).val(),
      sort    = $form.find( "input[name='sort']" ).val(),
      url = $form.attr( "action" );
   
    var data = { 
        "name"  : name, 
        "parent":parent, 
        "sort"  :sort, 
      };
    // Send the data using post
    $.post( 
      url, 
      data,
      function() {
        $(".tree").load('<?php echo base_url("organization/tree");?>');
      }
    ); 
  });
</script>