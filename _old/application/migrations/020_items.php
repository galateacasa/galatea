<?

  class Migration_items extends CI_Migration
  {
    /**
     * Table name
     * @var string
     */
    public $table = "items";

    /**
     * Table fields
     * @var array
     */
    public $fields = array(

      # Unique ID
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

      # Name of the project/product
      'name' => array(
        'type'       => 'VARCHAR',
        'constraint' => 100
      ),

      # Description of the project/product
      'description' => array(
        'type' => 'TEXT'
      ),

      # Status (0 = new, 1 = Aproved, 2 = Reproved)
      'status' => array(
        'type'       => 'TINYINT',
        'constraint' => 1,
        'desfault'   => 0 # Defaul status set as reproved
      ),

      'suggested_item_id' => array(
        'type'       => 'INT',
        'constraint' => 11,
        'unsigned'   => TRUE,
        'null'       => TRUE
      ),

      # Category that reefers to the product/project
      'category_id' => array(
        'type'       => 'INT',
        'constraint' => 11,
        'unsigned'   => TRUE
      ),

      # Type of item (1 = project, 2 = product)
      'type' => array(
        'type'       => 'TINYINT',
        'constraint' => 1
      ),

      # If the product have any parent (usually a project)
      'parent_project_id' => array(
        'type'       => 'INT',
        'constraint' => 11,
        'unsigned'   => TRUE,
        'null'       => TRUE
      ),

      # Price for production
      'production_price' => array(
        'type'       => 'DOUBLE',
        'constraint' => '10,2',
        'null'       => TRUE
      ),

      # Date when the product start to sell
      'start_sell_date' => array(
        'type' => 'DATETIME',
        'null' => TRUE
      ),

      # Date when the product stop to sell
      'end_sell_date' => array(
        'type' => 'DATETIME',
        'null' => TRUE
      ),

      # Number of days until devilery the product
      'delivery_time' => array(
        'type'       => 'INT',
        'constraint' => 11,
        'null'       => TRUE
      ),

      # Fare
      'delivery_cost' => array(
        'type'       => 'DOUBLE',
        'constraint' => '10,2',
        'null'       => TRUE
      ),

      # Date when the registry was created
      'create_date' => array(
        'type' => 'DATETIME'
      ),

      # Date when the registry was updated
      'update_date' => array(
        'type' => 'DATETIME',
        'null' => TRUE
      ),

      # Date when the registry was deleted
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
