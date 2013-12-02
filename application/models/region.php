<?php

class Region extends DataMapper {

  public $table = 'regions';
  public $id;
  public $name;
  public $has_many = array(
      'state' => array(
          'class' => 'state',
          'other_field' => 'region',
          'join_self_as' => 'region',
          'join_other_as' => 'state',
          'join_table' => 'regions_states')
  );

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

?>
