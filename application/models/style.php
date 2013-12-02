<?php

class Style extends DataMapper {

  public $table = 'styles';
  public $id;
  public $name;
  public $image;
  public $description;
  public $has_one = array("item");

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

?>
