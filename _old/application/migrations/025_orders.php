<?php

class Migration_orders extends CI_Migration {

  public $table = "orders";
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
      'payment_code' => array(
          'type' => 'VARCHAR',
          'constraint' => 255
      ),
      'payment_method' => array(
          'type' => 'INT',
          'constraint' => 11
      ),
      'discount_coupon_value' => array(
        'type'       => 'DOUBLE',
        'constraint' => '10,2',
        'null' => TRUE
      ),
      'discount_coupon_id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'null' => TRUE
      ),
      'delivery_address_id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'null' => TRUE
      ),
      'estimated_delivery_date' => array(
          'type' => 'DATETIME',
          'null' => TRUE
      ),
      'delivery_date' => array(
          'type' => 'DATETIME',
          'null' => TRUE
      ),
      'status' => array(
          'type' => 'INT',
          'constraint' => 1
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
