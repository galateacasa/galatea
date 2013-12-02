<?php

class Order extends DataMapper {

  public $table = 'orders';
  public $id;
  public $user_id;
  public $payment_code;
  public $payment_method;
  public $estimated_delivery_date;
  public $delivery_date;
  public $delivery_address_id;
  public $discount_coupon_value;
  public $discount_coupon_id;
  public $status;
  public $create_date;
  public $update_date;
  public $delete_date;

  public $has_one = array('user', 'delivery_address');
  public $has_many = array(
      'order_status' => array(),
      'user_balance' => array(),
      'order_item' => array(),
      'item' => array(
        'class' => 'item',
        'other_field' => 'order',
        'join_self_as' => 'order',
        'join_other_as' => 'item',
        'join_table' => 'order_item'),
      'discount_coupon' => array(
          'class' => 'discount_coupon',
          'other_field' => 'order',
          'join_self_as' => 'order',
          'join_other_as' => 'discount_coupon',
          'join_table' => 'discount_coupons_orders')
  );

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}
?>
