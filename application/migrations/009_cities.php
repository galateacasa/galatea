<?php

class Migration_cities extends CI_Migration {

  public $table = "cities";
  public $fields = array(
      'id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE,
          'auto_increment' => TRUE
      ),
      'name' => array(
          'type' => 'VARCHAR',
          'constraint' => 100
      ),
      'reached_by_logistics' => array(
          'type' => 'INT',
          'constraint' => 1
      ),
      'state_id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE
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
