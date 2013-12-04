<?php

class Social_Login extends DataMapper {

  public $table = "social_logins";
  public $id;
  public $provider;
  public $uid;
  public $user_id;
  public $complement;
  public $district;
  public $city_id;
  public $zip;
  public $create_date;
  public $update_date;
  public $delete_date;
  public $has_one = array('user');

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

?>
