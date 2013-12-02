<?php

class City extends DataMapper {

  public $table = 'cities';
  public $id;
  public $name;
  public $state_id;
  public $reached_by_logistics;
  public $has_one = array('state');
  public $has_many = array('user', 'delivery_address', 'disponibility_price_variation');

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

?>
