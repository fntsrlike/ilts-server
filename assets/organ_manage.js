$(function(){

  organ = {};

  organ.run = function() {
    organ.listener_disposable();
    organ.listener_reuse();
  };

  organ.listener_disposable = function() {

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
        console.log(url);
      // Send the data using post
      $.post(
        url,
        data,
        function(data) {

          if (data.status == "success") {
            // Code..
          }
          else if (data.status == "failed") {
            // Code..
            console.log(data.err_msg);
          }
          else {
            // Code..
            console.log("Pass but Error");
          }

        },
        "json"
      )
      .done(function() {
        // Refresh
        $(".tree").load(base_url + 'organization/tree', function(){
          organ.listener_reuse();
        });

        console.log("Done.");
      })
      .fail(function() {
        // Code..
        console.log("Connect Failed");
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
          $(".tree").load(base_url + 'organization/tree', function(){
            organ.listener_reuse();
          });
        }
      );

      $('#updateMenu').modal('toggle');

    });

    // Attach a submit handler to the form
    $("#deleteBtn").click(function() {
      if (!confirm("您確定要刪除此欄位嗎？")) {
              return false;
      }

      // Get some values from elements on the page:
      var form  = $( "#updateForm" );
      var id    = form.find( "input[name='id']" ).val();
      var url   = base_url + "organization/del_process";

      var data = {
          "id"    :id
        };

      // Send the data using post
      $.post(
        url,
        data,
        function() {
          $(".tree").load(base_url + 'organization/tree', function(){
            organ.listener_reuse();
          });
        }
      );

      $('#updateMenu').modal('hide');

    });


    // Attach a submit handler to the form
    $("#identifyBtn").click(function() {

      // Get some values from elements on the page:
      var form  = $( "#updateForm" );
      var id    = form.find( "input[name='id']" ).val();
      var url   = base_url + "identify/manage/" + id;

      window.location.href= url; // 跳转到B目录
    });


  };

  organ.listener_reuse = function() {
    $(".update_organ").click(function(){
      var oid = $(this).attr("oid");

      $.getJSON( base_url + 'organization/get_files/'+ oid, function( data ) {
        $('#manageName').html(data['oName']);
        $('#updateOrgIdDisplay').html(data['oId']);
        $('#updateOrgId').attr('value', data['oId']);
        $('#updateOrgName').attr('value', data['oName']);
        $('#updateOrgParentId').attr('value', data['oParentId']);
        $('#updateOrgSort').attr('value', data['oSortNumber']);
      });

    });
  }

  organ.run();

});