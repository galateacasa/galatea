/**
 * Class to perform a user vote
 * @param {string} User ID that will make the vote
 *
 * Usage:
 *
 * <a
 * id="item_vote_15"
 * href="#"
 * class="item_vote"
 * data-vote-type="ajax_controller_name"
 * data-vote-id="15"
 * >vote</a>
 */
function Vote(user_id)
{
  this.init = function()
  {
    // Listen for element
    $('.item_vote').live('click', function(e) {

      // Prevent default action for <a> tag
      e.preventDefault();

      // Define tag ID
      var tag = $('#' + $(this).attr('id'));

      // Item type
      var type = $(this).attr('data-vote-type');

      // Item ID
      var id = $(this).attr('data-vote-id');

      // Create request URL
      var url = window.location.protocol + '//' + window.location.host  + '/ajax/' + type + '/vote';

      // AJAX request
      $.ajax({

        type: 'GET',
        dataType: 'JSON',
        cache: false,
        url: url,
        data:{ id: id },
        timeout: 2000,

        // Error action
        error: function(){
          noty({
            type   : 'error',
            text   : 'Ocorreu um erro, entre em contato com a Galatea',
            layout : 'topLeft',
            timeout: 10000
          });
        },

        // Success action
        success: function(data){

          // Check if the result and the text was set
          if(data.result != '' && data.text != '')
          {
            // Active class name
            var activeClass = 'active';

            // Apply active class
            if(data.result == 'success') { tag.addClass(activeClass); }

            // Remove active class or item
            if(data.result == 'alert') {

              // Check if the tag class is a close icon
              if( tag.parent().hasClass('close') || tag.parent().hasClass('close_following') ) {

                // Define tag container
                var tagContainer = tag.closest('ul');

                // Define items amount
                var itemsAmount = tagContainer.children().length;

                if( tag.parent().hasClass('close_following') )
                {
                  // Check if the last one will be removed
                  if(itemsAmount == 1) {
                    tagContainer.text('Você não segue ninguém.');
                  }
                }else{

                  // Check if is necessary to remove slider arrow
                  if(itemsAmount == 5 || itemsAmount < 5) {

                    // Remove the slider arrows
                    tag.closest('.horizontal-slider-container').find('.arrows').remove();

                    // Position the slider at the beginning
                    tag.closest('.horizontal-slider').animate({'right': '0px'});
                  }

                  // Check if is necessary to add some empty <li>
                  if(itemsAmount < 5) {
                    $('<li>').attr('class', 'empty').appendTo(tagContainer);
                  }

                }

                // Remove item content
                tag.closest('li').remove();

              }else{
                tag.removeClass(activeClass);
              }

            }

            // Show the message
            noty({
              type   : data.result,
              text   : data.text,
              layout : 'topLeft',
              timeout: 10000
            });

          }

        }

      });

    });

  }

  // Initialize the method main method
  this.init();
}