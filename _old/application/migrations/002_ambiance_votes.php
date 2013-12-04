<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class Migration_Ambiance_votes extends CI_Migration
  {
    /**
     * Table name
     * @var string
     */
    public $table = "ambiance_votes";

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

      # User ID
      'user_id' => array(
        'type'       => 'INT',
        'constraint' => 11,
        'unsigned'   => TRUE
      ),

      # Ambiance ID
      'ambiance_id' => array(
        'type'       => 'INT',
        'constraint' => 11,
        'unsigned'   => TRUE
      ),

      # Create date
      'create_date' => array(
        'type' => 'DATETIME'
      ),

    );

    /**
     * Create tables
     * @return void
     */
    public function up() {
      $this->load->dbforge();

      $this->dbforge->add_field($this->fields);

      $this->dbforge->add_key('id', TRUE);

      $this->dbforge->create_table($this->table);
    }

    /**
     * Drop table
     * @return void
     */
    public function down() {
      $this->dbforge->drop_table($this->table);
    }

  }

?>
