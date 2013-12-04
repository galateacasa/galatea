<?php

class Ambiance_Vote extends DataMapper {

  public $table = 'ambiance_votes';
  public $id;
  public $user_id;
  public $ambiance_id;
  public $create_date;
  public $delete_date;
  public $has_one = array('user', 'ambiance');

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

?>
