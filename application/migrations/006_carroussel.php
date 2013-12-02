<?php

class Migration_carroussel extends CI_Migration {

  public $table = "carroussels";
  public $fields = array(
      'id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE,
          'auto_increment' => TRUE
      ),
      'image' => array(
          'type' => 'VARCHAR',
          'constraint' => 100
      ),
      'title' => array(
          'type' => 'VARCHAR',
          'constraint' => 100,
          'null' => true
      ),
      'description' => array(
          'type' => 'TEXT',
          'null' => true
      ),
      'link' => array(
          'type' => 'VARCHAR',
          'constraint' => 100,
          'null' => true
      ),
      'create_date' => array(
          'type' => 'DATETIME'
      ),
      'update_date' => array(
          'type' => 'DATETIME'
      ),
      'delete_date' => array(
          'type' => 'DATETIME'
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
