/**
 * Horizontal slider created to profile, product and project area
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
function HorizontalSlider(object)
{
  var container      = $(object);
  var content        = $('.horizontal-slider-content', container);
  var images         = $('ul', content);
  var arrows         = $('.arrows a', container);
  // var items          = 0
  var movementAmount = 0;
  var baseWidth      = 940;
  var position       = 0;
  var _this          = this;

  // Initial actions
  this.init = function()
  {
    // Define items amount
    movementAmount = container.find('.horizontal-slider').children().length;

    // Define the right value
    movementAmount = movementAmount % 4 == 0 ? (movementAmount / 4) - 1 : Math.floor(movementAmount / 4);

    // Actions whem arrows are clicked
    arrows.on('click', function(e) {

      // Prevent default <a> tag action
      e.preventDefault();

      // Check if need scroll leftside or rightside
      if($(this).attr('class') == 'next') {
        _this.goRight();
      }else{
        _this.goLeft();
      }

    });
    
  }

  // Scroll to right side of screen
  this.goRight = function() {

    if( position < movementAmount ) {
      position = position + 1;
      _this.animate();
    }

  }

  // Scroll to left side of screen
  this.goLeft = function() {

    if(position > 0) {
      position = position - 1;
      _this.animate();
    }

  }

  // Animate the content
  this.animate = function() {
    images.animate({'right': position * baseWidth});
  }

  // Initialize the slider
  _this.init();
}