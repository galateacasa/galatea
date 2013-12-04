<?php

class User_Expertise extends DataMapper {

  public $table = 'users_expertises';
  public $id;
  public $user_id;
  public $expertise_id;
  function __construct($id = NULL) {
    parent::__construct($id);
  }


}

?>
