<?php

class Migration_order_items extends CI_Migration {

  public $table = "order_items";
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
      'item_id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE
      ),
      'qty' => array(
          'type' => 'INT',
          'constraint' => 11
      ),
      'price' => array(
          'type' => 'DOUBLE',
          'constraint' => '10, 2'
      ),
      'item_variation_material_id' => array(
          'type' => 'INT',
          'constraint' => 11
      ),
      'item_variation_measurement_id' => array(
          'type' => 'INT',
          'constraint' => 11
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
