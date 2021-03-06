<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Create_layouts extends CI_Migration {
	public function up() {
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

		    // custom columns:
			'url' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
				),
			
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
				),
			
			'width' => array(
				'type' => 'TEXT',
				'null' => TRUE,
				),
			
			'element' => array(
				'type' => 'MEDIUMTEXT',
				'null' => TRUE,
				),
			
			'user_id' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
				),
			
			'creator_id' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
				),
			));
		$this->dbforge->add_key('id', TRUE); // TRUE makes it primary
		$this->dbforge->add_key(array('url','user_id'));
		$this->dbforge->create_table('layouts');
	}
		public function down() {
			$this->dbforge->drop_table('layouts');
		}
	}
/* End of file 006_create_layout.php */