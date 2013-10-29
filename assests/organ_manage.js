  // Attach a submit handler to the form
  $("#createForm").submit(function( event ) {
   
    // Stop form from submitting normally
    event.preventDefault();
   
    // Get some values from elements on the page:
    var form    = $( this );
    var name    = form.find( "input[name='name']" ).val();
    var parent  = form.find( "input[name='parent']" ).val();
    var sort    = form.find( "input[name='sort']" ).val();
    var url     = form.attr( "action" );
   
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
        $(".tree").load('/organization/tree', function(){$.getScript("/assests/organ_manage.js");});
      }
    ); 
  });

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
  $("#updateBtn").click(function() {
   
    // Get some values from elements on the page:
    var form = $( "#updateForm" );
    var id      = form.find( "input[name='id']" ).val();
    var name    = form.find( "input[name='name']" ).val();
    var parent  = form.find( "input[name='parent']" ).val();
    var sort    = form.find( "input[name='sort']" ).val();
    var url     = form.attr( "action" );
   
    var data = {
        "id"    :id,
        "name"  :name, 
        "parent":parent, 
        "sort"  :sort, 
      };

    // Send the data using post
    $.post( 
      url, 
      data,
      function() {
        $(".tree").load('/organization/tree', function(){$.getScript("/assests/organ_manage.js");});
      }
    ); 

    $('#updateMenu').modal('toggle');

  });  
