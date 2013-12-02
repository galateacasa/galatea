<?php

class Suggested_Item extends DataMapper {

  public $table = 'suggested_items';
  public $id;
  public $user_id;
  public $name;
  public $description;
  public $create_date;
  public $update_date;
  public $delete_date;
  public $has_one = array('user');
  public $has_many = array('suggested_item_image', 'item');

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

?>
