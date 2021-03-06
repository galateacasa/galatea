<?php

  class Item_Variation_Measurement extends DataMapper
  {
    /**
     * Table name
     * @var string
     */
    public $table = 'item_variations_measurements';

    /**
     * Unique identifier
     * @var integer
     */
    public $id;

    /**
     * ID to refeers to the item table
     * @var integer
     */
    public $item_id;

    /**
     * Variation width
     * @var integer
     */
    public $width;

    /**
     * Variation height
     * @var integer
     */
    public $height;

    /**
     * Variation depth
     * @var integer
     */
    public $depth;

    /**
     * Variation aditional amount from supplier
     * @var float
     */
    public $additional_amount;

    /**
     * Variation aditional type (money or percentage)
     * @var integer
     */
    public $additional_type;

    /**
     * Variation cost
     * @var float
     */
    public $variation_cost;

    /**
     * Registry create date
     * @var MySQL Time Stamp (Y-m-d h:m:s)
     */
    public $create_date;

    /**
     * Registry update date
     * @var MySQL Time Stamp (Y-m-d h:m:s)
     */
    public $update_date;

    /**
     * Registry delete date
     * @var MySQL Time Stamp (Y-m-d h:m:s)
     */
    public $delete_date;

    /**
     * Table who have relationship
     * @var array
     */
    public $has_one = array('item');
    public $has_many = array('order_item');

    function __construct($id = NULL) {
      parent::__construct($id);
    }

  }

?>
