<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_roles extends CI_Migration {

	public function up()
	{
	    
	    $this->dbforge->add_field(array(
	        // all tables must have:
	        'id' => array(
	            'type'           => 'INT',
	            'constraint'     => 11,
	            'auto_increment' => TRUE,
	            'null'           => FALSE
	        ),
	        'created_at' => array(
	            'type'   => 'DATETIME',
	            'null'   => TRUE
	        ),
	        'updated_at' => array(
	            'type'   => 'DATETIME',
	            'null'   => TRUE
	        ),
	        
	        // extra fields
	        'name' => array(
	            'type' => 'VARCHAR',
	            'constraint' => 255,
	            'null' => TRUE
	        )
		));
		
	    $this->dbforge->add_key('id', TRUE); // TRUE makes it primary
		$this->dbforge->create_table('roles');
	}

	public function down()
	{
		$this->dbforge->drop_table('roles');
	}
}
