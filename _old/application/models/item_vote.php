<?php

class Item_Vote extends DataMapper {

  public $table = 'item_votes';
  public $id;
  public $user_id;
  public $item_id;
  public $create_date;
  public $delete_date;
  public $has_one = array('user', 'item');

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

?>
