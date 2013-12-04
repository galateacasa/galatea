<?php

class Migration_order_status extends CI_Migration {

  public $table = "order_statuses";
  public $fields = array(
      'id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE,
          'auto_increment' => TRUE
      ),
      'order_id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE
      ),
      'status' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE
      ),
      'create_date' => array(
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
