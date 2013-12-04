<?php

class Avaliation_Text extends DataMapper {

  public $table = 'avaliation_texts';
  public $id;
  public $avaliation;
  public $text;
  public $create_date;

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

?>
