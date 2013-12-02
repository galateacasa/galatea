$(document).ready(function() {

    // Listening for custom select
  $('.variations').bind('change', function() {

    // Variables
    var option            = $("option:selected", $(this) );
    var type              = parseFloat( option.attr('data-additional-type') );
    var measurement_value = parseFloat( $('#measurement option:selected').attr('data-additional-amount'));
    var material_value    = parseFloat( $('#material option:selected').attr('data-additional-amount'));
    var delivery_cost     = parseFloat( $('#delivery_cost').val());
    var priceInput        = $('.grand-total input');
    var price             = parseFloat( priceInput.attr('data-default-price').substr(3) );
    var newPrice          = 0;
    var instalments       = $('#total_instalments');

    // Change custom select text
    $(this).next().children().text( option.text() );

    //console.log(measurement_value);
    //console.log(material_value);
    //check if measurement and material are defined
    if( !isNaN(measurement_value) && !isNaN(material_value) )
    {
      // Check if the type is into percentage or money value and calc the product price
      rawPrice       = measurement_value + material_value + price;
      //console.log(rawPrice);
      delivery_price = rawPrice * (delivery_cost / 100);
      //console.log(delivery_price);
      newPrice       = rawPrice + delivery_price;
      //console.log(newPrice);

      // Add new price 
      priceInput.val( parseFloat(newPrice).toFixed(2) );

      //Add the instalments information
      instalments.val( parseFloat(newPrice/10).toFixed(2) );

      //Apply the money mask
      $('.money').maskMoney('mask');

    }else{
      //console.log('É necessário verificar os valores');

      //clear price and instalments fields
      priceInput.val('');
      instalments.val('');
    }

  });

  // Activate sliders
  new HorizontalSlider('#related-ambiances');
  new HorizontalSlider('#related-products');
  new HorizontalSlider('#disponibility-ambiances');

});