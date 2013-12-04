$(document).ready(function() {

  /* Close button */
  $(".close-btn, .close-button").bind('click', function() {
    $("#upload-pro, #inspire-me, .pop-block-extended, .overlay").fadeOut()
  });


  var lan = 0;
  lan = $('.top-msg_box li').length;

/*--------------------------------------------------------------------------------------------------------------------------*/

  $(".grid_12 img").click(function(){
    var path = $(this).attr('src');
    var index = $(this).index();
    var text = $(this).attr('alt');
    $('.upload-big-figure a').html('<img src='+path+' >');
    $('.over-flow h3 a em').html(text);
  });

//--------------------------------------------------------------------------------------------------

$(".sidebar-nav").css({'height':($(".category-page").height()+'px')});


  //--------------------------------------------------------------------------------------------------
    /*THumbnail Slider*/
//--------------------------------------------------------------------------------------------------


$("#large_images > li").each(function(index, element) {
  $(element).attr("class", 'hide');
  $(element).attr("id", 'img' + index);
});

$("#thumb_holder li a").each(function(index, element) {
  $(element).attr("rel", 'img' + index);
});

  var mainImg = 'img0';
  var current = 'img0';

  $('#img0').css('display', 'inline');
  $('#img0').addClass('current');

  $('#thumb_holder li a').click (function(){
    mainImg = $(this).attr('rel');
    if(mainImg != current){
    $('.current').fadeOut('slow');
    $('#'+mainImg).fadeIn('slow', function(){
    $(this).addClass('current');
    current = mainImg;

    });
    }
  });

  $(".post-block li .close-btn").click(function(){
    $(this).parent().css("display","none");
    lan--;
    if(lan < 1) { $('.top-msg_box').css("display","none"); }
  });

  $("#info-block .link-btn").click(function(){
    $("#info-block").append('asdsazs');
  });

});
