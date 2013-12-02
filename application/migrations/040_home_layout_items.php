<?php

class Migration_home_layout_items extends CI_Migration {

  public $table = "home_layout_items";
  public $fields = array(
    'id'           => array(
      'type'           => 'INT',
      'constraint'     => 11,
      'unsigned'       => TRUE,
      'null'           => FALSE,
      'auto_increment' => TRUE
    ),
    'home_layout_id'       => array(
      'type'       => 'INT',
      'constraint' => 11,
      'unsigned'   => TRUE,
      'null'       => FALSE
    ),
    'item_id'       => array(
      'type'       => 'INT',
      'constraint' => 11,
      'unsigned'   => TRUE,
      'null'       => FALSE
    )

  );

  public function up() {
    $this->load->dbforge();

    $this->dbforge->add_field($this->fields);

    $this->dbforge->add_key('id', TRUE);
    $this->dbforge->add_key('home_layout_id');
    $this->dbforge->add_key('item_id');

    $this->dbforge->create_table($this->table);
  }

  public function down() {
    $this->dbforge->drop_table($this->table);
  }

}
