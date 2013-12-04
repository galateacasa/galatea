<?php

class User_Vote extends DataMapper {

  public $table = 'user_votes';
  public $id;
  public $user_id;
  public $user_vote_id;
  public $create_date;
  public $delete_date;
  public $has_one = array(
    'user',
    'user_voted' => array(
        'class'       => 'user',
        'other_field' => 'user_voted'
      )
    );

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

?>
