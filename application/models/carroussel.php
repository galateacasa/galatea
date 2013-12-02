<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Carroussel extends DataMapper {

  public $table = 'carroussels';
  public $id;
  public $image;
  public $title;
  public $description;
  public $link;
  public $create_date;
  public $update_date;
  public $delete_date;
}

/* End of file carroussel.php */
/* Location: ./application/models/carroussel.php */
