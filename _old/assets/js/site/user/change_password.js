$(document).ready(function(){
  
  //VALIDATION
  $('#frm-change-password').validate({
    onsubmit  :true,
    onkeyup: false,
    onfocusout: false,
    ignore: ':hidden',
    errorClass : 'error',
    rules:{
      'password_repeat' : {
        equalTo: '#password'
      }
    },
    
    messages:{
      'password_repeat':{
        equalTo: 'As senhas devem conferir'
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


