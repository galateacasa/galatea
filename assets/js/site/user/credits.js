$(document).ready(function() {
  var lan =0;
  lan = $('.top-msg_box li').length;

  var append=true;
  $("#upload-img").click(function(){

    $("#upload-pro").fadeIn(function(){
      if(append)

    {append=false;


   $(".carousel").eq(0).jCarouselLite({
        btnNext: ".next",
        btnPrev: ".prev"
    });
   $(".carousel").eq(1).jCarouselLite({
        btnNext: ".next1",
        btnPrev: ".prev1"
    });
  }})
    });

  $(".close-btn").click(function(){
    $("#upload-pro").fadeOut()
    });

/*--------------------------------------------------------------------------------------------------------------------------*/

  var append1=true;
  $(".grid_12 img").click(function(){  var path = $(this).attr('src');
                     var index = $(this).index();
                     var text = $(this).attr('alt');
                 $('.upload-big-figure a').html('<img src='+path+' >');
                 $('.over-flow h3 a em').html(text);


    $("#inspire-me").fadeIn(function(){
      if(append1)

    {append1=false;
     $(".carousel").eq(5).jCarouselLite({
        btnNext: ".next",
        btnPrev: ".prev"
    });
   $(".carousel").eq(6).jCarouselLite({
        btnNext: ".next1",
        btnPrev: ".prev1"
    });

   $(".carousel").eq(7).jCarouselLite({
        btnNext: ".next2",
        btnPrev: ".prev2"
    });
   $(".carousel").eq(8).jCarouselLite({
        btnNext: ".next3",
        btnPrev: ".prev3"
    });

    }})
    });

  $(".close-btn").click(function(){
    $("#inspire-me").fadeOut()
    });


//---------------------------------------------------------------------------------------

  var append2=true;
  $("#inspire-btn").click(function(){

    $("#inspire").fadeIn(function(){
      if(append2)

    {append2=false;
     $(".carousel").eq(2).jCarouselLite({
        btnNext: ".next",
        btnPrev: ".prev"
    });
   $(".carousel").eq(3).jCarouselLite({
        btnNext: ".next1",
        btnPrev: ".prev1"
    });

   $(".carousel").eq(4).jCarouselLite({
        btnNext: ".next2",
        btnPrev: ".prev2"
    });

    }})
    });

  $(".close-btn").click(function(){
    $("#inspire").fadeOut()
    });
//--------------------------------------------------------------------------------------------------

$(".sidebar-nav").css({'height':($(".category-page").height()+'px')});


  //--------------------------------------------------------------------------------------------------
    /*THumbnail Slider*/
//--------------------------------------------------------------------------------------------------


$("#large_images > li").each(function(index, element){$(element).attr("class", 'hide');});
    $("#large_images > li").each(function(index, element){$(element).attr("id", 'img'+index);});
    $("#thumb_holder li a").each(function(index, element){$(element).attr("rel", 'img'+index);});

  var mainImg ='img0';
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

        if(lan<1)
            {
            $('.top-msg_box').css("display","none");
          }
      });


$('.tabbing div.tabbing-content').hide();
$('#tabbin-a').show();


  $('#click li').click(function() {

    $('.tabbing-content').hide();

    var ind = $(this).index();

    $('#click li a').removeClass('active');
    $('#click li a').eq(ind).addClass('active');
    $('.tabbing-content').eq(ind-1).show();

    if( $('.tabbing-content').eq(ind-1).find(".customfile").length <=0 ) {
      $('.tabbing-content').eq(ind-1).find('#file').customFileInput();
    }

  });

});


  //--------------------------------------------------------------------------------------------------
    /*Msg BOx*/
//--------------------------------------------------------------------------------------------------
$(document).ready(function() {

               var value = 0;
  $("#info-block .link-btn").click(function(){
      $("#info-block").append('asdsazs');
    });


  // go through all the checkboxes
$(".msg").keyup(function(){
    el = $(this);
    if(el.val().length >= 250){
        el.val( el.val().substr(0, 250) );
    } else {
        $(".count").text(0+el.val().length);
    }
});

$(".field-links li").click(function() {

  //$(".field-links a").eq(value).removeClass('blue');
  var index = $(this).index() ;
  value = index;
  $('.field-links a').eq(index).toggleClass('blue');
});

$('.slector-con').hide();
$('.field-links li').hide();

$('#selector option').click(function(){
  $('.slector-con').show();
  var ind = $(this).index();
  $('.field-links li').eq(ind-1).toggle();
});

//--------------------------------------------------------------------------------------------------
    /*Slide Tabs*/
//--------------------------------------------------------------------------------------------------
$('.slide-tabbing .block').hide();

$('.slide-links li a').click(function(){
$('.slide-links li').removeClass('active');
$(this).parent().addClass('active');
var currentTab = $(this).attr('href');
$('.slide-tabbing .block').slideUp();
$(currentTab).slideDown();
return false;
});


$("#pwd-enter").click(function(){
    $(".enter-pwd ul").css("opacity",".4");
    $("#welcome-note").css("opacity","1");
        $('.enter-pwd input').attr("disabled", true);
  });

//---------- Add Adress ---------//

  $("#adds-content").click(function(){
      var a1 = $('.adds-tab-content').clone();
      $("#adds-tab").after(a1);
  });

$(".over-pro").hover(
  function(){
        $(this).append(' <span class="item-overlay"></span>');
      },

    function(){
        $('span.item-overlay').remove();
      }
    );


});



//===== select Option ====//
    /*$(function() {
        $('#selector').change(function(){
            $('.slector-con').hide();
            $('#' + $(this).val()).show();
        });
    });*/


          $(".shopping-cart tr .remove-link").click(function(){
                      $(this).parent().parent().css("display","none");
            });

