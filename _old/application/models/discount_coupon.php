<?php

class Discount_Coupon extends DataMapper {

  public $table = 'discount_coupons';
  public $id;
  public $hash;
  public $value;
  public $type;
  public $min_sell_value;
  public $max_utilizations;
  public $start_date;
  public $end_date;
  public $description;
  public $create_date;
  public $update_date;
  public $delete_date;
  public $has_many = array(
      'order' => array(
          'class' => 'order',
          'other_field' => 'discount_coupon',
          'join_self_as' => 'discount_coupon',
          'join_other_as' => 'order',
          'join_table' => 'discount_coupons_orders')
  );

  function __construct($id = NULL) {
    parent::__construct($id);
  }

  function getUtilizations(){
    $orders = new Order();
    return $orders->where(array(
      'discount_coupon' => $this->id,
      'status' => 3
    ))
    ->count();
  }

}

?>
