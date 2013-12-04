<?php

class Capture extends DataMapper {

  public $table = 'captures';
  public $id;
  public $email;

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}
