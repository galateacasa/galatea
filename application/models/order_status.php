<?php

class Order_Status extends DataMapper {

  public $table = 'order_statuses';
  public $id;
  public $order_id;
  public $status;
  public $create_date;
  public $has_one = array('order');

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

?>
