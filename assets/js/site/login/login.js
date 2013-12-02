$(document).ready(function() {

  // Check if the user came from about views
  $click = $('#click');

  var userRole = $('#role');

  if ( $('#from-designer').val() === 'true') {

    // Designer
    $click.find('.active').removeClass('active');
    $click.find('.s-designer').addClass('active');
    $('.msg-box').show();
    userRole.val(3);

  } else if ( $('#from-decorator').val() === 'true') {

    // Decorator
    $click.find('.active').removeClass('active');
    $click.find('.-decorator').addClass('active');
    $('.msg-box').show();
    userRole.val(4);

  } else if ( $('#from-supplier').val() === 'true') {

    // Supplier
    $click.find('.active').removeClass('active');
    $click.find('.s-supplier').addClass('active');
    $('#enterprise').show();
    userRole.val(2);

  } else {

    // Client
    $click.find('.active').removeClass('active');
    $click.find('.s-client').addClass('active');
    userRole.val(5);

  }

  $('#name').focus();

  //Custom input upload
  $('#user_image').customFileInput();

  $('.back-top-top').click(function(){
   $("html, body").animate({scrollTop: 0}, 500);
  });

  $(function(){
   $('select.styled').customSelect();
 });

  // Expertises options
  $('#selector').change(function(){

   var value = $(this).val();
   var text  = $(this).find('option').filter(':selected').text();
   var li = '<li><a href="javascript:;" class="link-btn btli">' + text + '</a><input type="hidden" name="expertise[]" value="' + value + '" /></li>';

    if(value != ''){
      $("#toshow ul").append(li);
      $("#toshow").show();
    }

  });

  // Remove expertises
  $('.btli').live('click',function(){

    //confirma se existe a classe blue
    if( $(this).hasClass('blue') )
    {

      var confirm = window.confirm('Tem certeza que deseja apagar?');

      if(confirm == true){
        //se existir e quiser aapagar, varre todos os outros que possuem a classe blue
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

  $('input').customInput();

  $('.msg').jqEasyCounter({
    'maxChars': 250,
    'maxCharsWarning': 240,
    'msgFontSize': '12px',
    'msgFontColor': '#000',
    'msgFontFamily': 'Arial',
    'msgTextAlign': 'right',
    'msgWarningColor': '#F00',
    'msgAppendMethod': 'insertBefore'
  });

  // 1-admin, 2-supplier, 3-designer, 4-decorator, 5-customer
  $('ul#click li > a').live('click', function(){

    $("ul#click li > a").removeClass("active");
    $(this).addClass("active");

    if ( $(".s-designer").hasClass('active') ) {

      userrole.val(3);

      $('#enterprise').hide();
      $('#enterprise').addClass("ignore");
      $('.msg-box').show();

    }else if ( $(".s-client").hasClass('active') ) {

      userrole.val(5);

      $('#enterprise').hide();
      $('#enterprise').addClass("ignore");
      $('.msg-box').hide();

    }else if ( $(".s-supplier").hasClass('active') ) {

      userrole.val(2);

      $('#enterprise').show();
      $('#enterprise').removeClass("ignore");
      $('.msg-box').hide();

    }else if ( $(".s-decorator").hasClass('active') ) {

      userrole.val(4);

      $('#enterprise').hide();
      $('#enterprise').addClass("ignore");
      $('.msg-box').show();

    }

  });

  //VALIDATION
  $('#frm_new_user').validate({
    onsubmit  :true,
    onkeyup: false,
    ignore: ':hidden',
    errorClass : 'error',
    rules:{
      'name':{ required: true },
      'surname':{ required: true },
      'email' : {
        required : true,
        email : true,
        remote: {
          url: "/ajax/users/email_verify",
          type: "post",
          data: {
            email: function() {
              return $("#email").val();
            }
          }
        }
      },

      'confirm_email' : { required: true, equalTo: '#email' },
      'pass'          : { required: true },
      'confirm_pass'  : { required: true, equalTo: '#pass' },
      'company_name'  : { required: true },
      'cnpj'          : { required: true, cnpj: true },
      'zip'           : { required: true },
      'phone'         : { required: true },
      'areaCode'      : { required: true },
      'street'        : { required: true },
      'number'        : { required: true }

    },

    messages:{
      'name':{ required: "Informe seu nome" },
      'surname':{ required: "Informe seu sobrenome" },
      'email':{
        required: "Informe seu email",
        email: "Informe um email válido",
        remote: "O email já está em uso"
      },
      'confirm_email':{
        required: "Informe o email de confirmação",
        equalTo: 'Os emails devem conferir'
      },
      'pass':{ required: "Informe uma senha" },
      'confirm_pass':{
        required: "Informe a senha de confirmação",
        equalTo: 'As senhas devem conferir'
      },
      'company_name': { required: "Informe a razão social da empresa" },
      'cnpj': { required: "CNPJ inválido" },
      'zip':{ required: "Informe o cep da empresa" },
      'phone': { required: "Informe o telefone da empresa" },
      'areaCode': { required: "Informe o ddd da empresa" },
      'street': { required: "Informe o endereço da empresa" },
      'number': { required: "Informe o número da empresa" }
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

  $(".cnpj").mask('99.999.999/9999-99');
  $(".cep").mask('99999-999');
  $(".phone").mask('9999-9999?9');
  $(".areaCode").mask('99');

  var statesURL = window.location.protocol + '//' + window.location.host  + '/ajax/states/get';

  //State and City Dropdown
  new Dropdown('state', 'city', statesURL, '', '');

});
