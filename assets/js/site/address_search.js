function Address_Search(zip, street, state, city){
  var zip = $('#' + zip).val();
  var street = $('#' + street);
  var state = $('#' + state);
  var city = $('#' + city);

  var _this = this;

  this.search = function(){
    $.ajax({
      url: '/ajax/correios/address_search',
      type: 'POST',
      dataType: 'json',
      data: {zip: zip},
      complete: function(xhr, textStatus) {
        //called when complete
      },
      success: function(data, textStatus, xhr) {
        street.val(data.tipo_logradouro+" "+data.logradouro);
        _this.setComboState(data.uf, data.cidade);
      },
      error: function(xhr, textStatus, errorThrown) {
        console.log(textStatus);
      }
    });
  }

  /**
   * Fill and select the state combobox
   * @param  {string} text to compare and select tag
   * @return {void}
   */
  this.setComboState = function(select, city_name){
    city.html('<option value="">Selecione o estado</option>');
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
        var row = '<option value=""></option>';
        $.each(data, function(i, j){
          var selected = "";
          if(select == j.id || select == j.acronym){
            selected = "selected";
          }
          row += "<option acronym=\"" + j.acronym + "\"  value=\"" + j.id + "\" "+selected+" >" + j.name + "</option>";
        });

        state.html(row);
        _this.changeOptionText(state);
        _this.setComboCity(state.val(), city_name);
      }
    });
  }

  /**
   * Fill and select the city combobox
   * @param  {string} text to filter the cities according to the state_id
   * @param  {string} text to compare and select tag
   * @return {void}
   */
  this.setComboCity = function(state_id, select){
    city.html('<option value="">Selecione o estado</option>');
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
          var row = '';
          $.each(data, function(i, j){
            var selected = "";
            if(select!= "" && (select == j.id || select.toUpperCase() == j.name)){
              selected = "selected";
            }
            row += "<option value=\"" + j.id + "\" "+selected+" >" + j.name + "</option>";
          });

          city.html(row);
          _this.changeOptionText(city);
        }
      });
    }
  }

  /**
   * Change the custom select text
   * @param  {object} select DOM select tag
   * @return {void}
   */
  this.changeOptionText = function(select)
  {
    // Get the selected option text
    var mainText = select.children().filter(':selected').text();

    // Get the tag that display the custom dropdown
    var displayTag = select.next().children();

    // Check if something was selected
    if(mainText.length > 0){
      displayTag.text(mainText);
    }else{
      displayTag.text('Selecione uma opção');
    }
  }

}
