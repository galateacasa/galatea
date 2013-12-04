<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_User_Expertises extends CI_Migration {

  public $table = "users_expertises";
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
    'expertise_id' => array(
      'type' => 'INT',
      'constraint' => 11
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

/* End of file 035_user_expertise.php */
/* Location: ./application/migrations/035_user_expertise.php */
