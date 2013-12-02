/**
* set_combo_state
*
* Fill the state combobox
*
* @param select option value to mark as selected
*/
function set_combo_state(select){
  $('#city').html('<option value="">Selecione o estado</option>');
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
      $("select#state option").remove();

      var row = '<option value=""></option>';
      $.each(data, function(i, j){
        var selected = "";
        if(select == j.id){
          selected = "selected";
        }
        row += "<option acronym=\"" + j.acronym + "\"  value=\"" + j.id + "\" "+selected+" >" + j.name + "</option>";
      });

      $('#state').html(row);
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
function set_combo_city(select, state_id){
  $('#city').html('<option value="">Selecione o estado</option>');
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
        $("select#city option").remove();
        var row = '';
        $.each(data, function(i, j){
          var selected = "";
          if(select!= "" && (select == j.id || select.toUpperCase() == j.name)){
            selected = "selected";
          }
          row += "<option value=\"" + j.id + "\" "+selected+" >" + j.name + "</option>";
        });

        $('#city').html(row);
      }
    });
  }
}

/**
* set_combo_user
*
* Fill the user combobox
*
* @param select option value to mark as selected
*/
function set_combo_user(select){
  $('#user').html('<option value="">Selecione o usuário</option>');
  $.ajax({
    type: "POST",
    dataType: "json",
    cache: false,
    url: '/ajax/users/get',
    timeout: 2000,
    error: function() {
      console.log("Failed to submit");
    },
    success: function(data) {
      $("select#user option").remove();
      var row = '';
      $.each(data, function(i, j){
        var selected = "";
        if(select == j.id){
          selected = "selected";
        }
        row += "<option value=\"" + j.id + "\" "+selected+" >" + j.name + "</option>";
      });
      $('#user').html(row);
    }
  });
}

/**
* set_combo_category
*
* Fill the category combobox
*
* @param select option value to mark as selected
  @param exclude category_id to exclude from the combo options
  */
  function set_combo_category(select, exclude){
    $('#category').html('<option value="">Selecione a categoria</option>');
    $.ajax({
      type: "POST",
      dataType: "json",
      cache: false,
      url: '/ajax/categories/get',
      data:{
        exclude: exclude
      },
      timeout: 2000,
      error: function() {
        console.log("Failed to submit");
      },
      success: function(data) {
        $("select#category option").remove();
        var row = '<option value="">Selecione a categoria</option>';
        $.each(data, function(i, j){
          var selected = "";
          if(select == j.id){
            selected = "selected";
          }
          row += "<option value=\"" + j.id + "\" "+selected+" >" + j.name + "</option>";
        });
        $('#category').html(row);
      }
    });
  }

/**
* set_combo_ambiance
*
* Fill the ambiance combobox
*
* @param select option value to mark as selected
*/
function set_combo_ambiance(select){
  $('#ambiance').html('<option value="">Selecione o ambiente</option>');
  $.ajax({
    type: "POST",
    dataType: "json",
    cache: false,
    url: '/ajax/ambiances/get',
    timeout: 2000,
    error: function() {
      console.log("Failed to submit");
    },
    success: function(data) {
      $("select#ambiance option").remove();
      var row = '';
      $.each(data, function(i, j){
        var selected = "";
        if(select == j.id){
          selected = "selected";
        }
        row += "<option value=\"" + j.id + "\" "+selected+" >" + j.name + "</option>";
      });
      $('#ambiance').html(row);
    }
  });
}

/**
* set_combo_item
*
* Fill the item combobox
*
* @param select option value to mark as selected
*/
function set_combo_item(select){
  $('#item').html('<option value="">Selecione o projeto</option>');
  $.ajax({
    type: "POST",
    dataType: "json",
    cache: false,
    url: '/ajax/items/get',
    timeout: 2000,
    error: function() {
      console.log("Failed to submit");
    },
    success: function(data) {
      $("select#item option").remove();
      var row = '';
      $.each(data, function(i, j){
        var selected = "";
        if(select == j.id){
          selected = "selected";
        }
        row += "<option value=\"" + j.id + "\" "+selected+" >" + j.name + "</option>";
      });
      $('#item').html(row);
    }
  });
}

