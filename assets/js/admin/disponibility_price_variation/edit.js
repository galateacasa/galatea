$(document).ready(function(){
  set_combo_state(false);
  $('#state').change(function(){
    set_combo_city(false, $(this).val());
  });

});


