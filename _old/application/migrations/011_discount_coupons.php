<?php

class Migration_discount_coupons extends CI_Migration {

  public $table = "discount_coupons";
  public $fields = array(
      'id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE,
          'auto_increment' => TRUE
      ),
      'hash' => array(
          'type' => 'VARCHAR',
          'constraint' => 32
      ),
      'value' => array(
          'type' => 'DOUBLE',
          'constraint' => '10, 2'
      ),
      'type' => array(
          'type' => 'TINYINT',
          'constraint' => '1'
      ),
      'description' => array(
          'type' => 'TEXT'
      ),
      'min_sell_value' => array(
          'type' => 'DOUBLE',
          'constraint' => '10, 2',
          'null' => TRUE
      ),
      'max_utilizations' => array(
          'type' => 'INT',
          'constraint' => '11',
          'null' => TRUE
      ),
      'start_date' => array(
          'type' => 'DATETIME',
          'null' => TRUE
      ),
      'end_date' => array(
          'type' => 'DATETIME',
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
