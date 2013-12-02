<?php

class Migration_users extends CI_Migration {

  public $table = "users";
  public $fields = array(
      'id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE,
          'auto_increment' => TRUE
      ),
      'name' => array(
          'type' => 'VARCHAR',
          'constraint' => 100
      ),
      'surname' => array(
          'type' => 'VARCHAR',
          'constraint' => 100
      ),
      'company_name' => array(
          'type' => 'VARCHAR',
          'constraint' => 100,
          'null' => TRUE
      ),
      'description' => array(
          'type' => 'TEXT',
          'null' => TRUE
      ),
      'email' => array(
          'type' => 'VARCHAR',
          'constraint' => 100
      ),
      'password' => array(
          'type' => 'VARCHAR',
          'constraint' => 32,
          'null' => TRUE
      ),
      'role' => array(
          'type' => 'INT',
          'constraint' => 11
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
      'street' => array(
          'type' => 'VARCHAR',
          'constraint' => 100,
          'null' => TRUE
      ),
      'number' => array(
          'type' => 'VARCHAR',
          'constraint' => 10,
          'null' => TRUE
      ),
      'complement' => array(
          'type' => 'VARCHAR',
          'constraint' => 10,
          'null' => TRUE
      ),
      'district' => array(
          'type' => 'VARCHAR',
          'constraint' => 100,
          'null' => TRUE
      ),
      'country' => array(
          'type' => 'VARCHAR',
          'constraint' => 100,
          'null' => TRUE
      ),
      'zip' => array(
          'type' => 'VARCHAR',
          'constraint' => 45,
          'null' => TRUE
      ),
      'cpf' => array(
          'type' => 'VARCHAR',
          'constraint' => 45,
          'null' => TRUE
      ),
      'cnpj' => array(
          'type' => 'VARCHAR',
          'constraint' => 45,
          'null' => TRUE
      ),
      'rg' => array(
          'type' => 'VARCHAR',
          'constraint' => 45,
          'null' => TRUE
      ),
      'ie' => array(
          'type' => 'VARCHAR',
          'constraint' => 45,
          'null' => TRUE
      ),
      'email_confirmation_hash' => array(
          'type' => 'VARCHAR',
          'constraint' => 32,
          'null' => TRUE
      ),
      'keep_logged_hash' => array(
          'type' => 'VARCHAR',
          'constraint' => 32,
          'null' => TRUE
      ),
      'email_confirmed' => array(
          'type' => 'TINYINT',
          'constraint' => 1,
          'null' => TRUE,
          'default' => 0
      ),
      'state_id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE,
          'null' => TRUE
      ),
      'city_id' => array(
          'type' => 'INT',
          'constraint' => 11,
          'unsigned' => TRUE,
          'null' => TRUE
      ),
      'url' => array(
          'type' => 'VARCHAR',
          'constraint' => 100,
          'null' => TRUE
      ),
      'user_indication' => array(
          'type' => 'INT',
          'constraint' => 11,
          'null' => TRUE
      ),
      'image' => array(
          'type' => 'VARCHAR',
          'constraint' => 100,
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
