<?php

class Category extends DataMapper
{
  public $table = 'categories';
  public $id;
  public $parent_id;
  public $name;
  public $description;
  public $level;

  public $has_many = array('ambiance');

  public $has_one = array(
   'item' => array(
      'class'         => 'item',
      'other_field'   => 'category',
      'join_self_as'  => 'category',
      'join_other_as' => 'item',
      'join_table'    => 'categories_items'
    ),

    'parent' => array(
      'class'       => 'category',
      'other_field' => 'category',
      'reciprocal'  => TRUE
    ),

    'category' => array(
      'other_field' => 'parent',
      'reciprocal'  => TRUE
    ),

    'children' => array(
      'class'       => 'category',
      'other_field' => 'parent'
    ),

    'category' => array(
      'other_field' => 'category'
    )
  );

  function __construct($id = NULL) {
    parent::__construct($id);
  }
}
