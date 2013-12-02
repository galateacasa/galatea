<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

  class Migration_Item_Messages extends CI_Migration
  {
    /**
     * Table name
     * @var string
     */
    public $table = "item_messages";

    /**
     * Table fields
     * @var array
     */
    public $fields = array(

      # ID
      'id' => array(
        'type'           => 'INT',
        'constraint'     => 11,
        'unsigned'       => TRUE,
        'auto_increment' => TRUE
      ),

      # Item ID who will receive the message
      'item_id' => array(
        'type'       => 'INT',
        'constraint' => 11
      ),

      # User ID who sent the message
      'sender_id' => array(
        'type'       => 'INT',
        'constraint' => 11
      ),

      # Message content
      'message' => array(
        'type' => 'TEXT',
        'null' => TRUE
      ),

      # Message parent ID in case of response
      'parent_id' => array(
        'type'       => 'INT',
        'constraint' => 11
      ),

      # Message type 1 = msg 2 = vote
      'type' => array(
        'type'       => 'INT',
        'constraint' => 1
      ),

      # Read date
      'read_date' => array(
        'type' => 'DATETIME',
        'null' => true
      ),

      # Create date
      'create_date' => array(
        'type' => 'DATETIME'
      ),

      # Delete date
      'delete_date' => array(
        'type' => 'DATETIME',
        'null' => true
      )

    );

    public function up()
    {
      $this->load->dbforge();

      $this->dbforge->add_field($this->fields);

      # Define primary key
      $this->dbforge->add_key('id', TRUE);

      # Define keys
      $this->dbforge->add_key('sender_id');

      $this->dbforge->create_table($this->table);
    }

    public function down() {
      $this->dbforge->drop_table($this->table);
    }

  }
?>
