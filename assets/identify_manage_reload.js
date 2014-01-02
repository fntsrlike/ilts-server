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
      $("#table").load(
        base_url + 'identify/organ_ident_list/' + $("#createForm").find( "input[name='oId']").val(),
        function(){
          $.getScript(base_url + "assets/identify_manage_reload.js");
        });
    }
  );
});

