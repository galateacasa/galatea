<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

  class Items_Supplier extends DataMapper
  {
    /**
     * Table name
     * @var string
     */
    public $table = 'items_suppliers';

    /**
     * Relationship many to many
     * @var array
     */
    public $has_many = array('item');
  }
  ?>
