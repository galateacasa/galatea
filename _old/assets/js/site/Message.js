/**
 * Send a message to something or somebody
 * @dependency {jQuery}
 *
 * @param {integer} user_id Sender ID
 */
function Message(sender_id)
{
  /**
   * Define user ID into object
   * @type {integer}
   */
  var sender_id = parseInt(sender_id);

  /**
   * Reffers to own object
   * @type {object}
   */
  var _this = this;

  /**
   * Message container
   * @type {object}
   */
  var object = $('#message');

  /**
   * Required initialize actions
   * @return {void}
   */
  this.init = function()
  {
    // Action when the user press "Enter" key
    $('.message-input', object).live('keydown', function(e) {
      if(e.which == 13) {
        _this.send_message( $(this) );
      }
    });

    // Action when the user click into submit button
    $('.message-submit', object).live('click', function() {
      _this.send_message( $(this).prev() );
    });

    // Action when user click into replay button (arrow pointing to the left)
    $('.btn-reply').live('click', function(e){

      // Prevent default action for <a> tag
      e.preventDefault();

      // Add a new form markup
      _this.add_form( $(this).parent().parent() );
    });

    // Action when user click into the delete message button
    $('.cls', object).live('click', function(e){

      // Prevent default action for <a> tag
      e.preventDefault();

      // Delete message by ID
      _this.delete_message( $(this) );

    });

  }

  /**
   * Create a new message form
   */
  this.add_form = function(list)
  {
    // Check if have any items or the next one is a parent list
    if( list.next().length == 0 || list.next().hasClass('parent-list') )
    {
      // Input area, where the user type the message
      var input = '<input class="message-input feed-msg" type="text" placeholder="Escreva uma resposta...">';

      // Send button
      var button = '<input class="message-submit post-cmt btn-submit" type="button" value="button">';

      // Define classes to be added
      var classes = 'class="custom-list-width message-form"';

      // Complete markup
      var markup = '<li ' + classes + '>' + input + button + '</li>';

      // Add HTML markup
      list.after(markup);
    }
  }

  /**
   * Add a new message
   * @return {void}
   */
  this.send_message = function(input)
  {
    // Get message
    var message = input.val();

    // Define default parent ID
    var parent_id = 0;

    // Check if we are at main input
    if( !input.hasClass('main') ){
      // Define custom parent ID
      parent_id = parseInt( input.parent().prevAll('.parent-list:first').attr('id') );
    }

    if(sender_id != '')
    {
      // Get owner ID
      var owner_id = object.attr('data-owner-id');

      // Mount URL for AJAX request
      var url = _this.mount_url('send_message');

      // Perform AJAX request
      $.get(url, {

        id       : owner_id,
        sender_id: sender_id,
        message  : message,
        parent_id: parent_id,
        type     : 1

      }, function(new_message) {

        // Everything goes right?
        if (typeof new_message.error != 'undefined') {
          console.log(new_message.error);
          return;
        };

        // Create HTML markup for user name

        var user_name = '<a href="' + new_message.user_profile + '">' + new_message.user_name + '</a>';

        // Create HTML markup for delete link
        var del = '<a href="' + new_message.id + '" class="cls">&nbsp;</a>';

        // Define response button mark up
        var response = '';

        // define unique parent markup
        var parent_markup = '';

        // Define width class for new children objects
        var li_class = 'class="custom-list-width"';

        // Check if the button needs to be showed
        if( parent_id == 0 ){
          response = '<a href="#" class="btn-submit btn-reply">&nbsp;</a>';
          li_class = 'class="parent-list"';
        }

        // Create HTML markup for date and time
        var time = '<span>' + new_message.datetime + '</span>';

        // Create HTML markup for time detail
        var time_detail = '<div class="time-detail">' + del + response + time + '</div>';

        // Create <li> markup
        var markup = '<li id="' + new_message.id + '" ' + parent_markup + li_class + '>' + user_name + ' ' + new_message.message + time_detail + '</li>';

        if( input.hasClass('main') ){

          // Add the message with details into the list
          object.find('li').eq(0).after(markup);

        }else{

          $('#' + parent_id).nextAll('.message-form:first').before(markup);
        }

        // Remove added text
        input.val('');

      }, 'json');
    }

  }

  /**
   * Remove an existent message
   * @param  {integer} message_id ID of the message that need to be deleted
   * @return {void}
   */
  this.delete_message = function(message)
  {
    // Define message ID
    var message_id = message.attr('href');

    // Gets message object (<li>)
    var message_object = $('#' + message_id);

    // Remove message from database
    $.get( _this.mount_url('delete_message'), {
      id: message_id
    });

    // Remove form if it's will be alone
    if( message_object.next().hasClass('message-form') && message_object.prev().hasClass('parent-list') )
      message_object.next().remove();

    // Remove message from DOM
    message_object.remove();
  }

  /**
   * Mount URL for AJAXs requests
   * @param  {string} method Controller method name that will receive the AJAX request
   * @return {string}        URL for AJAXs request
   */
  this.mount_url = function(method)
  {
    // Get controller name
    var controller = object.attr('data-controller');

    // Mount URL for AJAX request
    var url = window.location.protocol + '//' + window.location.host + '/ajax/' + controller + '/' + method;

    // Return URL
    return url;
  }

  // Initialize the object
  this.init();
}