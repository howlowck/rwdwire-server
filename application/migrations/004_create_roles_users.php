<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Create_roles_users extends CI_Migration {  //change dbs to table name
 
    public function up()
    {
        $this->dbforge->add_field(array(
            
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
            'role_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => TRUE  
            )
        ));
        
        $this->dbforge->add_key('id', TRUE); // TRUE makes it primary
        $this->dbforge->add_key(array('role_id','user_id'));
        $this->dbforge->create_table('roles_users'); //change dbs to table name
    }

    public function down()
    {
        $this->dbforge->drop_table('roles_users'); //change dbs to table name
    }
}