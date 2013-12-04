<?
class User_Balance extends DataMapper {

  public $table = 'user_balance';
  public $user_id;
  public $order_id;
  public $order_item_id;
  public $ambiance_id;
  public $credit_recovery_id;
  public $transaction_type;
  public $value;
  public $tracking;
  public $status;
  public $create_date;
  public $update_date;
  public $delete_date;
  public $has_one = array('user', 'order', 'credit_recovery', 'order_item', 'ambiance');

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

/* End of file  */
/* Location: ./application/models/ */
?>
