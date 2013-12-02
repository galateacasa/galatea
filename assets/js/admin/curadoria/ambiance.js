$(document).ready(function($) {
  $('#avaliation_id').change(function(){
    $.ajax({
      type: "POST",
      dataType: "json",
      cache: false,
      url: '/ajax/curadoria/get_avaliation_text',
      data:{avaliation_id: $(this).val()},
      timeout: 2000,
      error: function() {
        console.log("Failed to submit");
      },
      success: function(data) {
        if(data.result == 0){
          $('#message').val(" ");
        }else{
          $('#message').val(data.message);
        }
      }
    });
  });
});
