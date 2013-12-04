<?
class Ambiance_Status extends DataMapper {

  public $table = 'ambiance_statuses';
  public $id;
  public $ambiance_id;
  public $status;
  public $message;
  public $create_date;
  public $has_one = array('item');

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}
?>
