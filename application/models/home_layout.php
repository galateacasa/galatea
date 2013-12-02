<?php

class Home_Layout extends DataMapper {

  public $table = 'home_layouts';

  public $has_one = array('ambiance', 'home_layout_type');

  public $has_many = array(
    'item' => array(                         // in the code, we will refer to this relation by using the object name 'item'
      'class'         => 'item',             // This relationship is with the model class 'item'
      'other_field'   => 'home_layout',      // in the Item model, this defines the array key used to identify this relationship
      'join_self_as'  => 'home_layout',      // foreign key in the (relationship)table identifying this models table. The column name would be 'author_id'
      'join_other_as' => 'item',             // foreign key in the (relationship)table identifying the other models table as defined by 'class'. The column name would be 'book_id'
      'join_table'    => 'home_layout_items' // name of the join table that will link both Author and Book together
    )
  );

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}
