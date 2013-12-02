<?php

  class Item_Denounce extends DataMapper
  {
    /**
     * Table name
     * @var string
     */
    public $table = 'item_denounces';

    /**
     * Denounce ID
     * @var integer
     */
    public $id;

    /**
     * User ID
     * @var integer
     */
    public $user_id;

    /**
     * Item ID
     * @var integer
     */
    public $item_id;

    /**
     * Create date
     * @var string
     */
    public $create_date;

    /**
     * Relationship reference
     * @var array
     */
    public $has_one = array('user', 'item');

    function __construct($id = NULL) {
      parent::__construct($id);
    }
  }

?>
