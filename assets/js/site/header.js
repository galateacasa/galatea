jQuery(document).ready(function($) {
  if (window.idShowAmbiance) {
    // Get ID
    var id = window.idShowAmbiance;

    // URL for AJAX request
    var url = window.location.protocol + '//' + window.location.host + '/ajax/ambiances/mount_pop_up';

    // Pop-up object
    var popUp = $('.pop-block-extended');

    popUp.css('top', $('body').scrollTop() + 50);

    // Get HTML markup
    var request = $.ajax({
      url: url,
      type: 'GET',
      data: {ambiance_id : id},
      dataType: "html"
    });

    // Add ambiance HTML mark up
    request.done(function(markup) {

      // Add new HTML markup
      popUp.html(markup);

      // Instanciate a new vertical align slider
      new VerticalSlider('#ambiance-vertical-slider');

      // Listening for overlay
      $('.overlay').on('click', function() {
        $('.pop-block-extended, .overlay').fadeOut(300);
        if (window.isHome === true) {
          window.history.pushState(null, 'Móveis online personalizados e objetos de decoração – Galatea Casa', '/ ');
        } else {
          window.history.pushState(null, 'Inspire-me', '/inspire-me');
        }
      });

      // Listening for close button
      $('.close-button').on('click', function() {
        $('.pop-block-extended, .overlay').fadeOut(300);
        if (window.isHome === true) {
          window.history.pushState(null, 'Móveis online personalizados e objetos de decoração – Galatea Casa', '/ ');
        } else {
          window.history.pushState(null, 'Inspire-me', '/inspire-me');
        }
      });

      $('.overlay').fadeIn(300);
      popUp.fadeIn(300);

    });
  }




  // Activate the blue color for main categories
  if (document.URL.indexOf('categoria/novidades') !== -1) {
    $('.category_novidades').addClass('active');
  } else if (document.URL.indexOf('categoria/vote') !== -1) {
    $('.category_vote').addClass('active');
  } else {
    $('.nav-main .category_' + $('#category-main-actual').val()).addClass('active');
  }

  // Add a message on the screen
  function alertMessage(message, type) {

    // Check if any type was set
    if(typeof type == 'undefined') type = 'error';

    noty({
      type   : type,
      text   : message,
      layout : 'topLeft',
      timeout: 10000
    });

  }

  // Object with some ambiance form actions
  var ambiance_add_form = {
    hide: function() {
      $('#ambiance-add-form, .pop-block, .pop-block-extended, .overlay').fadeOut(300);
    },

    show: function() {
      $('#ambiance-add-form, .overlay').fadeIn(300);
      $('#ambiance-add-form').css('top', $('body').scrollTop() + 100);
    }
  }

  // Custom file input
  $('#ambiance-image').customFileInput();

  // Listen for ambiance main item
  $('.ambiance-info').live('click', function(e) {

    // Prevent <a> tag default action
    e.preventDefault();

    // Get ID
    var id = $(this).attr('ambiance-id');

    // Change URL
    window.history.pushState(null, 'Inspire-me', '/inspire-me/' + id);

    // URL for AJAX request
    var url = window.location.protocol + '//' + window.location.host + '/ajax/ambiances/mount_pop_up';

    // Pop-up object
    var popUp = $('.pop-block-extended');

    popUp.css('top', $('body').scrollTop() + 50);

    // Get HTML markup
    var request = $.ajax({
      url: url,
      type: 'GET',
      data: {ambiance_id : id},
      dataType: "html"
    });

    // Add ambiance HTML mark up
    request.done(function(markup) {

      // Add new HTML markup
      popUp.html(markup);

      // Instanciate a new vertical align slider
      new VerticalSlider('#ambiance-vertical-slider');

      // Listening for overlay
      $('.overlay').on('click', function() {
        $('.pop-block-extended, .overlay').fadeOut(300);
        if (window.isHome === true) {
          window.history.pushState(null, 'Móveis online personalizados e objetos de decoração – Galatea Casa', '/ ');
        } else {
          window.history.pushState(null, 'Inspire-me', '/inspire-me');
        }
      });

      // Listening for close button
      $('.close-button').on('click', function() {
        $('.pop-block-extended, .overlay').fadeOut(300);
        if (window.isHome === true) {
          window.history.pushState(null, 'Móveis online personalizados e objetos de decoração – Galatea Casa', '/ ');
        } else {
          window.history.pushState(null, 'Inspire-me', '/inspire-me');
        }
      });

      $('.overlay').fadeIn(300);
      popUp.fadeIn(300);

    });

  });

  // Listen for ambiance add image
  $('#ambiance-add-image').bind('click', function() {
    ambiance_add_form.show();
  });

  // Listen for overlay layer (translucid black background)
  $('.overlay').bind('click', function() {
    ambiance_add_form.hide();
  })

  // Listen for "esc" key to hide ambiance pop-up
  $(document).bind('keydown', function(e) {
    if(e.keyCode == 27) {
      ambiance_add_form.hide();

      if (window.isHome === true) {
        window.history.pushState(null, 'Móveis online personalizados e objetos de decoração – Galatea Casa', '/ ');
      } else {
        window.history.pushState(null, 'Inspire-me', '/inspire-me');
      }
    }
  })

  // Listen for close button
  $('#ambiance-add-form .close-btn').bind('click', function() {
    ambiance_add_form.hide();
  })

  // URL for perform AJAX requests
  var url = window.location.protocol + '//' + window.location.hostname;
  var category_request_url = url + '/ajax/categories/get';

  // Get Amazon URL
  $.getJSON( url + '/ajax/common/get_amazon_url', function(urls) {

    // Script to upload images on the fly
    new upload_box('ambiance_dropbox', 'ambiance-upload-message', 'images/ambiances', urls.ambiance, 1, '', '', 270, 210, 'ambiance-image');

  });

  // Instanciate a new dropdown
  new Dropdown('ambiance-category-main', 'ambiance-category-sub', category_request_url, 0, 0);

  // Activate custom selects
  $('select.ambiance-styled').customSelect();

  // Listen for add attach products button
  $('#add-products-btn').bind('click', function( ) {
    $('#products-add').slideDown();

    if( $(window).height() < $('#ambiance-add-form').height() ) {
      $('#ambiance-add-form').animate({top: '-=280'});
    }
    $(this).fadeOut(300);
  });

  /**
   * Default request variable to be used do cancel any other search request in the future
   */
  var searchProductRequest = '';

  // Listen for products search area
  $('#search-ambiance').live('keyup', function(){

    var location     = window.location
    var url          = location.protocol + '//' + location.host + '/ajax/items/get_by_name';
    var amazonBucket = (location.hostname != 'www.galateacasa.com.br' && location.hostname != 'galateacasa.com.br') ? 'new' : 'production';
    var urlAmazon    = 'http://galatea-sp.s3.amazonaws.com/' + amazonBucket + '/images/items/';
    var keyword      = $.trim( $(this).val() );
    var searchResult = $('#search-result');
    var slider       = searchResult.children();
    var filter       = $('#filter .current-sel').attr('data-filter');

    // Check if any keyword was typed
    if(keyword != '')
    {
      // The request for keywords is running? Stop it!
      if (typeof searchProductRequest === 'object') {
        searchProductRequest.abort();
      }

      // Get results
      searchProductRequest = $.getJSON(url, {
        keyword: keyword,
        filter: filter
      }, function(result) {

        // Remove all currents results
        slider.children().remove();

        // Check if came something
        if(result.length > 0)
        {
          // Define search result text
          searchResult.prev().text(result.length + ' ítens para a busca "' + keyword + '"');

          // Add new results
          $.each(result, function(key, value){

            // Define attach image markup
            var attache = $('<span>').attr('class', 'slider-name').html('anexar');

            // Define image markup
            var image = new Image();

            // Define image source
            image.src = urlAmazon + value.image;

            // Append result to the slider
            $('<li>').attr('data-id', value.id).append(attache, image).appendTo(slider);

          });

          // Activate the horizontal slider for search result
          new HorizontalSlider('#ambiance-slider-search');

        }else{

          // Remove all data
          slider.children().remove();

          // Add result text
          searchResult.prev().text('Nenhum resultado encontrado para "' + keyword + '"');
        }


      });
    }else{
      searchResult.prev().text('Digite uma palavra-chave no campo de busca');
    }

  });

  $('.slider-name').live('click', function(){

    // Check if the option has the class "remove"
    if( $(this).hasClass('remove') ){

      $(this).parent().remove()

    }else{

      var product    = $(this).parent().clone().find('span').text('remover').addClass('remove').parent();
      var products   = $('#products-added').children();
      var hasProduct = false;

      // Check if already have any product
      if(products.length > 0){

        // Check all products to know if the checked product already have been attached and set it
        for(var i = 0; i < products.length; i++)
          if( products.eq(i).attr('data-id') == $(this).parent().attr('data-id') ) hasProduct = true;

        // Check if the product exists at attached products
        if(!hasProduct) product.appendTo( $('#products-added') );

        // Activate the slider
        new HorizontalSlider('#ambiance-slider-attached');

      }else{
        product.appendTo( $('#products-added') );
      }


    }

  });

  $('#filter a').bind('click', function(e){
    e.preventDefault();
    if( !$(this).hasClass('current-sel') ) $('#filter a').toggleClass('current-sel');
  });

  // Upload image to the amazon URL from URL
  $('#ambiance-save-image-url').bind('click', function() {

    // Collect image URL
    var image_url = $('#ambiance-image-url').val();

    // Check if any URL was sent
    if( $.trim(image_url) != '' ) {

      alertMessage('Aguarde, a imagem está sendo processada...', 'success')

      $.getJSON(url + '/upload/upload_from_url', {
        image_url: image_url,
        path: 'images/ambiances'
      }, function(result) {

        // Check if the message was successful uploaded
        if(result.status == 'success') {

          // Define the container
          var ambiance_dropbox = $('#ambiance_dropbox')

          // Define a new image object
          var image = new Image();
          image.src = result.url

          // Remove default text
          ambiance_dropbox.text('');

          // Append image
          ambiance_dropbox.append(image);

          // Create input object and append it to the container
          $('<input>').attr({type: 'hidden', id: 'image', value: result.name}).appendTo(ambiance_dropbox);

          // Set success message
          alertMessage(result.message, 'success');

        }else{
          alertMessage(result.message);
        }

      })


    }else{
      alertMessage('Insira um endereço válido para sua imagem externa.')
    }

  });

  // Listening form submittion
  $('#ambiance-form').bind('submit', function(e) { e.preventDefault() });

  // Listening for "publish" button
  $('#ambiance-save').bind('click', function() {

    // Get form variables
    var title            = $('#ambiance-title');
    var category_main    = $('#ambiance-category-main');
    var category_sub     = $('#ambiance-category-sub');
    var category_sub_val = parseInt( category_sub.val() );
    var category         = parseInt( category_main.val() );
    var image            = $('#image').val();
    var image_url        = $('#ambiance-image-url').val();
    var products         = $('#products-added').children();
    var products_ids     = [];
    var validated        = true;

    // Check if any sub-category was set
    if( category_sub_val > 0 ) category = category_sub_val;

    // Get all IDs from products
    for(var i = 0; i < products.length; i++) {

      // Get ID
      id = products.eq(i).attr('data-id');

      // Add to the array
      products_ids.push(id);
    }

    // Join all values
    products_ids = products_ids.join(';');

    // Validade image
    if(typeof image == 'undefined') {
      alertMessage('É necessário definir uma imagem, arraste-a para o quadrado cinza ou digite um endereço da internet.');
      validated = false;
    }

    // Validade category
    if( !(category > 0) ) {
      alertMessage('Escolha a categoria em que este ambiente mais se encaixa.');
      validated = false;
    }

    // validade title
    if( title.val() == '' ) {
      alertMessage('Dê um título a este ambiente.');
      validated = false;
    }

    // Check if all data is validated
    if(validated)
    {
      // Save data from form
      $.get(url + '/ajax/ambiances/newEntry', {

        title       : title.val(),
        category    : category,
        image       : image,
        image_url   : image_url,
        products_ids: products_ids

      }, function(ambiance) {
        alertMessage('Seu ambiente foi adicionado com sucesso à nossa galeria! Inspire-se clicando no botão azul no canto superior direito da tela.', 'success');
        $('#ambiance-add-form, .overlay').fadeOut(800);

        // Weite until the box fade out
        setTimeout(function() {

          // Redirect the user to the ambiances page
          window.location = url + '/site/ambiances';

          // Add products area
          $('#products-add').hide();
          $('#add-products-btn').show();

          // Remove title
          title.val('');

          // Remove main category
          category_main_option = $('option', category_main).eq(0);
          category_main_option.attr('selected', 'selected');
          category_main.next().children().text( category_main_option.text() );

          // Remove sub category
          category_sub.children().remove()
          category_sub.next().hide();

          // Image box text
          $('#ambiance_dropbox').html('Arraste a imagem para esta área<br>(Tamanho máximo de 2mb)');

          // Search area
          $('#search-ambiance').val('');
          $('ul', '#search-result').children().remove()
          $('#search-result').prev().text('');

          // Added products
          products.remove();

        }, 1000);

      });

    }
  });

});
