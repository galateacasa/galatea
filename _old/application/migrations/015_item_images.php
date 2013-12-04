<?php

class Migration_item_images extends CI_Migration {

  public $table = "item_images";
  public $fields = array(
      'id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE,
          'auto_increment' => TRUE
      ),
      'item_id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE
      ),
      'image' => array(
          'type' => 'VARCHAR',
          'constraint' => 100
      ),
      'principal' => array(
          'type' => 'TINYINT',
          'constraint' => '1',
          'default' => 0
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
