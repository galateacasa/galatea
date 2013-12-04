<?php

class Migration_credit_recovery extends CI_Migration {

  public $table = "credit_recovery";
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
          'unsigned' => TRUE,
      ),
      'value' => array(
          'type' => 'DECIMAL',
          'constraint' => '10,2'
      ),
      'name' => array(
          'type' => 'VARCHAR',
          'constraint' => 100
      ),
      'cnpj' => array(
          'type' => 'VARCHAR',
          'constraint' => 45
      ),
      'bank' => array(
          'type' => 'VARCHAR',
          'constraint' => 100
      ),
      'account' => array(
          'type' => 'VARCHAR',
          'constraint' => 45
      ),
      'agency' => array(
          'type' => 'VARCHAR',
          'constraint' => 45
      ),
      'status' => array(
          'type' => 'INT',
          'constraint' => 11
      ),
      'fiscal' => array(
          'type' => 'VARCHAR',
          'constraint' => 100
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
