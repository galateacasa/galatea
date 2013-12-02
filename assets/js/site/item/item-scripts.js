$(document).ready(function() {

  //Custom input upload
  $('#principal_img').customFileInput();
  $('#secondary_img').customFileInput();

  // URL for perform AJAX requests
  var url = window.location.protocol + '//' + window.location.hostname;

  // Get Amazon URL
  $.getJSON( url + '/ajax/common/get_amazon_url', function(urls) {

    // Script to upload principal image
    new upload_box('dropbox_principal', 'dropbox_principal', 'images/items', urls.item, 1, 'result_box_principal', '', 240, 100, 'principal_img');

    // Script to upload secondary images
    new upload_box('dropbox_secondary', 'dropbox_secondary', 'images/items', urls.item, 5, 'thumbnails', '', 240, 100, 'secondary_img');

  });

  // Instanciate a new dropdown with project categories list
  new Dropdown('project-categories', '', url + '/ajax/categories/get?id=156', 0, 0);

  // Activate custom select
  $('select.styled').customSelect();

  // Action when "Add more" button is pressed
  $('.add-more').bind('click', function() {

    // Define witch item needs to be cloned
    var itemID = $(this).attr('data-add');

    // Clone item
    var clone = $(itemID).clone();

    // Get all inputs
    var inputs = clone.find('input');

    // Remove any text thats come with inputs
    for(var i = 0; i < inputs.length; i++) inputs.eq(i).val('');

    // Add new item before blue button
    $(this).before(clone);

  });

  // Activate character counter
  $('.msg').jqEasyCounter({
      'maxChars'       : 300,
      'maxCharsWarning': 240,
      'msgFontSize'    : '12px',
      'msgFontColor'   : '#000',
      'msgFontFamily'  : 'Arial',
      'msgTextAlign'   : 'right',
      'msgWarningColor': '#F00',
      'msgAppendMethod': 'insertBefore'
  });

   //VALIDATION
  $('#frm_create_project').validate({
    onsubmit  :true,
    onkeyup: false,
    errorClass : 'error',
    rules:{
      'name':{
        required: true
      },
      'description':{
        required: true
      },
      'main_category':{
        required: true
      },
      'materials[]':{
        required: true
      },
      "measurements[height][]":{
        required: true,
        number: true
      },
      'measurements[width][]':{
        required: true,
        number: true
      },
      'measurements[depth][]':{
        required: true,
        number: true
      }
    },

    messages:{
      'name':{
        required: "Informe o nome do projeto"
      },
      'description':{
        required: "Informe a descrição"
      },
      'main_category':{
        required: "Selecione uma categoria"
      },
      'materials[]':{
        required: "Informe o material"
      },
      "measurements[height][]":{
        required: "Informe a altura",
        number: "Informe apenas números"
      },
      "measurements[width][]":{
        required: "Informe a largura",
        number: "Informe apenas números"
      },
      "measurements[depth][]":{
        required: "Informe a profundidade",
        number: "Informe apenas números"
      }

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