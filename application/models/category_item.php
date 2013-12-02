<?php

class Category_Item extends DataMapper {

  public $table = 'categories_items';
  public $id;
  public $category_id;
  public $item_id;

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

?>