/**
* set_combo_expertise
*
* Fill the expertise combobox
*
* @param select option value to mark as selected
*/
function set_combo_expertise(select){
  $('#expertise').html('<option value="">Selecione a expertise</option>');
  $.ajax({
    type: "POST",
    dataType: "json",
    cache: false,
    url: '/ajax/expertises/get',
    timeout: 2000,
    error: function() {
      console.log("Failed to submit");
    },
    success: function(data) {
      $("select#expertise option").remove();
      var row = '';
      $.each(data, function(i, j){
        var selected = "";
        if(select == j.id){
          selected = "selected";
        }
        row += "<option value=\"" + j.id + "\" "+selected+" >" + j.name + "</option>";
      });
      $('#expertise').html(row);
    }
  });
}

/**
* set_combo_style
*
* Fill the style combobox
*
* @param select option value to mark as selected
*/
function set_combo_style(select){
  $('#style').html('<option value="">Selecione o estilo</option>');
  $.ajax({
    type: "POST",
    dataType: "json",
    cache: false,
    url: '/ajax/styles/get',
    timeout: 2000,
    error: function() {
      console.log("Failed to submit");
    },
    success: function(data) {
      $("select#style option").remove();
      var row = '';
      row += "<option value=''  >Selecione o estilo</option>";
      $.each(data, function(i, j){
        var selected = "";
        if(select == j.id){
          selected = "selected";
        }
        row += "<option value=\"" + j.id + "\" "+selected+" >" + j.name + "</option>";
      });
      $('#style').html(row);
    }
  });
}

/**
* item_vote
*
* do/undo item vote
*
* @param item_id
* @param user_id
*/
function item_vote(item_id, user_id){
  if(user_id != ""){
    $.ajax({
      type: "POST",
      dataType: "json",
      cache: false,
      url: '/ajax/items/vote',
      data:{item_id: item_id, user_id: user_id},
      timeout: 2000,
      error: function() {
        console.log("Failed to submit");
      },
      success: function(data) {
        if(data.result!=""){
          $('#item_vote_'+item_id).addClass("active");
        }else{
          $('#item_vote_'+item_id).removeClass("active");
        }

      }
    });
  }else{
    console.log('need to login before vote.');
  }
}

/**
* user_vote
*
* do/undo user vote
*
* @param user_voted_id
* @param user_id
*/
function user_vote(user_voted_id, user_id){
  console.log(user_voted_id);
  if(user_id != ""){
    $.ajax({
      type: "POST",
      dataType: "json",
      cache: false,
      url: '/ajax/users/vote',
      data:{user_voted_id: user_voted_id, user_id: user_id},
      timeout: 2000,
      error: function() {
        console.log("Failed to submit");
      },
      success: function(data) {
        if(data.result!=""){
          $('#user_vote_'+user_voted_id).addClass("active");
        }else{
          $('#user_vote_'+user_voted_id).removeClass("active");
        }
      }
    });
  }else{
    console.log('need to login before vote.');
  }
}

/**
* ambiance_vote
*
* do/undo user vote
*
* @param ambiance_id
* @param user_id
*/
function ambiance_vote(ambiance_id, user_id){
  if(user_id != ""){
    $.ajax({
      type: "POST",
      dataType: "json",
      cache: false,
      url: '/ajax/ambiances/vote',
      data:{ambiance_id: ambiance_id, user_id: user_id},
      timeout: 2000,
      error: function() {
        console.log("Failed to submit");
      },
      success: function(data) {
        if(data.result!=""){
          $('#ambiance_vote_'+ambiance_id).addClass("active");
        }else{
          $('#ambiance_vote_'+ambiance_id).removeClass("active");
        }
      }
    });
  }else{
    console.log('need to login before vote.');
  }
}

