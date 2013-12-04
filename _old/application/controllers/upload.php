<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Everything about uploading files
 *
 * PHP 5.3+
 *
 * @category Galatea
 * @package Controllers
 * @author Diogo Lacerda <diogo.lacerda@gmail.com>
 * @author Arthur Duarte <arthur@aduarte.net>
 * @see CI_Controller
 */
class Upload extends CI_Controller
{
  public $path;
  public $bucket;
  public $fullpath;
  public $maxsize = 10000000;
  public $whitelist = array('image/gif', 'image/jpeg', 'image/jpeg', 'image/pjpeg', 'image/pjpeg', 'image/png');
  public $image_name;

  public function __construct()
  {
    parent::__construct();

    $this->load->library('s3', 's3');

    $this->path       = $this->input->get_post('path', TRUE);
    $this->bucket     = $this->config->item('s3_bucket');
    $this->fullpath   = $this->config->item('s3_ambient') . "/" . $this->path . "/";
    $this->image_name = $this->input->post('image_name');
  }

  public function index()
  {
    if ( !$this->session->userdata('id') ) {
      echo json_encode( array('status' => 'Acesse a loja com seus dados para que seja possível subir imagens') );
      exit();
    }

    if (!isset($_FILES['image'])) {
      echo json_encode(array('status' => 'Error'));
      die();
    }

    if ($_FILES["image"]["size"] > $this->maxsize) {
      echo json_encode(array('status'=>"FileTooLarge"));
      die();
    }

    if (!in_array($_FILES['image']['type'], $this->whitelist)) {
      echo json_encode(array('status'=>"FileTypeNotAllowed"));
      die();
    }

    // The file was upload?
    if ( is_uploaded_file($_FILES['image']['tmp_name']) ) {

      // Image definitions
      {
        $img      = $_FILES['image']['tmp_name'];
        $filename = $_FILES['image']['name'];
        $basename = substr($filename, 0, strripos($filename, '.'));
        $ext      = substr($filename, strripos($filename, '.'));
        $name     = uniqid() . $ext;
      }

      // Define temporary folder
      $temporary = sys_get_temp_dir() . "/$name";

      // Move file to a temporary folder to have a backup in case of failure
      move_uploaded_file($_FILES['image']['tmp_name'], $temporary);

      // Upload file to Amazon S3 Server
      $upload = $this->s3->putObjectFile($temporary, $this->bucket, $this->fullpath . $name, S3::ACL_PUBLIC_READ);

      // The file was saved into amazon S3?
      if ($upload) {

        // Gives the return string
        echo json_encode( array('status' => 'ok', 'file_name' => $name) );

        // Remove remporary file
        exec("rm $temporary");

      }else{
        echo json_encode( array('status' => "Ocorreu um erro ao salvar a imagem.") );
      }

    }

  }

  /**
   * Upload an image to Amazon S3 Bucket
   *
   * @access public
   * @return JSON Data about image into Amazon S3
   */
  public function upload_from_url()
  {
    // Headers from image URL
    $imageHeaders = @get_headers( $this->input->get('image_url') );

    // The URL exists?
    if($imageHeaders[0] != 'HTTP/1.1 404 Not Found') {

      // Define images allowed extensions
      $allowedExtensions = array('jpeg', 'jpg', 'gif', 'png');

      // Get image information
      $extension = pathinfo($this->input->get('image_url'), PATHINFO_EXTENSION);

      // Is the file an image?
      if( in_array($extension, $allowedExtensions) ) {

        // Generate new image name with extensio
        $name = md5( uniqid( rand(), TRUE ) ) . ".$extension";

        // Define temporary folder
        $temporary = sys_get_temp_dir() . "/$name";

        // Copy image from the URL to the temporary path
        copy( $this->input->get('image_url'), $temporary);

        // Upload image to Amazon S3 Server
        $upload = $this->s3->putObjectFile($temporary, $this->bucket, $this->fullpath . $name, S3::ACL_PUBLIC_READ);

        // Check if the image was uploaded
        if ($upload) {
          $result['status']  = 'success';
          $result['message'] = 'Imagem salva com sucesso!';
          $result['url']     = amazon_url("images/ambiances/$name");
          $result['name']    = $name;
        }else{
          $result['status']  = 'error';
          $result['message'] = 'Ocorreu um erro ao salvar sua mensagem, entre em contato com a Galaatea.';
        }

      }else{
        $result['status']  = 'error';
        $result['message'] = 'A URL deve conter apenas a sua imagem.';
      }

    }else{
      $result['status']  = 'error';
      $result['message'] = 'Adicione uma URL válida.';
    }

    // Send result
    echo json_encode($result);

  }

  /**
   * Delete an imagem at Amazon S3 Bucket
   *
   * @access public
   * @return void
   */
  public function delete_image() {
    $this->s3->deleteObject($this->bucket, $this->fullpath . $this->image_name);
  }

}

/* End of file upload.php */
/* Location: ./application/controllers/upload.php */
?>
