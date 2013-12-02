<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

  class Migration_Item_votes extends CI_Migration
  {
    /**
     * Table name
     * @var string
     */
    public $table = "item_votes";

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

      # User who vote
      'user_id' => array(
        'type'       => 'INT',
        'constraint' => 11,
        'unsigned'   => TRUE
      ),

      # Item ID
      'item_id' => array(
        'type'       => 'INT',
        'constraint' => 11,
        'unsigned'   => TRUE
      ),

      # Create date
      'create_date' => array(
        'type' => 'DATETIME'
      ),

    );

    public function up()
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
