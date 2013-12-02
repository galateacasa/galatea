<?php

class Migration_delivery_address extends CI_Migration {

  public $table = "delivery_address";
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
      'street' => array(
          'type' => 'VARCHAR',
          'constraint' => 100
      ),
      'number' => array(
          'type' => 'VARCHAR',
          'constraint' => 10
      ),
      'complement' => array(
          'type' => 'VARCHAR',
          'constraint' => 20,
          'null' => TRUE
      ),
      'areaCode' => array(
          'type' => 'INT',
          'constraint' => 2
          , 'null' => TRUE
      ),
      'phone' => array(
          'type' => 'VARCHAR',
          'constraint' => 10
          , 'null' => TRUE
      ),
      'country' => array(
          'type' => 'VARCHAR',
          'constraint' => 100,
          'null' => TRUE
      ),
      'district' => array(
          'type' => 'VARCHAR',
          'constraint' => 100
      ),
      'state_id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE
      ),
      'city_id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE
      ),
      'zip' => array(
          'type' => 'VARCHAR',
          'constraint' => 45
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
