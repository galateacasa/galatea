<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Avaliation_texts extends CI_Migration {

  public $table = "avaliation_texts";
  public $fields = array(
    'id' => array(
      'type' => 'INT',
      'constraint' => 11,
      'unsigned' => TRUE,
      'auto_increment' => TRUE
      ),
    'avaliation' => array(
      'type' => 'VARCHAR',
      'constraint' => 100
      ),
    'text' => array(
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

/* End of file 032_avaliation_texts.php */
/* Location: ./application/migrations/032_avaliation_texts.php */
