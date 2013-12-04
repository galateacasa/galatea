<?php

class Migration_newsletters extends CI_Migration {

    public $table = "newsletters";
    public $fields = array(
        'id' => array(
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => TRUE,
            'auto_increment' => TRUE
        ),
        'email' => array(
            'type' => 'VARCHAR',
            'constraint' => 255
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
