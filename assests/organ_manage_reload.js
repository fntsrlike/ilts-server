
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


