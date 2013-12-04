<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

  class Migration_User_Roles extends CI_Migration
  {
    /**
     * Table name
     * @var string
     */
    public $table = "user_roles";

    /**
     * Table fields
     * @var array
     */
    public $fields = array(

      # ID
      'id' => array(
        'type'           => 'INT',
        'constraint'     => 11,
        'unsigned'       => TRUE,
        'auto_increment' => TRUE
      ),

      # Role ID
      'function' => array(
        'type'       => 'INT',
        'constraint' => 11
      ),

      # Description of the role type
      'description' => array(
        'type'       => 'VARCHAR',
        'constraint' => 30
      )
    );

    public function up()
    {
      $this->load->dbforge();

      $this->dbforge->add_field($this->fields);

      # Define primary key
      $this->dbforge->add_key('id', TRUE);

      $this->dbforge->create_table($this->table);
    }

    public function down() {
      $this->dbforge->drop_table($this->table);
    }

  }
?>
