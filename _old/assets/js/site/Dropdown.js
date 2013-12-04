/**
 * Automaticly creates the default values for main <select> tag and the dependencies <option> for the second <select> when the first changes.
 *
 * @param {string} origin          : Tag ID without "#"
 * @param {string} destiny         : Tag ID without "#"
 * @param {string} url             : AJAX request URL
 * @param {string} origin_selected : value to initialy select in the origin combo
 * @param {string} destiny_selected: value to initialy select in the destiny combo
 */
function Dropdown(origin, destiny, url, origin_selected, destiny_selected)
{
  /**
   * Define the origin dropdown. First to be changed
   * Ex.: $('#originDropdown')
   * @type {object}
   */
  var origin = $('#' + origin);

  /**
   * Set the initial selected value for the origin dropdown
   * Ex.: 2
   * @type {string}
   */
  var origin_selected = origin_selected;

  /**
   * Define the dropdown that will receive the options
   * Ex.: $('#dropdownDestino')
   * @type {object}
   */
  var destiny = $('#' + destiny);

  /**
   * Set the initial selected value for the destiny dropdown
   * Ex.: 2
   * @type {string}
   */
  var destiny_selected = destiny_selected;

  /**
   * Define the request URL
   * Ex.: '/ajax/name/action'
   * @type {string}
   */
  var url = url;

  /**
   * It's used to Referee to the Dropdown class instead another object
   * @type {object}
   */
  var _this = this;

  // Ajax request
  this.init = function()
  {
    // Add all parent data to the main dropdown
    $.getJSON(url, function(parentData){

      // Add all options
      origin.append( _this.mountOptions(parentData) );

      //Inicial selected value for origin
      origin.val(origin_selected);

      // Change custom text for the origin dropdown
      _this.changeOptionText(origin);

      // Change custom text for the destiny dropdown
      _this.changeOptionText(destiny);

      // if existis origin_selected mount the destiny dropdown
      if(origin_selected > 0){
        _this.ajaxDestiny(origin_selected, destiny_selected);
      }
    });

    // Listen for the main dropdown
    origin.bind('change', function(){

      // Convert id to int
      var id = parseInt( origin.val() );

      _this.changeOptionText(origin);

      // Check if any ID was defined. 0 (zero) means parent options.
      if(id > 0)
      {
        _this.ajaxDestiny(id, '');
      }

    });

    // Listen for the destiny dropdown change
    destiny.bind('change', function(){
      _this.changeOptionText(destiny);
    });

  }

  /**
   * Create the ajax request to mount the destiny dropdown
   * @param {string} origin selected value
   * @param {string} destiny initial selected value
   * @return {void}
  */
  this.ajaxDestiny = function(id, initial_destiny){
    // Do the request
    $.getJSON(url, {
      id: id
    }, function(data){
      if(data.length > 0){
        // Remove all children options
        destiny.children().remove();

        // Add all options to destiny dropdown
        destiny.append( _this.mountOptions(data) );

        // Select initial value for destiny combobox
        if(initial_destiny > 0){
          destiny.val(initial_destiny);
        }

        // Change custom text
        _this.changeOptionText(destiny);
      }

    });
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

  /**
   * Create a HTML <option> markup to be appended to the object
   * @param  {json} json   JSON object with the data
   * @return {string}      HTML markup to be appended
   */
  this.mountOptions = function(json)
  {
    // Array with all options
    var options = [];

    // Create the options values
    options.push('<option value="">Selecione uma opção</option>');
    $.each(json, function(key, value){
      options.push('<option value="' + value.id + '">' + value.name + '</option>');
    })

    // Create a unique HTML markup
    return options.join('');
  }

  // Activate the listening
  this.init();

}