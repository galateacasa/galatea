$(document).ready(function(){
  set_combo_user(false);
  set_combo_item(false);
  set_combo_category(false);
  $('#category').change(function(){
    set_combo_sub_category(false, $(this).val());
  });
});