$(document).ready(function() {

  //Customized combo
  $('select.styled').customSelect();

  // Listening for delivery address select
  $('#delivery_address').bind('change', function(){

    // Variables
    var option = $("option:selected", this);

    //check if the selected delivery address is attended by logistics
    var delivery_address_id = option.val();

    $.ajax({
      type: "POST",
      dataType: "json",
      cache: false,
      url: '/ajax/delivery_addresses/verify_logistic',
      data:{delivery_address_id: delivery_address_id},
      timeout: 2000,
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr.responseText);
      },
      success: function(data) {
        if(data == 1){
          $('#error_msg').hide();
          $('#success_msg').show();
          $('#finalize').show();
          $('#change-address').hide();
        }else{
          $('#error_msg').show();
          $('#success_msg').hide();
          $('#finalize').hide();
          $('#change-address').show();
        }
      }
    });

  });


  //Money mask
  $('.money').maskMoney('mask');

  $('#frm_cart').bind('submit', function(){
    $('#user_credits').maskMoney('destroy');
    $('#user_credits').maskMoney({thousands:'', decimal:'.'});
    $('#user_credits').maskMoney('mask');
  });
});
