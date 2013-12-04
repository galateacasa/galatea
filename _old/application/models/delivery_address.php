<?php

class Delivery_Address extends DataMapper {

  public $table = "delivery_address";
  public $id;
  public $user_id;
  public $street;
  public $number;
  public $complement;
  public $district;
  public $country;
  public $state_id;
  public $city_id;
  public $zip;
  public $phone;
  public $areaCode;
  public $create_date;
  public $update_date;
  public $delete_date;
  public $has_one = array('state', 'city', 'user', 'order');

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

?>
