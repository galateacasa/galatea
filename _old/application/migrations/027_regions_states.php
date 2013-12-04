<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Regions_states extends CI_Migration {

  public $table = "regions_states";
  public $fields = array(
    'id' => array(
      'type' => 'INT',
      'constraint' => 11,
      'unsigned' => TRUE,
      'auto_increment' => TRUE
      ),
    'region_id' => array(
      'type' => 'INT',
      'constraint' => 11,
      'unsigned' => TRUE
      ),
    'state_id' => array(
      'type' => 'INT',
      'constraint' => 11,
      'unsigned' => TRUE
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

/* End of file 029_region_states.php */
/* Location: ./application/migrations/029_region_states.php */
