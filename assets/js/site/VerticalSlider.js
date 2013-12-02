/**
 * Vertical slider created to ambiance area
 * @param {string} container ID. Ex.: '#container'
 * @dependency: jQuery;
 * 
 * HTML markup:
 *
 * <div id="container">
 * 
 *   <div class="content">
 *     <ul>
 *     
 *       <li>
 *         <img src="http://lorempixel.com/100/100" alt="Image name" width="100" height="100">
 *       </li>
 *       
 *     </ul>
 *   </div>
 *
 *   <div class="arrows">
 *     <a class="previous" href="#">Anterior</a>
 *     <a class="next" href="#">Próximo</a>
 *   </div>
 *   
 * </div>
 * 
 * 
 */
function VerticalSlider(container)
{
  var container      = container;
  var arrows         = $('.arrows a', container);
  var content        = $('.content', container);
  var images         = $('ul', content);
  var items          = content.find('li').length;
  var movementAmount = 4;
  var baseWidth      = 110;
  var position       = 0;
  var _this          = this;

  // Initial actions
  this.init = function()
  {
    // Actions whem arrows clicked
    arrows.bind('click', function(e) {

      // Prevent default <a> tag action
      e.preventDefault();

      // Get class name
      var type = $(this).attr('class');

      // Check if need scroll downside or upside
      if(type == 'next') {
        _this.goBottom();
      }else{
        _this.goTop();
      }

    });
    
  }

  // Scroll to upside of screen
  this.goTop = function() {

    if(position > 0) {
      position = position - (baseWidth * movementAmount);
      _this.animate();
    }

  }

  // Scroll to downside of screen
  this.goBottom = function() {

    if( position < (images.height() - (baseWidth * movementAmount) ) ) {
      position = position + (baseWidth * movementAmount);
      _this.animate();
    }

  }

  // Animate the content
  this.animate = function() {
    images.animate({'bottom': position});
  }

  // Initialize the slider
  _this.init();
}