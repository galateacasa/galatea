<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Ambiance_statuses extends CI_Migration {

  public $table = "ambiance_statuses";
  public $fields = array(
    'id' => array(
      'type' => 'INT',
      'constraint' => 11,
      'unsigned' => TRUE,
      'auto_increment' => TRUE
      ),
    'ambiance_id' => array(
      'type' => 'INT',
      'constraint' => 11,
      'unsigned' => TRUE
      ),
    'status' => array(
      'type' => 'INT',
      'constraint' => 11
      ),
    'message' => array(
      'type' => 'TEXT',
      'null' => TRUE
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

/* End of file 040_ambiance_statuses.php */
/* Location: ./application/migrations/040_ambiance_statuses.php */
