<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_User_votes extends CI_Migration {

  public $table = "user_votes";
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
    'user_voted_id' => array(
      'type' => 'INT',
      'constraint' => 11,
      'unsigned' => TRUE
      ),
    'create_date' => array(
      'type' => 'DATETIME'
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

/* End of file 038_user_votes.php */
/* Location: ./application/migrations/038_user_votes.php */
