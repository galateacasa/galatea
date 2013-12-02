<?php

class State extends DataMapper {

  public $table = 'states';
  public $id;
  public $name;
  public $acronym;
  public $has_many = array(
    'user',
    'city',
    'delivery_address',
    'disponibility_price_variation'
    ,'region' => array(
      'class' => 'region',
      'other_field' => 'state',
      'join_self_as' => 'state',
      'join_other_as' => 'region',
      'join_table' => 'regions_states')
    );

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

?>
