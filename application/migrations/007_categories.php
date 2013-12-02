<?php

class Migration_categories extends CI_Migration {

  public $table = "categories";
  public $fields = array(
      'id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE,
          'auto_increment' => TRUE
      ),
      'parent_id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE,
          'null' => TRUE
      ),
      'name' => array(
          'type' => 'VARCHAR',
          'constraint' => 100
      ),
      'image' => array(
          'type' => 'VARCHAR',
          'constraint' => 100,
          'null' => TRUE
      ),
      'description' => array(
          'type' => 'TEXT',
          'null' => TRUE
      ),
      'create_date' => array(
          'type' => 'DATETIME'
      ),
      'update_date' => array(
          'type' => 'DATETIME',
          'null' => TRUE
      ),
      'delete_date' => array(
          'type' => 'DATETIME',
          'null' => TRUE
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
