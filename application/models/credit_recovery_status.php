<?
class Credit_Recovery_Status extends DataMapper {

  public $table = 'credit_recovery_statuses';
  public $id;
  public $credit_recovery_id;
  public $status;

  public $has_one = array('credit_recovery');

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

/* End of file  */
/* Location: ./application/models/ */
?>
