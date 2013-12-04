<?php

class Item_Image extends DataMapper {

  public $table = 'item_images';
  public $id;
  public $item_id;
  public $image;
  public $principal;
  public $create_date;
  public $update_date;
  public $delete_date;
  public $has_one = array('item');

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

?>
