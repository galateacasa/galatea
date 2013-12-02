$('#file').customFileInput();

/*
$(function(){
    $('select.styled').customSelect();
});
*/
$(document).ready(function () {
  $('.slide-tabbing .block').hide();

  $('.slide-links li a').click(function(){
    $('.slide-links li').removeClass('active');
    $(this).parent().addClass('active');
    var currentTab = $(this).attr('href');
    $('.slide-tabbing .block').slideUp();
    $(currentTab).slideDown();
    return false;
  });


//VALIDATION

    $('#frmeditdata').validate({
        onsubmit  :true,
        onkeyup: false,
        errorClass : 'error',
        rules:{
            'name':{
                required: true
            },
            'surname':{
                required: true
            },
            'cpf':{
                required: true
            },
            'description':{
                required: true
            },
            'zip':{
                required: true
            },
            'phone':{
                required: true
            },
            'street':{
                required: true
            },
            'number':{
                required: true
            },
            'complement':{
                required: true
            },
            'city':{
                required: true
            },
            'estate':{
                required: true
            },
            'country':{
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
            }
        },

        messages:{
            'name':{
                required: "Informe seu nome<br />"
            },
            'surname':{
                required: "Informe seu sobrenome<br />"
            },
            'cpf':{
                required: "Informe seu CPF<br />"
            },
            'description':{
                required: "Informe a descrição<br />"
            },
            'zip':{
                required: "Informe seu CEP<br />"
            },
            'phone':{
                required: "Informe seu Telefone<br />"
            },
            'street':{
                required: "Informe seu Endereço<br />"
            },
            'number':{
                required: "Informe seu número<br />"
            },
            'complement':{
                required: "Informe complemento<br />"
            },
            'city':{
                required: "Informe a cidade<br />"
            },
            'estate':{
                required: "Informe seu estado<br />"
            },
            'country':{
                required: "Informe seu País<br />"
            },
            'email':{
                required: "Informe seu email<br />",
                email: "Informe um email válido<br />",
                remote: "O email já está em uso<br />"
            }
        },
        errorPlacement: function(error, element) {
            error.appendTo( $('#error') );
        }
    });



    /**
     * set_combo_state
     *
     * Fill the state combobox
     *
     * @param select option value to mark as selected
     */
    function set_combo_state_cls(select){
        $('.city').html('<option value="">Selecione o estado</option>');
        $.ajax({
            type: "POST",
            data: "",
            dataType: "json",
            cache: false,
            url: '/ajax/states/get',
            timeout: 2000,
            error: function() {
                console.log("Failed to submit");
            },
            success: function(data) {
                $("select.state option").remove();

                var row = '<option value=""></option>';
                $.each(data, function(i, j){
                    var selected = "";
                    if(select == j.id){
                        selected = "selected";
                    }
                    row += "<option acronym=\"" + j.acronym + "\"  value=\"" + j.id + "\" "+selected+" >" + j.name + "</option>";
                });

                $('.state').html(row);
            }
        });
    }


    /**
     * set_combo_city
     *
     * Fill the city combobox
     *
     * @param select option value to mark as selected
     * @param state_id state selected to filter the cities
     */
    function set_combo_city_cls(select, state_id){
        $('.city').html('<option value="">Selecione o estado</option>');
        if(state_id!=''){
            $.ajax({
                type: "POST",
                data: "state_id=" + state_id,
                dataType: "json",
                cache: false,
                url: '/ajax/states/get',
                timeout: 2000,
                error: function() {
                    console.log("Failed to submit");
                },
                success: function(data) {
                    $("select.city option").remove();

                    var row = '';
                    $.each(data, function(i, j){
                        var selected = "";
                        if(select!= "" && (select == j.id || select.toUpperCase() == j.name) ){
                            selected = "selected";
                        }
                        row += "<option value=\"" + j.id + "\" "+selected+" >" + j.name + "</option>";
                    });

                    $('.city').html(row);
                }
            });
        }
    }


    $('.cpf').mask('999.999.999-99');
    $('.cnpj').mask('99.999.999/9999-99');
    $('.cep').mask('99.999-999');
    $('.phone').mask('9999-9999');

});
