$(document).ready(function(){
  set_combo_expertise(false);

  set_combo_state(false);
  $('#state').change(function(){
    set_combo_city(false, $(this).val());
    if($(this).val()==25){
      $('#phone').mask('99999-9999');
    }else{
      $('#phone').mask('9999-9999');
    }
  });
  
  //MASKS
  $('#zip').mask('99999-999');
  $('#phone').mask('9999-9999');
  $('#cpf').mask('999.999.999-99');
  
  //Person Type
  $("#person_pf").show();
  $("#person_pj").hide();
  $(".person_type").click(function(){
    if($(this).val() == "pf"){
      $("#person_pf").show();
      $("#person_pj").hide();
    }else{
      $("#person_pf").hide();
      $("#person_pj").show();
    }
  });
  
  //VALIDATION
  $('#form_create_user').validate({
    errorClass : 'error',
    rules:{
      'name':{
        required: true
      },
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
      'password' : {
        required :true,
        minlength : 8
      },
      'password_conf' : {
        equalTo: '#password'
      },
      'agreement':{
        required: true
      }
    },
    
    messages:{
      'name':{
        required: "Informe seu nome"
      },
      'email':{
        required: "Informe seu email",
        email: "Informe um email válido",
        remote: "O email já está em uso"
      },
      'password':{
        required: "Informe uma senha",
        minlength : 'A senha deve ter no mínimo 8 caracteres.'
      },
      'password_conf':{
        equalTo: 'As senhas devem conferir'
      },
      'agreement':{
        required: "É necessário aceitar os termos e Condições Gerais de Uso do Site "
      }
    }
  });

$(document).keypress(function(e) {
  if(e.which == 13) {
    return false;
  }
});

$('#zip_search').click(function(){
  if($('#zip').val()){
    address_search($('#zip').val());
  }
});

});