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

  // Send the data using post
  $.post(
    url,
    data,
    function() {
      $("#table").load(
        base_url + 'identify/organ_ident_list/'+ $("#createForm").find( "input[name='oId']").val(),
        function(){
          $.getScript( base_url + 'assets/identify_manage_reload.js');
        }
      );
    };
  );
});