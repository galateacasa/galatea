<?
  class Item_Message extends DataMapper
  {
    /**
     * table name
     * @var string
     */
    public $table = 'item_messages';

    /**
     * One to one relationship
     * @var array
     */
    public $has_one = array(
      'item',
      'sender' => array(
        'class'        => 'user',
        'other_field'  => 'sender_item_message',
        'join_self_as' => 'sender'
      )
    );

    function __construct($id = NULL) {
      parent::__construct($id);
    }

  }
