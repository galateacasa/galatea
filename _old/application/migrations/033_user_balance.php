<?php

class Migration_user_balance extends CI_Migration {

  public $table = "user_balance";
  public $fields = array(
      'id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE,
          'auto_increment' => TRUE
      ),
      'user_id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE
      ),
      'order_id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE,
          'null' => TRUE
      ),
      'order_item_id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE,
          'null' => TRUE
      ),
      'ambiance_id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE,
          'null' => TRUE
      ),
      'tracking' => array(
          'type' => 'VARCHAR',
          'constraint' => 45,
          'null' => TRUE
      ),
      'status' => array(
          'type' => 'INT',
          'constraint' => 1
      ),
      'credit_recovery_id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE,
          'null' => TRUE
      ),
      'transaction_type' => array(
          'type' => 'INT',
          'constraint' => 11
      ),
      'value' => array(
          'type' => 'DOUBLE',
          'constraint' => '10, 2'
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
