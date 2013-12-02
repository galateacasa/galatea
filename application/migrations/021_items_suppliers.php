<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

  class Migration_Items_Suppliers extends CI_Migration
  {
    /**
     * Table name
     * @var string
     */
    public $table = 'items_suppliers';

    /**
     * Table fields
     * @var array
     */
    public $fields = array(

      # Unique ID
      'id' => array(
        'type'           => 'INT',
        'constraint'     => 11,
        'unsigned'       => TRUE,
        'auto_increment' => TRUE
      ),

      # ID of user who's a supplier (type 2)
      'user_id' => array(
        'type'       => 'INT',
        'constraint' => 11,
        'unsigned'   => TRUE
      ),

      # ID of an item that's a product (type 2)
      'item_id' => array(
        'type'       => 'INT',
        'constraint' => 11,
        'unsigned'   => TRUE
      ),

      # Monthly production
      'production_amount' => array(
        'type'       => 'INT',
        'constraint' => 11,
        'null'       => TRUE
      )

    );

    function up()
    {
      $this->load->dbforge();

      $this->dbforge->add_field($this->fields);

      $this->dbforge->add_key('id', TRUE);

      $this->dbforge->create_table($this->table);
    }

    public function down() {
      $this->dbforge->drop_table($this->table);
    }

  }
