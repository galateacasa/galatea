/**
 * Create the placeholder effect for old browsers
 * Usage: just instanciate the class
 * Depencencies: jQuery
 * @see http://jquery.com/
 */
function Placeholder()
{
  /**
   * All tags into the document
   * @type {object}
   */
  var tags = $('input, textarea');

  /**
   * The own object
   * @type {object}
   */
  var _this = this;

  /**
   * Initial method
   * @return {void}
   */
  this.init = function()
  {
    // Check if the browser suppor placeholder attribute
    if(!Modernizr.input.placeholder){

      // Add default placeholder to all tags
      _this.addText(tags);

      // Listening for tag blur
      tags.bind('blur', function(){
        _this.addText(tags);
      });

      // Listening for tags focus
      tags.bind('focus', function(){
        _this.removeText(tags);
      });

      // Listen form tag
      $('form').bind('submit', function(e){
        // Remove all texts to garantee the submit goes without any placeholder text
        _this.removeAllText(tags);
      })
    }
  }

  /**
   * Add text from placeholder atribute
   * @param {object} tag DOM object
   */
  this.addText = function(tag){
    _this.loop(tag, 'add');
  }

  /**
   * Remove input value
   * @param {object} tag DOM object
   */
  this.removeText = function(tag){
    _this.loop(tag, 'remove');
  }

  /**
   * Remove all inputs values
   * @param {object} tag DOM object
   */
  this.removeAllText = function(tag){
    _this.loop(tag, 'removeAll');
  }

  /**
   * Check all inputs (or text areas) and perform the action
   * @param  {object} tags   DOM object
   * @param  {string} action Action to be performed
   * @return {void}
   */
  this.loop = function(tags, action)
  {        
    // Look up all objects
    for(var i = 0; i < tags.length; i++)
    {
      // Get current object
      tag = tags.eq(i)

      // Retriave text from placeholder atribute
      var placeholder = tag.attr('placeholder');

      // Remove text from input if it's focused
      if(action == 'remove'){
        if(tag.is(':focus') && tag.val() == placeholder) _this.remove(tag)
      }

      // Remove all texts
      if(action == 'removeAll'){
        if(tag.val() == placeholder) _this.remove(tag);
      }

      // Add text to the value atribute
      if(action == 'add'){
        if(tag.val() == '') _this.add(tag, placeholder);
      }
    }
  }

  /**
   * Remove texts from tags taking care for inputs and texareas diferences
   * @param  {object} tag Input or texarea object
   * @return {void}
   */
  this.remove = function(tag)
  {
    if( tag.is('textarea') ){
      tag.text('');
    }else{
      tag.val('');
    }
  }

  /**
   * Add texts at tags taking care for inputs and texareas diferences
   * @param  {object} tag Input or texarea object
   * @return {void}
   */
  this.add = function(tag, placeholder)
  {
    if( tag.is('textarea') ){
      tag.text(placeholder);
    }else{
      tag.val(placeholder);
    }
  }

  // Initialize class
  this.init();
}