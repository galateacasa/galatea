<?php

class Pagseguro_Post extends DataMapper {

  public $table = 'pagseguro_posts';
  public $id;
  public $function;
  public $notificationCode;
  public $notificationType;
  public $responseCode;
  public $create_date;

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

?>
