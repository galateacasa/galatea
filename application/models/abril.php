<?php

class Abril extends DataMapper {

  public $table = 'abril';
  public $id;
  public $name;
  public $email;
  public $reason;

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}
