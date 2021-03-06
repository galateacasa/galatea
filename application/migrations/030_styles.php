<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Styles extends CI_Migration {

  public $table = "styles";
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
    'description' => array(
      'type' => 'TEXT',
      'null' => TRUE
      ),
    'create_date' => array(
      'type' => 'DATETIME'
      ),
    'update_date' => array(
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

/* End of file 036_style.php */
/* Location: ./application/migrations/036_style.php */
