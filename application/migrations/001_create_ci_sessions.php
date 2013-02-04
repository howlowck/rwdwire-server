<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Create_Ci_Sessions extends CI_Migration {
 
	public function up()
	{
		$this->dbforge->add_field(array(

            'session_id' => array(
                'type'           => 'VARCHAR',
                'constraint'     => 40,
                'default' => '0',
                'null'           => FALSE
            ),
		    'ip_address' => array(
		        'type' => 'VARCHAR',
		        'constraint' => 45,
		        'default' => '0',
		        'null' => FALSE
		     ),
		    'user_agent' => array(
		        'type' => 'VARCHAR',
		        'constraint' => 120,
		        'null' => FALSE
		    ),
		    'last_activity' => array(
		        'type' => 'INT',
		        'constraint' => 10,
		        'unsigned' => TRUE,
		        'null' => FALSE,
		        'default' => 0    
		    ),
		    'user_data' => array(
		        'type' => 'TEXT',
		        'null' => FALSE,
		        'default' => NULL
		    )
		));
		
		$this->dbforge->add_key('session_id', TRUE); // TRUE makes it primary
		$this->dbforge->create_table('ci_sessions'); 
	}

	public function down()
	{
		$this->dbforge->drop_table('ci_sessions');
	}
}
/* End of file 002_create_ci_sessions.php */
/* Location: ./application/models/002_create_ci_sessions.php */
