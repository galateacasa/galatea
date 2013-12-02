<?php

class Migration_home_layout_types extends CI_Migration {

  public $table = "home_layout_types";
  public $fields = array(
    'id'           => array(
      'type'           => 'INT',
      'constraint'     => 11,
      'unsigned'       => TRUE,
      'null'           => FALSE,
      'auto_increment' => TRUE
    ),
    'name'       => array(
      'type'       => 'VARCHAR',
      'constraint' => 100,
      'null'       => FALSE
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
