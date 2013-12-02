/**
 * Apply the filedrop plugin to the element passed as parameter.
 *
 * @dependecy jquery.filedrop.js
 * @dependecy jquery.ae.image.resize.min
 *
 * @param {string} dropbox     : Tag ID without "#"
 * @param {string} message     : Tag ID without "#"
 * @param {string} url         : URL to upload the image
 * @param {string} show_url    : URL to upload the image
 * @param {string} maxUploads  : number
 * @param {string} uploadResult: Tag ID without "#"
 * @param {array}  show_images : images name
 * @param {array}  width       : Image width
 * @param {array}  height      : Image height
 */
 function upload_box(dropbox, message, url, show_url, maxUploads, uploadResultName, show_images, width, height, fallback_id, maxSize){
  /**
  * Define the element to apply the filedrop plugin
  * Ex.: $('#dropbox')
  * @type {object}
  */
  var dropbox = $('#' + dropbox);

  /**
  * Define the element to show messages from the upload process
  * Ex.: $('#messages')
  * @type {object}
  */
  var message = $('#' + message);

  /**
  * Define the element to show the uploaded images
  * Ex.: $('#uploadResult')
  * @type {object}
  */
  var uploadResult = $('#' + uploadResultName);

  /**
  * Define the URL to send the uploaded image
  * Ex.: 'amazon_url/images/image'
  * @type {string}
  */
  var url = url;

  /**
  * Define the URL to show the uploaded image
  * Ex.: 'amazon_url/images/image'
  * @type {string}
  */
  var show_url = show_url;

  /**
  * Define the number of simultaneous uploads permited in this element
  * Ex.: 5
  * @type {string}
  */
  var maxUploads = maxUploads;

  /**
  * Define the max size of the file uploaded
  * Ex.: 2
  * @type {string}
  */
  var maxSize = maxSize != '' ? maxSize : 2;

  /**
  * String with the images name to include in the box. If multi-upload receive a String separated by ';'
  * Ex.: 2
  * @type {string}
  */
  var show_images = show_images != '' ? show_images : false;

  /**
  * width to show the image
  * Ex.: 2
  * @type {string}
  */
  var width = width != '' ? width : false;

  /**
  * height to show the image
  * Ex.: 2
  * @type {string}
  */
  var height = height != '' ? height : false;

  /**
  * an identifier of a standard file input element
  * Ex.: input-file
  * @type {string}
  */
  var fallback_id = fallback_id != '' ? fallback_id : false;

  /**
  * It's used to Referee to the Dropdown class instead another object
  * @type {object}
  */
  var _this = this;

  this.init = function(){

    dropbox.filedrop({
      fallback_id: fallback_id,
      url: '/upload/',
      paramname: 'image',
      data:{
        path: url
      },

      error: function(err, file) {
          switch(err) {
            case 'TooManyFiles':
              _this.notify('Muitos arquivos! Selecione no máximo ' + maxUploads + '!');
             break;
             case 'FileTooLarge':
              _this.notify(file.name + ' é muito grande! Tamanho máximo é de 2mb.');
             break;

             default:
             break;
          }
       },

      maxfiles: maxUploads,
      maxfilesize: maxSize,

      beforeEach: function(file){
          if(!file.type.match(/^image\//)){
            _this.notify('Envie apenas arquivos nos formatos .gif, .jpeg, .png.');
             return false;
          }

          if ($("#uploadResult li").length >= 5) {
            _this.notify("Máximo de " + maxUploads + " uploads");
            return false;
          };
      },

      dragOver: function () {},

      drop: function () {

        if(maxUploads == 1){
          if($('#image').val()){
             _this.remove_image($('#image').val());
          }
        }

        message.html('<span class="message">Aguarde</span>');

      },

      afterAll: function () {

          if (maxUploads > 1) {
             message.html('<span class="message">Imagens salvas com sucesso</span>');
          }else{
            message.html('<span class="message">Imagem salva com sucesso</span>');
          }

      },

      uploadFinished: function (i, file, response, time) {
          if (maxUploads > 1) {
             _this.insert_image_multi(response.file_name);
          }else{
             _this.insert_image(response.file_name);
          }
      }

    });

    //include the images already saved
    if(show_images){

       if(maxUploads > 1){
          _this.insert_image_multi(show_images);
       }else{
          //single image
          _this.insert_image(show_images);
       }

    }

    _this.dobind();
  }

   this.remove_image = function(image_name){
     $.ajax({
       url: '/upload/delete_image',
       type: 'POST',
       dataType: 'json',
       data: {
         image_name: image_name,
         path: url
       },
       success: function(data) {
         console.log('image removida com sucesso.');
       }
     });
     _this.dobind();
   }

   this.insert_image_multi = function(image_name){
    arr_image_name = image_name.split(";");

    $.each(arr_image_name, function(index, value){
      if(value != ''){
        var image_name = value;
        var image_url = show_url + '/' + image_name;

        uploadResult.append(
          '<li id="' + image_name + '" style="cursor:pointer;">' +
            '<img  src="' + image_url + '"><input type="hidden" name="images[]" value="' + image_name + '" />' +
          '</li>'
        );
      }
    });

     $('img', uploadResult).aeImageResize({height: height, width: width});
     _this.dobind();
   }

   this.insert_image = function(image_name) {

    if(image_name != '') {

     var image_url = show_url + "/" + image_name;

     if(uploadResultName != ''){
      uploadResult.attr('data-image', image_name);
      uploadResult.html('<img style="cursor:pointer;" src="'+image_url+'" width="'+width+'" ><input type="hidden" id="image" name="image" value="'+image_name+'" />');
      $("img", uploadResult).aeImageResize({ height: height, width: width });
     }else{
       dropbox.attr('data-image', image_name);
       dropbox.html('<img style="cursor:pointer;" src="'+image_url+'" width="'+width+'" ><input type="hidden" id="image" name="image" value="'+image_name+'" />');
       $("img", dropbox).aeImageResize({ height: height, width: width });
     }

     _this.dobind();

    }

   }

  this.insert_blank = function(){
    var obj;
    if(uploadResultName != ''){
      obj = uploadResult;
    }else{
      obj = dropbox;
    }
    obj.find('#image').remove();
    obj.html('<input type="hidden" id="image" name="image" value="0" />');
    $("img", obj).aeImageResize({ height: height, width: width });
    _this.dobind();
   }

    this.dobind = function () {
      //Option to delete the uploaded image
      //single upload
      var obj;
      if(uploadResultName != ''){
        obj = uploadResult;
      }else{
        obj = dropbox;
      }
      $(obj).unbind('click');
      if(maxUploads == 1){
        $(obj).bind('click', function(){
          if(confirm('Deseja remover a imagem?')){
            _this.remove_image($(this).attr('data-image'));
            $(this).find('img').remove();
            $(this).find('#image').remove();
            _this.insert_blank();
          }
        });
      }else{
        //multi upload
        $('li', uploadResult).unbind('click');
        $('li', uploadResult).bind('click', function(){
          if(confirm('Deseja remover a imagem?')){
           img_id = $(this).attr('id');
           $(this).remove();
            _this.remove_image(img_id);
            $('#'+img_id).remove();
          }
        });
      }
    },

    /**
     * Notify user
     *
     * @param  {string} message Message to be displayed
     * @param  {string} type    Type of the message (error, success, etc)
     */
    this.notify = function(message, type) {

      // Verify if any type was set up
      if(typeof type == 'undefined') type = 'error';

      // Notify user
      noty({
        type   : type,
        text   : message,
        layout : 'topLeft',
        timeout: 10000
      });

    }

   this.init();
}