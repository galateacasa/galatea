<?php

class Expertise extends DataMapper {

  public $table = 'expertises';
  public $id;
  public $name;
  public $description;
  public $has_many = array(
      'user' => array(
        'class' => 'user',
        'other_field' => 'expertise',
        'join_self_as' => 'expertise',
        'join_other_as' => 'user',
        'join_table' => 'users_expertises'
      )
  );

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

?>
