<?php

  class Migration_ambiances extends CI_Migration
  {
    /**
     * Table name
     * @var string
     */
    public $table = "ambiances";

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

      # User ID
      'user_id' => array(
        'type'       => 'INT',
        'constraint' => 11,
        'unsigned'   => TRUE
      ),

      # Title
      'title' => array(
        'type'       => 'VARCHAR',
        'constraint' => 100
      ),

      # Image
      'image' => array(
        'type'       => 'VARCHAR',
        'constraint' => 100
      ),

      # Create date
      'create_date' => array(
        'type' => 'DATETIME'
      ),

      # Update date
      'update_date' => array(
          'type' => 'DATETIME',
          'null' => TRUE
      ),

      # Delete date
      'delete_date' => array(
          'type' => 'DATETIME',
          'null' => TRUE
      ),

      # Status
      'status' => array(
        'type'       => 'int',
        'constraint' => 11
      ),

      # Category ID
      'category_id' => array(
        'type'       => 'INT',
        'constraint' => 11,
        'unsigned'   => TRUE,
        'null'       => TRUE
      )

    );

    public function up() {
      $this->load->dbforge();

      $this->dbforge->add_field($this->fields);

      $this->dbforge->add_key('id', TRUE);

      $this->dbforge->create_table($this->table);
    }

    public function down() {
      $this->dbforge->drop_table($this->table);
    }

  }

?>
