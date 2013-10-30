
  $(".update_organ").click(function(){
    var oid = $(this).attr("oid");
    
    $.getJSON('/organization/get_files/'+oid, function( data ) {
      $('#manageName').html(data['oName']);
      $('#updateOrgIdDisplay').html(data['oId']);
      $('#updateOrgId').attr('value', data['oId']);
      $('#updateOrgName').attr('value', data['oName']);
      $('#updateOrgParentId').attr('value', data['oParentId']);
      $('#updateOrgSort').attr('value', data['oSortNumber']);
    }); 
    
  });


  // Attach a submit handler to the form
  $("#deleteBtn").click(function() {
   
    // Get some values from elements on the page:
    var form  = $( "#updateForm" );
    var id    = form.find( "input[name='id']" ).val();
    var url   = "/organization/del_process";
   
    var data = {
        "id"    :id
      };

    // Send the data using post
    $.post( 
      url, 
      data,
      function() {
        $(".tree").load('/organization/tree', function(){$.getScript("/assests/organ_manage_reload.js");});
      }
    ); 

    $('#updateMenu').modal('hide');

  });  