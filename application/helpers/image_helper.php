<?php

// The function already exists?
if ( !function_exists('amazon_url') ) {

  /**
   * Return correctly path for images into Amazon S3 server.
   * Create imagens into the right dimenssions if needed
   *
   * @param  string  $path   Server path
   * @param  boolean $width  Specific image width
   * @param  boolean $height Specific image height
   * @return string          Public image URL
   */
  function amazon_url($path = '', $width = FALSE, $height = FALSE, $disableDefault = FALSE) {

    $ci = & get_instance();

    //LOAD S3 SDK
    $ci->load->library('s3', 's3');

    // Mount URL to the image in Amazon S3 server
    $bucket = $ci->config->item('s3_bucket');
    $ambient = $ci->config->item('s3_ambient');

    $publicURL = "http://$bucket.s3.amazonaws.com/$ambient/";

    // Remove image name from path
    $pathParts = pathinfo($path);

    $path = $pathParts['dirname'];

    // Separate image name from the image extension
    $image     = $pathParts['basename'];
    $name      = $pathParts['filename'];
    $extension = @$pathParts['extension'];

    // Amazon server path
    $serverPath = $ci->config->item('s3_ambient') . "/" . $path . "/";

    // The URL with the image doesn't exists?
    if( !@getimagesize($publicURL . "$path/$image") ) {

      // Is to set up default image?
      if ($disableDefault) {
        $path .= "/{$name}";
      }else{
        $name      = 'default';
        $extension = 'jpg';
        $image     = "$name.$extension";
      }

    }

    // Try to get the image in specified size
    if ($width and $height and !$disableDefault) {

      // The image exists?
      if( @getimagesize($publicURL . "$path/$name" . '_' . $width . '_' . "$height.$extension") ) {
        $image = $name . '_' . $width . '_' . "$height.$extension";
      }else{

        // Get image properties
        list($widthOriginal, $heightOriginal) = getimagesize($publicURL . "$path/$image");

        // Is necessary to resize image?
        if($widthOriginal > $width or $heightOriginal > $height)
        {
          // Download image
          $temporaryFolder = sys_get_temp_dir() . '/';

          // Copy image localy
          copy($publicURL . "$path/$image", $temporaryFolder . $image);

          // Specifications for image library
          {
            $config['image_library']  = 'gd2';
            $config['maintain_ratio'] = TRUE;
            $config['source_image']   = $temporaryFolder . $image;
            $imageNew                 = $name . '_' . $width . '_' . "$height.$extension";
            $config['new_image']      = $temporaryFolder . $imageNew;
            $config['width']          = $width;
            $config['height']         = $height;
          }

          // Load image library
          $ci->load->library('image_lib');

          // Clear queue before resizing image
          $ci->image_lib->clear();

          // Initialize library
          $ci->image_lib->initialize($config);

          // Resize image
          $ci->image_lib->resize();

          // Upload the image to Amazon S3 Server
          $ci->s3->putObjectFile(
            $config['new_image'],
            $bucket,
            $serverPath . $imageNew,
            S3::ACL_PUBLIC_READ
          );

          // Define new image as image
          $image = $imageNew;

        }

      }

    }

    // Check if is necessary to add image into the end
    $path = $disableDefault ? $path : "$path/$image";

    // Return the full URL
    return $publicURL . $path;

  }
}

/* End of file image_helper.php */
/* Location: ./application/helpers/image_helper.php */
?>
