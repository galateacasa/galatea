<?
class Item_Status extends DataMapper {

  public $table = 'item_statuses';
  public $id;
  public $item_id;
  public $status;
  public $message;
  public $create_date;
  public $has_one = array('item');

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}
?>
