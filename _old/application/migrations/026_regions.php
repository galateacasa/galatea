<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Regions extends CI_Migration {

  public $table = "regions";
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

/* End of file 028_regions.php */
/* Location: ./application/migrations/028_regions.php */