/**
* address_search
*
* Search address from zip code
*
* @param zip
*/
function address_search(zip){
  $.ajax({
    type: "POST",
    dataType: "json",
    cache: false,
    url: '/ajax/correios/address_search',
    data:{zip: zip},
    timeout: 2000,
    error: function() {
      console.log("Failed to submit");
    },
    success: function(data) {
      if(data.resultado == 0){
        console.log('address not found');
      }else{
        $('#street').val(data.tipo_logradouro+" "+data.logradouro);
        $('#district').val(data.bairro);
        $("select#state option").each(function() {
          if($(this).attr('acronym') == data.uf){
            $(this).attr("selected", true);
            set_combo_city(data.cidade, $(this).attr('value'));
          }
        });
      }
    }
  });
}

/**
* setUserMessageRead
*
* Set user message as read
*
* @param message_id
*/
function setUserMessageRead(message_id, user_id){
  $.ajax({
    type: "POST",
    dataType: "json",
    cache: false,
    url: '/ajax/user_messages/setUserMessageRead',
    data:{message_id: message_id},
    timeout: 2000,
    error: function() {
      console.log("Failed to submit");
    },
    success: function(data) {
      listUserMessages(user_id);
    }
  });

}

function listUserMessages(user_id){
  $.ajax({
    type: "POST",
    dataType: "json",
    cache: false,
    url: '/ajax/user_messages/get',
    data:{user_id: user_id},
    timeout: 2000,
    error: function() {
      console.log("Failed to submit");
    },
    success: function(data) {
      $('#user_messages').html("");
      var html = "";

      msgCount = data.return.length;
      if(msgCount > 0){
        if(msgCount > 1){
          msgCountTxt = "Você tem "+msgCount+" mensagens";
        }else{
          msgCountTxt = "Você tem "+msgCount+" mensagem";
        }

        html += "<h4 class='alert-heading'>"+msgCountTxt+"</h4>";
        $.each(data.return, function(i, j){
          html += "<div class='alert alert-block alert-info fade in' message_id='"+j.id+"'>";
          html += "<button type='button' class='close' data-dismiss='alert'>×</button>";
          html += "<p>"+j.sender_name+" disse:</p>";
          html += "<p>"+j.message+"</p>";
          html += "</div>";
        });

        $('#user_messages').html(html);
        $('#user_messages').show();
      }else{
        $('#user_messages').html("");
        $('#user_messages').hide();
      }

    }
  });
}

function sendUserMessage(user_id, sender_id, message){
  $.ajax({
    url: '/ajax/user_messages/sendUserMessage',
    type: 'POST',
    dataType: 'json',
    data: {
      message: message,
      user_id: user_id,
      sender_id: sender_id
    },
    success: function(data, textStatus, xhr) {
      $('#contact_msg').val("");
    }
  });
}

/**
* set_combo_category
*
* Fill the category combobox
*
* @param select option value to mark as selected
*/
function set_combo_category(select){
  $('#sub_category').html('<option value="">Selecione a categoria</option>');
  $.ajax({
    type: "POST",
    data: "",
    dataType: "json",
    cache: false,
    url: '/ajax/categories/get',
    timeout: 2000,
    error: function() {
      console.log("Failed to submit");
    },
    success: function(data) {
      $("select#category option").remove();

      var row = '<option value=""></option>';
      $.each(data, function(i, j){
        var selected = "";
        if(select == j.id){
          selected = "selected";
        }
        row += "<option value=\"" + j.id + "\" "+selected+" >" + j.name + "</option>";
      });

      $('#category').html(row);
    }
  });
}

/**
* set_combo_sub_category
*
* Fill the sub_category combobox
*
* @param select option value to mark as selected
* @param category_id category selected to filter the sub-categories
*/
function set_combo_sub_category(select, category_id){
  $('#sub_category').html('<option value="">Selecione a categoria</option>');
  if(category_id!=''){
    $.ajax({
      type: "POST",
      data: "id=" + category_id,
      dataType: "json",
      cache: false,
      url: '/ajax/categories/get',
      timeout: 2000,
      error: function() {
        console.log("Failed to submit");
      },
      success: function(data) {
        $("select#sub_category option").remove();

        var row = '<option value=""></option>';
        $.each(data, function(i, j){
          var selected = "";
          if(select!= "" && (select == j.id) ){
            selected = "selected";
          }
          row += "<option value=\"" + j.id + "\" "+selected+" >" + j.name + "</option>";
        });

        $('#sub_category').html(row);
      }
    });
  }
}

