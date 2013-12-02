$(document).ready(function(){

  // Current URL
  var url = window.location.protocol + '//' + window.location.host;

  // Get Amazon URL
  $.getJSON( url + '/ajax/common/get_amazon_url', function(urls) {

    // Script to upload images on the fly
    new upload_box(
      'user-edit-dropbox',
      'user-edit-dropbox-message',
      'images/users',
      urls.user,
      1,
      '',
      '',
      100,
      100,
      'user-edit-custom-file'
    );

  });

  // Listening for "atualizar e ir para o carrinho" button
  $('#update-go-cart').bind('click', function() {

    // Define form object
    var form = '.user-edit';

    // Flag to redirect the user to the cart page
    $('<input>').attr({'name': 'go_cart', 'value': '1', 'type': 'hidden'}).appendTo(form);

    // Submit the form
    $(form).submit();

  });

  //Customized combo
  $('select.styled').customSelect();

  // Enable custom file input
  $('#user-edit-custom-file').customFileInput();


  $('#expertise').change(function(){
     var value = $(this).val();
     var text  = $(this).find('option').filter(':selected').text();
     var li = '<li><a href="javascript:;" class="link-btn btli">'+text+'</a><input type="hidden" value="'+value+'" name="expertise[]"  /></li>';

     if(value !== '') {
      $("#toshow ul").append(li);
    }

  });

  $('.btli').live('click',function(){
    //confirma se existe a classe blue
    if($(this).hasClass('blue')){
      var confirm = window.confirm('Tem certeza que deseja apagar?');
      if(confirm){
        //se existir e quiser apagar, varre todos os outros que possuem a classe blue
        $('.btli').each(function() {
          if($(this).hasClass('blue')){
            $(this).removeClass('blue');
            $(this).parent().remove();
          }
        });
      }
    }else{
      //se não adiciona a classe blue
      $(this).addClass('blue');
    }
  });

  $('.delivery-address-delete').live('click', function() {
    $(this).parent().remove();
  });

  var devilery_addresses = {
    getChildrens: function() {
      return $('.delivery-address-delete').parent().length;
    }
  };

  /**
   * Fill fields based on zip code typed
   */
  $('.zip input').live('blur', function() {

    // Get zip code without "-"
    var zipCode = $(this).val().replace('-', '');

    // Field in use
    var fieldName = null;

    var fields = {

      // Parent tag object
      section: $(this).closest('section'),

      fill: function(fieldName, data) {

        // Define field name to use
        this.fieldName = fieldName;

        if ( typeof data === 'undefined' ) {
          this.fillDropdown();
        }else if ( typeof data === 'object' ){
          this.fillDropdown(data);
        }else{
          this.getTag().val(data);
        }

      },

      /**
       * Get specific tag by field class
       * @return {object} HTML tag object
       */
      getTag: function() {
        return this.section.find('.' + this.fieldName).eq(0);
      },

      /**
       * Fill drop down with the right data
       * @return {void}
       */
      fillDropdown: function(data) {

        // The field if the country field?
        if ( this.fieldName === 'country' ) {

          // Country <option> that represents "Brasil"
          var option = this.getTag().find('option[value=36]');

          // Set option as selected
          option.attr("selected", 'selected');

          // Change text from custom select
          this.changeCustomText( option.text() );

          // Show state and city inputs
          this.getTag().parent().nextAll().show();
        }else{

          var request = $.ajax({
            url: window.location.protocol + '//' + window.location.host  + '/ajax/states/getAllWithCities',
            type: 'GET',
            dataType: 'JSON',
            async: false,
            data: {
              state: data.state,
              city: data.city
            }
          }).responseText;

          request = JSON.parse(request);

          // Update state <select> data
          this.fieldName = 'state';
          this.getTag().html(request.state.list);
          this.changeCustomText(request.state.name);

          // Update city <select> data
          this.fieldName = 'city';
          this.getTag().html(request.city.list);
          this.changeCustomText(request.city.name);

        }

      },

      /**
       * Change custom select text
       * @param  {string} customText Text to be used
       * @return {void}
       */
      changeCustomText: function(customText) {

        // Change the text
        this.getTag().next().children().text(customText);

      }

    }

    // The zipCode came correctly?
    if ( zipCode.length === 8 ) {

      $.ajax({

        // avisobrasil.com.br API URL with parameter
        url: 'http://cep.correiocontrol.com.br/' + zipCode + '.json',
        dataType: 'JSON',

      }).done( function(data) {

        // Fill street
        fields.fill('street', data.logradouro + ', ' + data.bairro);

        // Fill country
        fields.fill('country');

        // Fill state and cities
        fields.fill(null, {state: data.uf, city: data.localidade});

      });

    };

  });

  /**
   * Show/Hide states and cities based on the country name
   */
  $('.country').live('change', function() {

    // Actions with selected country tag
    var stateCity = {

      // Get state and city tags
      tags: $(this).parent().nextAll(),

      // Show everybody
      show: function() { this.tags.show(); },

      // hide everybody
      hide: function() { this.tags.hide(); }
    };

    // The country is Brasil?
    if ( $(this).val() === '36') {
      stateCity.show();
    }else{
      stateCity.hide();
    }

  });

  // Duplicate delivery address fields
  $("#user-edit-adds-content").click(function() {

    var content = $.ajax({
      url: window.location.protocol + '//' + window.location.host  + '/ajax/users/deliveryAddressForm',
      dataType: 'html',
      async: false
    }).responseText;

    // Add form into the specific area
    $('#user-delivery-address-footer').before(content);
  });

  // Activate character counter
  $('.msg').jqEasyCounter({
    'maxChars'       : 250,
    'maxCharsWarning': 240,
    'msgFontSize'    : '12px',
    'msgFontColor'   : '#000',
    'msgFontFamily'  : 'Arial',
    'msgTextAlign'   : 'right',
    'msgWarningColor': '#F00',
    'msgAppendMethod': 'insertBefore'
  });

  //MASKS
  $('.zip').mask('99999-999');
  $('.phone').mask('9999-9999?9');
  $('.areaCode').mask('99');
  $(".cnpj").mask('99.999.999/9999-99');
  $(".cpf").mask('999.999.999-99');

  //VALIDATION
  $('#frm_edit_user').validate({
    onsubmit  :true,
    onkeyup: false,
    ignore: ':hidden',
    errorClass : 'error',
    rules:{
      'name'        : { required: true },
      'surname'     : { required: true },
      'company_name': { required: true },
      'cnpj'        : { required: true, cnpj: true },
      'zip'         : { required: true },
      'cpf'         : { required: true, cpf: true },
      'areaCode'    : { required: true },
      'phone'       : { required: true },
      'street'      : { required: true },
      'number'      : { required: true },
      'state'       : { required: true },
      'city'        : { required: true },
      'country'     : { required: true }
    },

    messages:{
      'name'        : { required: "Informe seu nome" },
      'surname'     : { required: "Informe seu sobrenome" },
      'company_name': { required: "Informe a razão social" },
      'cnpj'        : { required: "Informe o cnpj" },
      'zip'         : { required: "Informe o cep" },
      'cpf'         : { required: "Informe o cpf" },
      'areaCode'    : { required: "Informe o ddd" },
      'phone'       : { required: "Informe o telefone" },
      'street'      : { required: "Informe a rua" },
      'number'      : { required: "Informe o número" },
      'state'       : { required: "Informe o estado" },
      'city'        : { required: "Informe a cidade" },
      'country'     : { required: "Informe o país" }
    },

    errorPlacement: function(error, element) {
      noty({
        type: "error",
        text: error.text(),
        layout: "topLeft",
        timeout: 5000
      });
    }

  });

});