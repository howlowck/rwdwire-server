<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Create_users extends CI_Migration {  //change dbs to table name
 
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
		    
		    // extra fields:
		    // 'netid' => array(
		    //     'type'       => 'VARCHAR',
		    //     'constraint' => 255,
		    //     'null'       => TRUE
		    // ),
		    // 'emplid' => array(
		    //     'type'       => 'VARCHAR',
		    //     'constraint' => 255,
		    //     'null'       => TRUE
		    // ),
		    'username' => array(
		        'type'       => 'VARCHAR',
		        'constraint' => 255,
		        'null'       => TRUE
		    ),
		    'first_name' => array(
		        'type'       => 'VARCHAR',
		        'constraint' => 255,
		        'null'       => TRUE
		    ),
		    'last_name' => array(
		        'type'       => 'VARCHAR',
		        'constraint' => 255,
		        'null'       => TRUE
		    ),
		    'email' => array(
		        'type'       => 'VARCHAR',
		        'constraint' => 255,
		        'null'       => TRUE
		    ),
		    'salt' => array(
		        'type'       => 'VARCHAR',
		        'constraint' => 255,
		        'null'       => TRUE
		    ),
		    'password_hash' => array(
		        'type'       => 'VARCHAR',
		        'constraint' => 255,
		        'null'       => TRUE
		    ),
		    'verif' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
			),
			'pass_reset' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
			)
		));
		
		$this->dbforge->add_key('id', TRUE); // TRUE makes it primary
		$this->dbforge->create_table('users');
	}

	public function down()
	{
		$this->dbforge->drop_table('users'); //change dbs to table name
	}
}
/* End of file 001_create_users.php */
/* Location: ./application/migrations/001_create_users.php */
