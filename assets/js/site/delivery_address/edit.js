$(document).ready(function(){
  $('#state').change(function(){
    set_combo_city(false, $(this).val());
  });
  
  //MASKS
  $('#zip').mask('99999-999');

});


