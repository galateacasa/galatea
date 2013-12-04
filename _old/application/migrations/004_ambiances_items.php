<?php

class Migration_ambiances_items extends CI_Migration {

  public $table = "ambiances_items";
  public $fields = array(
      'id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE,
          'auto_increment' => TRUE
      ),
      'ambiance_id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE
      ),
      'item_id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE
      ),
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
