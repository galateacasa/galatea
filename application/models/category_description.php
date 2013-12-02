<?php

class Category_Description extends DataMapper {

  public $table = 'categories_descriptions';
  public $id;
  public $parent_id;
  public $child_id;
  public $title;
  public $description;

  public $has_one = array('category');

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}
