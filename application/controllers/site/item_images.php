<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_Images extends CI_Controller {

  public $path = "/images/items/";
  public $bucket;
  public $maxsize = 10000000;
  public $whitelist = array('image/gif', 'image/jpeg', 'image/jpeg', 'image/pjpeg', 'image/pjpeg', 'image/png');

  function upload_image() {
    $this->load->library('s3', 's3');
    if (!empty($_FILES)) {
      if (isset($_FILES['image'])) {
        if ($_FILES["image"]["size"] <= $this->maxsize) {
          if (in_array($_FILES['image']['type'], $this->whitelist)) {
            $img = $_FILES['image']['tmp_name'];
            $filename = $_FILES['image']['name'];
            $basename = substr($filename, 0, strripos($filename, '.'));
            $ext = substr($filename, strripos($filename, '.'));
            $name = uniqid() . $ext;
            $fullpath = $this->config->item('s3_ambient').$this->path;
            if ($this->s3->putObjectFile($img, $this->config->item('s3_bucket'), $fullpath . $name, S3::ACL_PUBLIC_READ)) {
              echo json_encode(array('status' => 'ok', 'file_name' => $name));
              die();
            }else{
              echo json_encode(array('status' => "Error" ));
              die();
            }
          }else{
            echo json_encode(array('status'=>"FileTypeNotAllowed"));
            die();
          }
        }else{
          echo json_encode(array('status'=>"FileTooLarge"));
          die();
        }
      }
    }
  }

  function delete_image(){
    $this->load->library('s3', 's3');
    $fullpath = $this->config->item('s3_ambient').$this->path;
    $image = $this->input->post('image');

    $this->s3->deleteObject($this->config->item('s3_bucket'), $fullpath . $image);

    $item_image = new Item_Image();
    $item_image->where('image',$image)->get();
    if($item_image->exists()){
      $item_image->delete();
    }

    echo json_encode(array('status' => 'true'));
  }

}

/* End of file item_images.php */
/* Location: ./application/controllers/site/item_images.php */
