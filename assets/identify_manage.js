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
        $.getScript( base_url + 'assets/identify_manage_reload.js');
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