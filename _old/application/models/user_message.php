<?
class User_Message extends DataMapper {

  public $table = 'user_messages';
  public $id;
  public $user_id;
  public $sender_id;
  public $parent_id;
  public $type;
  public $create_date;
  public $read_date;
  public $message;
  public $delete_date;
  public $has_one = array(
    'user',
    'sender' => array(
        'class'       => 'user',
        'other_field' => 'sender'
    )
  );

  function __construct($id = NULL) {
    parent::__construct($id);
  }

}

/* End of file  */
/* Location: ./application/models/ */
