$(document).ready(function(){
  $('#state').change(function(){
    set_combo_city(false, $(this).val());
    if($(this).val()==25){
      $('#phone').mask('99999-9999');
    }else{
      $('#phone').mask('9999-9999');
    }
  });
  
  //MASKS
  $('#zip').mask('99999-999');
  $('#phone').mask('9999-9999');
  $('#cpf').mask('999.999.999-99');
  
  //Person Type
  $(".person_type").click(function(){
    if($(this).val() == "pf"){
      $("#person_pf").show();
      $("#person_pj").hide();
    }else{
      $("#person_pf").hide();
      $("#person_pj").show();
    }
  });

  $(document).keypress(function(e) {
    if(e.which == 13) {
      return false;
    }
  });

  $('#zip_search').click(function(){
    if($('#zip').val()){
      address_search($('#zip').val());
    }
  });
  
});


