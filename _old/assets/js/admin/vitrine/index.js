$(document).ready(function() {
  var gridster = $(".gridster ul").gridster({
    widget_margins: [10, 10],
    widget_base_dimensions: [140, 140]
  }).data('gridster');

  $('#add_item').click(function(){
    html = "<li><a class='btn remove_item'>Remover</a><img src='http://placehold.it/360x270' ></li>";
    gridster.add_widget(html);
  });

  $('.remove_item').live('click', function(){
    console.log($('.gridster li').eq(1));
    gridster.remove_widget( $('.gridster li').eq(0));
  });

  $('.resize_item').live('click', function(){

  });

  $('#save').click(function(){
    console.log(gridster.serialize());
  });

  function remove_item(obj){
    gridster.remove_widget($('.gridster li').eq(obj));
  }
});


