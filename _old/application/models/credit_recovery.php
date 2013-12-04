<?
class Credit_Recovery extends DataMapper {

  public $table = 'credit_recovery';
  public $id;
  public $user_id;
  public $value;
  public $name;
  public $cnpj;
  public $bank;
  public $account;
  public $agency;
  public $status;
  public $fiscal;
  public $has_one = array('user', 'user_balance');
  public $has_manhy = array('credit_recovery_status');

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

/* End of file  */
/* Location: ./application/models/ */
?>
