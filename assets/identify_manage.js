$(function(){
  identify = {};

  identify.run = function(){
    identify.list_loader();
    identify.listener_disposable();
    identify.listener_reuse();
  };

  identify.list_loader = function(){
    var oid = $("#createForm").find( "input[name='oId']").val();
    var url = base_url + 'identify/organ_ident_list/'+oid;

    $("#table").load(url, function(){identify.listener_reuse();});
  };

  identify.listener_disposable = function(){

    // Attach a submit handler to the form
    $("#createForm").submit(function( event ) {

      // Stop form from submitting normally
      event.preventDefault();

      // Get some values from elements on the page:
      var form    = $( this );
      var name    = form.find( "input[name='name']" ).val();
      var level   = form.find( "input[name='level']" ).val();
      var oId     = form.find( "input[name='oId']" ).val();
      var url     = form.attr( "action" );
      var data = {
          "name"  : name,
          "oId" : oId,
          "level": level,
        };

      $.post(
        url,
        data,
        function(data) {

          if (data.status == "success") {
            // Code..
          }
          else if (data.status == "failed") {
            // Code..
            console.log('failed');
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
        $("#table").load(
          base_url + 'identify/organ_ident_list/'+ $("#createForm").find( "input[name='oId']").val(),
          function(){
            identify.listener_reuse();
          }
        );
        console.log("Done.");
      })
      .fail(function() {
        // Code..
        console.log(url);
        console.log("Connect Failed");
      });


    });
  };

  identify.listener_reuse = function(){
    $(".identRemove").click(function(){

      if (!confirm("您確定要刪除此欄位嗎？")) {
              return false;
      }

      var data = { id : $(this).attr("iid") };
      var url  = base_url + 'identify/del_process';

      console.log(data);
      // Send the data using post
      $.post(
        url,
        data,
        function() {
          identify.list_loader();
        }
      );
    });
  };

  identify.run();

});