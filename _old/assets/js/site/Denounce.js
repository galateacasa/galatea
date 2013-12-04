/**
 * Class to perform a user denounce
 * @param {string} User ID that will denounce the item
 *
 * Usage:
 *
 * <a
 * id="item_denounce_15"
 * href="#"
 * class="item_denounce"
 * data-denounce-type="ajax_controller_name"
 * data-denounce-id="15"
 * >vote</a>
 * 
 */
function Denounce(user_id)
{
  /**
   * User ID
   * @type {integer}
   */
  // var user_id = user_id;

  this.init = function()
  {
    // Listen for element
    $('.item_denounce').bind('click', function(e) {

      e.preventDefault();

      var denounce = $(this);

      // Check if the user really want denounce the item
      noty({
        text: 'Você deseja mesmo denunciar este item?',
        layout: 'topLeft',
        timeout: 10000,
        buttons: [
          {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {

              $noty.close();

              // Define tag ID
              var tag_id = '#' + denounce.attr('id');

              // Item type
              var type = denounce.attr('data-denounce-type');

              // Item ID
              var id = denounce.attr('data-denounce-id');

              // Check if the user was set
              if(user_id != '') {

                // Create request URL
                var url = window.location.protocol + '//' + window.location.host + '/ajax/' + type + '/denounce';

                // AJAX request
                $.getJSON(url, {id: id,user_id: user_id}, function(result) {
                  // Notify user
                  noty({
                    type   : result.type,
                    text   : result.message,
                    layout : 'topLeft',
                    timeout: 10000
                  });
                });

              }

            }
          },
          {addClass: 'btn btn-danger', text: 'Cancelar', onClick: function($noty) {
              $noty.close();
            }
          }
        ]
      });

    });

  }

  // Initialize the method main method
  this.init();
}