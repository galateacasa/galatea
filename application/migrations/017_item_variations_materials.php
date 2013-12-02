<?php

class Migration_item_variations_materials extends CI_Migration {

  public $table = "item_variations_materials";
  public $fields = array(

    'id' => array(
      'type'           => 'INT',
      'constraint'     => 11,
      'unsigned'       => TRUE,
      'auto_increment' => TRUE
    ),

    'item_id' => array(
      'type'       => 'INT',
      'constraint' => 11,
      'unsigned'   => TRUE
    ),

    'material' => array(
      'type'       => 'VARCHAR',
      'constraint' => 100
    ),

    'variation_cost' => array(
      'type'       => 'DOUBLE',
      'constraint' => '10,2',
      'null' => TRUE
    ),

    'additional_amount' => array(
      'type'       => 'DOUBLE',
      'constraint' => '10,2',
      'null' => TRUE
    ),

    'additional_type' => array(
      'type'       => 'TINYINT',
      'constraint' => 1,
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
