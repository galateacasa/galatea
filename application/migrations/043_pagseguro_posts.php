<?php if( !defined('BASEPATH') ) exit('No direct script access allowed');

  class Migration_Pagseguro_Posts extends CI_Migration
  {
    /**
     * Table name
     * @var string
     */
    public $table = "pagseguro_posts";

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

      # Function name called by the post
      'function' => array(
        'type'       => 'VARCHAR',
        'constraint' => 45,
        'null'       => true
      ),

      # Pagseguro notification code
      'notificationCode' => array(
        'type'       => 'VARCHAR',
        'constraint' => 45,
        'null'       => true
      ),

      # Pagseguro notification type
      'notificationType' => array(
        'type'       => 'VARCHAR',
        'constraint' => 45,
        'null'       => true
      ),

      # Pagseguro response code
      'responseCode' => array(
        'type'       => 'VARCHAR',
        'constraint' => 45,
        'null'       => true
      ),

      # Create date
      'create_date' => array(
        'type' => 'DATETIME'
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
