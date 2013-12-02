$(document).ready(function() {

  $('.filter').bind('click', function(e){

    e.preventDefault();

    var obj_show = $(this).attr('data-show');
    var obj_hide = $(this).attr('data-hide');
    var section = $(this).attr('data-section');
    var activate = 'activate';

    $('#' + obj_show).show();
    $('#' + obj_hide).hide();

    $('a[data-show="' + obj_hide + '"]').removeClass('activate');

    $(this).addClass('activate');

  });

  // Instanciate all needed sliders
  new HorizontalSlider('#carousel-product-starred');
  new HorizontalSlider('#carousel-product-mine');
  new HorizontalSlider('#carousel-project-starred');
  new HorizontalSlider('#carousel-project-mine');
  new HorizontalSlider('#carousel-ambiance-starred');
  new HorizontalSlider('#carousel-ambiance-mine');

});