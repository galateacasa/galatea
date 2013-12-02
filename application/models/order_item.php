<?php

class Order_Item extends DataMapper {

  public $table = 'order_items';
  public $id;
  public $order_id;
  public $item_id;
  public $qty;
  public $price;
  public $item_variation_material_id;
  public $item_variation_measurement_id;
  public $create_date;
  public $update_date;
  public $delete_date;
  public $has_one = array('order', 'item', 'item_variation_material', 'item_variation_measurement');

  public $has_many = array(
    'user_balance'    => array(),
    'supplier'        => array(
      'class'         => 'user',
      'other_field'   => 'item',
      'join_self_as'  => 'item',
      'join_other_as' => 'user',
      'join_table'    => 'items_suppliers'),
  );

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

?>
