<?php

class Suggested_Item_Image extends DataMapper {

  public $table = 'suggested_item_images';
  public $id;
  public $suggested_item_id;
  public $image;
  public $principal;
  public $create_date;
  public $update_date;
  public $delete_date;
  public $has_one = array('suggested_item');

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

?>
