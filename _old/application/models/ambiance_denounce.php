<?php

  class Ambiance_Denounce extends DataMapper
  {
    /**
     * Table name
     * @var string
     */
    public $table = 'ambiance_denounces';

    /**
     * Field ID
     * @var integer
     */
    public $id;

    /**
     * Field user ID
     * @var integer
     */
    public $user_id;

    /**
     * Field ambiance ID
     * @var integer
     */
    public $ambiance_id;

    /**
     * Field create date
     * @var string
     */
    public $create_date;

    /**
     * Relationship declaration
     * @var array
     */
    public $has_one = array('user', 'ambiance');

    function __construct($id = NULL) {
      parent::__construct($id);
    }

  }

?>
